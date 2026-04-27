<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Throwable;

class Helper
{
    public static function contentDirection(): string
    {
        return env('APP_CONTENT_DIRECTION', 'ltr');
    }

    public static function viteAsset(string $path): string
    {
        $normalized = ltrim($path, '/');

        if (Str::startsWith($normalized, 'img/')) {
            return asset('images/' . substr($normalized, 4));
        }

        if (Str::startsWith($normalized, 'images/')) {
            return asset($normalized);
        }

        $source = self::legacyAssetSource($normalized);

        if ($source === null) {
            return asset($normalized);
        }

        try {
            return Vite::asset($source);
        } catch (Throwable $exception) {
            return asset($normalized);
        }
    }

    protected static function legacyAssetSource(string $path): ?string
    {
        $normalized = ltrim($path, '/');

        $exactMatches = [
            'css/app.css' => 'resources/css/app.css',
            'css/core.css' => 'resources/sass/core.scss',
            'css/overrides.css' => 'resources/sass/overrides.scss',
            'css/custom-rtl.css' => 'resources/sass/base/custom-rtl.scss',
            'css/plugins.css' => 'resources/assets/scss/plugins.css',
            'css/style.css' => 'resources/assets/scss/style.scss',
            'css/style-rtl.css' => 'resources/assets/scss/style-rtl.scss',
        ];

        if (isset($exactMatches[$normalized])) {
            return $exactMatches[$normalized];
        }

        if (Str::startsWith($normalized, 'css/base/')) {
            return 'resources/sass/' . Str::replaceLast('.css', '.scss', substr($normalized, 4));
        }

        if (Str::startsWith($normalized, 'js/')) {
            return 'resources/' . $normalized;
        }

        if (Str::startsWith($normalized, 'vendors/css/')) {
            return 'resources/' . $normalized;
        }

        if (Str::startsWith($normalized, 'vendors/js/')) {
            return 'resources/' . $normalized;
        }
        if (Str::startsWith($normalized, 'img/') || Str::startsWith($normalized, 'images/')) {
            return null;
        }

        if (Str::startsWith($normalized, 'fonts/')) {
            return 'resources/fonts/' . substr($normalized, 6);
        }

        if (Str::startsWith($normalized, 'data/')) {
            return 'resources/data/' . substr($normalized, 5);
        }

        return null;
    }

    public static function applClasses()
    {
        $data = config('custom.custom');

        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static',
            'layoutWidth' => 'full',
            'showMenu' => true,
            'bodyClass' => '',
            'bodyStyle' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'en',
            'direction' => self::contentDirection(),
        ];

        $data = array_merge($DefaultData, $data);

        $allOptions = [
            'mainLayoutType' => ['vertical', 'horizontal'],
            'theme' => ['light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'],
            'sidebarCollapsed' => [true, false],
            'showMenu' => [true, false],
            'layoutWidth' => ['full', 'boxed'],
            'navbarColor' => ['bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'],
            'horizontalMenuType' => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'],
            'horizontalMenuClass' => ['static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'],
            'verticalMenuNavbarType' => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'],
            'navbarClass' => ['floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'],
            'footerType' => ['static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'],
            'pageHeader' => [true, false],
            'contentLayout' => ['default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'],
            'blankPage' => [false, true],
            'sidebarPositionClass' => ['content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'],
            'contentsidebarClass' => ['content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'],
            'defaultLanguage' => ['es' => 'es', 'en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'],
            'direction' => ['ltr', 'rtl'],
        ];

        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    if (is_string($data[$key])) {
                        if (isset($data[$key]) && $data[$key] !== null) {
                            if (!array_key_exists($data[$key], $value)) {
                                $result = array_search($data[$key], $value, true);
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => 'menu-expanded',
            'bodyClass' => $data['bodyClass'],
            'bodyStyle' => $data['bodyStyle'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];

        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = 'menu-collapsed';
        }

        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = 'blank-page';
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $fullURL = request()->fullurl();
        if (app()->environment() === 'production') {
            for ($i = 1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if ($contains === true) {
                    $demo = 'demo-' . $i;
                }
            }
        }
        if (isset($pageConfigs) && count($pageConfigs) > 0) {
            foreach ($pageConfigs as $config => $val) {
                Config::set('custom.' . $demo . '.' . $config, $val);
            }
        }
    }
}
