@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Error!')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
<!-- Error page-->
<div class="misc-wrapper">
  <a class="brand-logo" href="javascript:void(0);">
    <img src="{{ asset(mix('img/logo_2.jpg')) }}" style="max-width: 36px;"/>
    <h2 class="brand-text text-primary ml-1" style="margin-top:7px;">MB Design Studio</h2>
  </a>
  <div class="misc-inner p-2 p-sm-3">
    <div class="w-100 text-center">
      <h2 class="mb-1">No se encontro el {{ $modelName }} solicitado 🕵🏻‍♀️</h2>
      <p class="mb-2">Perdón! 😖 Al parecer no se encontro lo que solicitabas.</p>
      <a class="btn btn-primary mb-2 btn-sm-block" href="{{route('admin')}}">Volver al inicio</a>

      @if($configData['theme'] === 'dark')
      <img class="img-fluid" src="{{asset('images/pages/error-dark.svg')}}" alt="Error page" />
      @else
      <img class="img-fluid" src="{{asset('images/pages/error.svg')}}" alt="Error page" />
      @endif
    </div>
  </div>
</div>
<!-- / Error page-->
@endsection
