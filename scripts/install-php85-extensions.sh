#!/usr/bin/env bash

if [ -z "${BASH_VERSION:-}" ]; then
  if command -v bash >/dev/null 2>&1; then
    exec bash "$0" "$@"
  fi

  echo "This script requires bash. Run it with: bash $0" >&2
  exit 1
fi


set -Eeuo pipefail

trap 'echo "Error on line ${LINENO}: ${BASH_COMMAND}" >&2' ERR

if [[ "${EUID}" -ne 0 ]]; then
  if command -v sudo >/dev/null 2>&1; then
    exec sudo -E bash "$0" "$@"
  fi

  echo "Run this script as root or with sudo: sudo bash $0" >&2
  exit 1
fi

export DEBIAN_FRONTEND=noninteractive

PHP_VERSION="${PHP_VERSION:-8.5}"
NODE_MAJOR="${NODE_MAJOR:-24}"

readonly PHP_VERSION NODE_MAJOR

PHP_PACKAGES=(
  "php${PHP_VERSION}-cli"
  "php${PHP_VERSION}-common"
  "php${PHP_VERSION}-readline"
  "php${PHP_VERSION}-bcmath"
  "php${PHP_VERSION}-bz2"
  "php${PHP_VERSION}-curl"
  "php${PHP_VERSION}-dba"
  "php${PHP_VERSION}-ffi"
  "php${PHP_VERSION}-ftp"
  "php${PHP_VERSION}-gd"
  "php${PHP_VERSION}-gmp"
  "php${PHP_VERSION}-igbinary"
  "php${PHP_VERSION}-imagick"
  "php${PHP_VERSION}-imap"
  "php${PHP_VERSION}-intl"
  "php${PHP_VERSION}-ldap"
  "php${PHP_VERSION}-mbstring"
  "php${PHP_VERSION}-mysql"
  "php${PHP_VERSION}-pgsql"
  "php${PHP_VERSION}-redis"
  "php${PHP_VERSION}-soap"
  "php${PHP_VERSION}-sqlite3"
  "php${PHP_VERSION}-xml"
  "php${PHP_VERSION}-xsl"
  "php${PHP_VERSION}-zip"
  "php${PHP_VERSION}-zstd"
)

log() {
  printf '\n[%s] %s\n' "$(date -u +%Y-%m-%dT%H:%M:%SZ)" "$*"
}

require_apt() {
  if ! command -v apt-get >/dev/null 2>&1; then
    echo "This installer only supports Debian/Ubuntu systems with apt-get." >&2
    exit 1
  fi
}

validate_inputs() {
  if [[ ! "${PHP_VERSION}" =~ ^[0-9]+\.[0-9]+$ ]]; then
    echo "Invalid PHP_VERSION: ${PHP_VERSION}" >&2
    exit 1
  fi

  if [[ ! "${NODE_MAJOR}" =~ ^[0-9]+$ ]]; then
    echo "Invalid NODE_MAJOR: ${NODE_MAJOR}" >&2
    exit 1
  fi
}

detect_os() {
  if [[ ! -r /etc/os-release ]]; then
    echo "Cannot detect the operating system because /etc/os-release is missing." >&2
    exit 1
  fi

  # shellcheck disable=SC1091
  source /etc/os-release

  OS_ID="${ID:-}"
  OS_PRETTY_NAME="${PRETTY_NAME:-Unknown Linux}"
}

install_base_dependencies() {
  log "Installing base dependencies"
  apt-get update
  apt-get install -y --no-install-recommends \
    software-properties-common \
    ca-certificates \
    lsb-release \
    apt-transport-https \
    curl \
    gnupg
}

configure_php_repository() {
  case "${OS_ID}" in
    ubuntu)
      if ! grep -Rqs 'ppa.launchpadcontent.net/ondrej/php' /etc/apt/sources.list /etc/apt/sources.list.d 2>/dev/null; then
        log "Adding Ondrej PHP repository for Ubuntu"
        add-apt-repository -y ppa:ondrej/php
      fi
      ;;
    debian)
      log "Adding Sury PHP repository for Debian"
      curl -sSLo /tmp/debsuryorg-archive-keyring.deb https://packages.sury.org/debsuryorg-archive-keyring.deb
      dpkg -i /tmp/debsuryorg-archive-keyring.deb
      printf 'deb [signed-by=/usr/share/keyrings/debsuryorg-archive-keyring.gpg] https://packages.sury.org/php/ %s main\n' "$(lsb_release -sc)" \
        > /etc/apt/sources.list.d/php.list
      ;;
    *)
      echo "Unsupported distribution: ${OS_PRETTY_NAME}. This script supports Ubuntu/Debian EC2 instances." >&2
      exit 1
      ;;
  esac
}

configure_node_repository() {
  log "Configuring NodeSource repository for Node.js ${NODE_MAJOR}.x"
  install -d -m 0755 /etc/apt/keyrings
  curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
    | gpg --dearmor --yes -o /etc/apt/keyrings/nodesource.gpg
  printf 'deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_%s.x nodistro main\n' "${NODE_MAJOR}" \
    > /etc/apt/sources.list.d/nodesource.list
}

purge_old_php_packages() {
  local packages=()

  mapfile -t packages < <(
    dpkg-query -W -f='${Package}\n' 2>/dev/null \
      | grep -E '^(php([0-9]+\.[0-9]+.*|-.*|$)|libapache2-mod-php[0-9]+\.[0-9]+)$' \
      | grep -v -E "^php${PHP_VERSION}($|-)|^libapache2-mod-php${PHP_VERSION}$" \
      | sort -u || true
  )

  if ((${#packages[@]})); then
    log "Purging previous PHP packages"
    apt-get purge -y "${packages[@]}"
  fi
}

purge_old_node_packages() {
  local packages=()

  mapfile -t packages < <(
    dpkg-query -W -f='${Package}\n' 2>/dev/null \
      | grep -E '^(nodejs|nodejs-doc|npm|libnode[0-9]+|libnode-dev|node-gyp)$' \
      | sort -u || true
  )

  if ((${#packages[@]})); then
    log "Purging previous Node.js packages"
    apt-get purge -y "${packages[@]}"
  fi
}

install_php_packages() {
  log "Installing PHP ${PHP_VERSION} and extensions"
  apt-get install -y --no-install-recommends "${PHP_PACKAGES[@]}"
}

install_node_packages() {
  log "Installing Node.js ${NODE_MAJOR}.x"
  apt-get install -y --no-install-recommends nodejs
}
run_with_system_node_path() {
  PATH="/usr/bin:/usr/sbin:/bin:/sbin:${PATH}" "$@"
}

set_php_alternatives() {
  declare -A alternatives=(
    [php]="/usr/bin/php${PHP_VERSION}"
    [phar]="/usr/bin/phar${PHP_VERSION}"
    [phar.phar]="/usr/bin/phar.phar${PHP_VERSION}"
    [phpize]="/usr/bin/phpize${PHP_VERSION}"
    [php-config]="/usr/bin/php-config${PHP_VERSION}"
  )

  for name in "${!alternatives[@]}"; do
    if [[ -x "${alternatives[${name}]}" ]]; then
      update-alternatives --set "${name}" "${alternatives[${name}]}" >/dev/null 2>&1 || true
    fi
  done
}

print_summary() {
  echo
  echo "Installed PHP ${PHP_VERSION}:"
  php -v
  echo
  echo "Loaded PHP modules:"
  php -m | sort
  echo
  echo "Installed Node.js:"
  run_with_system_node_path node -v
  run_with_system_node_path npm -v
}

main() {
  require_apt
  validate_inputs
  detect_os

  log "Running installer on ${OS_PRETTY_NAME}"
  install_base_dependencies
  configure_php_repository
  configure_node_repository

  log "Refreshing package indexes"
  apt-get update

  purge_old_php_packages
  purge_old_node_packages

  log "Cleaning orphaned dependencies from older PHP/Node installs"
  apt-get autoremove -y

  install_php_packages
  install_node_packages
  set_php_alternatives

  if command -v corepack >/dev/null 2>&1; then
    run_with_system_node_path corepack enable
  fi

  print_summary
}

main "$@"
