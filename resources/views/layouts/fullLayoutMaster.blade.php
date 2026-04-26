@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp
<html lang="es" data-textdirection="{{ $configData['direction'] === 'rtl' ? 'rtl' : 'ltr' }}" class="{{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') - mb. design studio</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ Helper::viteAsset('images/logo/favicon.ico') }}">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')
</head>

<body class="vertical-layout vertical-menu-modern {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['theme'] === 'dark' ? 'dark-layout' : 'light' }}"
    data-menu="vertical-menu-modern" data-layout="{{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}" style="{{ $configData['bodyStyle'] }}" data-framework="laravel" data-asset-path="{{ asset('/') }}">

  <div class="app-content content {{ $configData['pageClass'] }}" style="margin-left: 0;padding: 0;">
    <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
      <div class="content-body">
        @yield('content')
      </div>
    </div>
  </div>

  @include('panels/scripts')

  <script type="text/javascript">
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14,
        });
      }
    });
  </script>
</body>

</html>
