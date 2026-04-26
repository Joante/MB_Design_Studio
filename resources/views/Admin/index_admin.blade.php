@extends('layouts/contentLayoutMaster')

@section('title', 'Admin')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ Helper::viteAsset('vendors/css/charts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ Helper::viteAsset('vendors/css/extensions/toastr.min.css') }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ Helper::viteAsset('css/base/pages/dashboard-ecommerce.css') }}">
  <link rel="stylesheet" href="{{ Helper::viteAsset('css/base/plugins/charts/chart-apex.css') }}">
  <link rel="stylesheet" href="{{ Helper::viteAsset('css/base/plugins/extensions/ext-component-toastr.css') }}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ Helper::viteAsset('vendors/js/charts/apexcharts.min.js') }}"></script>
  <script src="{{ Helper::viteAsset('vendors/js/extensions/toastr.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ Helper::viteAsset('js/scripts/pages/dashboard-ecommerce.js') }}"></script>
@endsection
