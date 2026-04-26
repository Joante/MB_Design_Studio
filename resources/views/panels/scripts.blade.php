{{-- Vendor Scripts --}}
<script src="{{ Helper::viteAsset('vendors/js/vendors.min.js') }}"></script>
<script src="{{ Helper::viteAsset('vendors/js/ui/prism.min.js') }}"></script>
{{-- Theme Scripts --}}
<script src="{{ Helper::viteAsset('js/core/app-menu.js') }}"></script>
<script src="{{ Helper::viteAsset('js/core/app.js') }}"></script>
@yield('vendor-script')
{{-- page script --}}
@yield('page-script')
