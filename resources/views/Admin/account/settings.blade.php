@extends('layouts/contentLayoutMaster')

@section('title', 'Configuracion de Cuenta')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <x-head.tinymce-config/>
@endsection

@section('content')
<!-- account setting page -->
<section id="page-account-settings">
  <div class="row">
    <!-- left menu section -->
    <div class="col-md-3 mb-2 mb-md-0">
      <ul class="nav nav-pills flex-column nav-left">
        <!-- general -->
        <li class="nav-item">
          <a class="nav-link @if(!$errors->any() || $errors->has('image') || $errors->has('username') || $errors->has('name')) active @endif" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
            <i data-feather="user" class="font-medium-3 mr-1"></i>
            <span class="font-weight-bold">General</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($errors->any() || $errors->has('description') || $errors->has('type')) active @endif" id="account-pill-information" data-toggle="pill" href="#account-vertical-information" aria-expanded="false">
            <i data-feather="info" class="font-medium-3 mr-1"></i>
            <span class="font-weight-bold">Informacion</span>
          </a>
        </li>
        <!-- change password -->
        <li class="nav-item">
          <a class="nav-link @if($errors->has('actual_password') || $errors->has('password')) active @endif" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
            <i data-feather="lock" class="font-medium-3 mr-1"></i>
            <span class="font-weight-bold">Cambiar Contraseña</span>
          </a>
        </li>
        <!-- social -->
        <li class="nav-item">
          <a class="nav-link @if ($errors->any()) @if(!$errors->has('actual_password') || !$errors->has('password') || !$errors->has('image') || !$errors->has('username') || !$errors->has('name')) active @endif @endif" id="account-pill-social" data-toggle="pill" href="#account-vertical-social" aria-expanded="false">
            <i data-feather="link" class="font-medium-3 mr-1"></i>
            <span class="font-weight-bold">Redes Sociales</span>
          </a>
        </li>
      </ul>
    </div>
    <!--/ left menu section -->

    <!-- right content section -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <div class="tab-content">
            <!-- general tab -->
            <div role="tabpanel" class="tab-pane @if(!$errors->any() || $errors->has('image') || $errors->has('username') || $errors->has('name')) active @else fade @endif" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
              <!-- header media -->
              <div class="media">
                <a href="javascript:void(0);" class="mr-25">
                  @if (count(Auth::user()->images) == 0)
                    <img src="{{asset('img/600x600.jpg')}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80"/>    
                  @else 
                    <img src="{{asset(Auth::user()->images[0]->location)}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80"/>  
                  @endif
                </a>
                <!-- upload and reset button -->
                <div class="media-body mt-75 ml-1">
                  @error('image')
                      <div class="alert alert-danger" style="display: inline-block;">{{ $message }}</div>
                  @enderror
                  <form action="{{ route('avatar_update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75" id="btn_edit_image">Cambiar Imagen</label>
                    <input type="file" id="account-upload" hidden accept="image/*" name="image"/>
                    <button class="btn btn-sm btn-primary mb-75 mr-75" style="display:none;" type="submit" id="btn_update_image">Guardar</button>
                    <button class="btn btn-sm btn-outline-secondary mb-75 mr-75" style="display:none;" type="button" id="btn_cancel_image"><span>Cancelar</span></button>     
                  </form>
                </div>
                <!--/ upload and reset button -->
                <button class="btn add-new btn-primary mt-50" style="margin-left: auto;order: 2;" type="button" id="btn_edit_info"><span>Editar</span></button>
              </div>
              <!--/ header media -->

              <!-- form -->
              <div id="form_edit_info" style="margin-top: 20px; display:none;">
                <form action="{{ route('admin_update') }}" method="POST">
                    @csrf
                    <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-username">Usuario</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="account-username" name="username" placeholder="Usuario" required value="{{ old('username', Auth::user()->username) }}"/>
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-name">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="account-name" name="name" placeholder="Nombre" value="{{ old('name', Auth::user()->name) }}"/>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="account-decription">Descripcion</label>
                          <textarea class="form-control @error('description') is-invalid @enderror" id="account-description" name="description" placeholder="Descripcion">{{ old('description', Auth::user()->description) }}</textarea>
                          @error('description')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-2 mr-1">Guardar</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2" id="btn_cancel_info">Cancelar</button>
                    </div>
                    </div>
                </form>
              </div>
              <!--/ form -->
                <div style="margin-top: 20px;" id="div_info">
                    <div class="row d-flex justify-content-center">
                    <div class="col-12 col-sm-3">
                        <div class="row d-flex align-items-center" style="margin:0 auto;">
                            <span class="font-weight-bold mb-0">Usuario:</span>
                            <p class="mb-0" style="margin-left: 15px;">{{ Auth::user()->username }}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="row d-flex align-items-center" style="margin:0 auto;">
                            <span class="font-weight-bold mb-0">Nombre:</span>
                            <p class="mb-0" style="margin-left: 15px;">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            
            <!--/ general tab -->

            <div class="tab-pane @if($errors->has('about') || $errors->has('description') || $errors->has('type')) active @else fade @endif" id="account-vertical-information" role="tabpanel" aria-labelledby="account-pill-information" aria-expanded="false">
              <!-- form -->
              <form action="{{ route('update_about') }}" method="POST">
                @csrf 
                <div class="row justify-content-center">
                  <div class="col-12 justify-content-center" style="display: flex;">
                    <h2>About</h2>
                  </div>
                  <div class="col-12 col-sm-8">
                    <div class="form-group">
                        <label for="texteditor">About</label>
                        <textarea id="texteditor" name="about" class="form-control @error('about') is-invalid @enderror">{!! old('about', $about) !!} </textarea>
                        @error('about')
                          <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="col-12 justify-content-center" style="display: flex;">
                  <button type="submit" class="btn btn-primary mr-1 mt-1">Guardar</button>
                  <button type="reset" class="btn btn-outline-secondary mt-1">Cancelar</button>
                </div>
              </form>

                <!-- edit degree modal -->
                <div class="modal fade" id="editDegreeModal" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Editar Titulo</h5>
                        <button type="button" class="btn editClose" aria-label="Close"><i data-feather='x'></i></button>
                      </div>
                      <div class="modal-body">
                        <form method="POST" id="editDegreeForm">
                          @csrf
                          <div class="row">
                            <div class="col mb-3">
                              <div class="form-group">
                                <label for="editDescription" class="form-label">Descripcion</label>
                                <textarea id="editDescription" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Descripcion" required></textarea>
                                  @error('description')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col mb-0">
                              <div class="form-group">
                                <label for="editType">Tipo</label>
                                <select class="custom-select" id="editType" name="type" required>
                                    <option value="course">Curso</option>
                                    <option value="bachelor">Carrera</option>
                                </select>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary waves-effect editClose" data-bs-dismiss="modal" fdprocessedid="gnd0jv">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" fdprocessedid="jhss92">Guardar</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>

                <!-- create degree modal -->
                <div class="modal fade" id="createDegreeModal" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Crear Titulo</h5>
                        <button type="button" class="btn createClose" aria-label="Close"><i data-feather='x'></i></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route('store_degree') }}" method="POST">
                          @csrf
                          <div class="row">
                            <div class="col mb-3">
                              <div class="form-group">
                                <label for="description" class="form-label">Descripcion</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Descripcion" required></textarea>
                                  @error('description')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col mb-0">
                              <div class="form-group">
                                <label for="type">Tipo</label>
                                <select class="custom-select" id="type" name="type" required>
                                    <option value="course" selected>Curso</option>
                                    <option value="bachelor">Carrera</option>
                                </select>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary waves-effect createClose" data-bs-dismiss="modal" fdprocessedid="gnd0jv">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" fdprocessedid="jhss92">Guardar</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
              <!--/ form -->
            </div>
            <!-- change password -->
            <div class="tab-pane @if($errors->has('actual_password') || $errors->has('password')) active @else fade @endif" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
              <!-- form -->
              <form action="{{ route('change_password') }}" method="POST">
                @csrf 
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-old-password">Contraseña Actual</label>
                      <div class="input-group form-password-toggle input-group-merge">
                        <input type="password" minlength="8" class="form-control @error('actual_password') is-invalid @enderror" id="account-old-password" name="actual_password" placeholder="Contraseña Actual" required/>
                        <div class="input-group-append">
                          <div class="input-group-text cursor-pointer">
                            <i data-feather="eye"></i>
                          </div>
                        </div>
                      </div>
                      @error('actual_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-new-password">Contraseña Nueva</label>
                      <div class="input-group form-password-toggle input-group-merge">
                        <input type="password" minlength="8" id="account-new-password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña Nueva" required/>
                        <div class="input-group-append">
                          <div class="input-group-text cursor-pointer">
                            <i data-feather="eye"></i>
                          </div>
                        </div>
                      </div>
                      @error('password')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-retype-new-password">Confirmar Nueva Contraseña</label>
                      <div class="input-group form-password-toggle input-group-merge">
                        <input type="password" minlength="8" class="form-control @error('password_confirmation') is-invalid @enderror" id="account-retype-new-password" name="password_confirmation" placeholder="Nueva Contraseña" required/>
                        <div class="input-group-append">
                          <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                        </div>
                      </div>
                      @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary mr-1 mt-1">Guardar</button>
                    <button type="reset" class="btn btn-outline-secondary mt-1">Cancelar</button>
                  </div>
                </div>
              </form>
              <!--/ form -->
            </div>
            <!--/ change password -->

            <!-- social -->
            <div class="tab-pane @if ($errors->any()) @if(!$errors->has('actual_password') || !$errors->has('password') || !$errors->has('image') || !$errors->has('username') || !$errors->has('name') || !$errors->has('description') || !$errors->has('type')) active @else fade @endif @else fade @endif" id="account-vertical-social" role="tabpanel" aria-labelledby="account-pill-social" aria-expanded="false">
                <div class="row">
                  <!-- social header -->
                  <div class="col-12">
                    <div class="d-flex align-items-center mb-2">
                      <i data-feather="link" class="font-medium-3"></i>
                      <h4 class="mb-0 ml-75">Redes Sociales de MB Design Studio</h4>
                      <button class="btn add-new btn-primary mt-50" style="margin-left: auto;order: 2; @if ($errors->any()) @if(!$errors->has('actual_password') || !$errors->has('password') || !$errors->has('image') || !$errors->has('username') || !$errors->has('name')) display:none; @endif @endif" type="button" id="btn_edit_social"><span>Editar</span></button>
                    </div>
                  </div>
                </div>
                <div id="div-social" style="@if ($errors->any()) @if(!$errors->has('actual_password') || !$errors->has('password') || !$errors->has('image') || !$errors->has('username') || !$errors->has('name')) display:none; @endif @endif">
                <div class="col-12">
                  <div class="row">
                  <!-- email link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block;">Email:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->email }}</p>
                    </div>
                  </div>
                  <!-- twitter link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block">Twitter:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->twitter }}</p>
                    </div>
                  </div>
                  <!-- facebook link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block">Facebook:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->facebook }}</p>
                    </div>
                  </div>
                  <!-- linkedin link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block">Linkedin:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->linkedin }}</p>
                    </div>
                  </div>
                  <!-- instagram link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block">Instagram:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->instagram }}</p>
                    </div>
                  </div>
                  <!-- Whats app link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block">Whats App:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->whats_app }}</p>
                    </div>
                  </div>
                  <!-- Pinterest link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <h6 class="font-weight-bold mb-0" style="display: inline-block">Pinterest:</h6>
                      <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $mbAcounts->pinterest }}</p>
                    </div>
                  </div>
                </div>
                </div>
                  <!-- divider -->
                  <div class="col-12">
                    <hr class="my-2" />
                  </div>

                  <div class="col-12 mt-1">
                    <!-- profile connection header -->
                    <div class="d-flex align-items-center mb-3">
                      <i data-feather="user" class="font-medium-3"></i>
                      <h4 class="mb-0 ml-75">Redes Sociales Personales</h4>
                    </div>

                    <div class="row">
                      <!-- email link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block">Email:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->email }}</p>
                        </div>
                      </div>
                      <!-- twitter link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block">Twitter:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->twitter }}</p>
                        </div>
                      </div>
                      <!-- facebook link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block;">Facebook:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->facebook }}</p>
                        </div>
                      </div>
                      <!-- linkedin link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block">Linkedin:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->linkedin }}</p>
                        </div>
                      </div>
                      <!-- instagram link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block">Instagram:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->instagram }}</p>
                        </div>
                      </div>
                      <!-- Whats app link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block">Whats App:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->whats_app }}</p>
                        </div>
                      </div>
                      <!-- Pinterest link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <h6 class="font-weight-bold mb-0" style="display: inline-block">Pinterest:</h6>
                          <p class="mb-0" style="margin-left: 15px;display: inline-block;">{{ $perAcounts->pinterest }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- form -->
                <form action="{{ route('update_socials') }}" method="POST" id="social-form" style="@if ($errors->any()) @if(!$errors->has('actual_password') || !$errors->has('password') || !$errors->has('image') || !$errors->has('username') || !$errors->has('name')) display:block; @else display:none; @endif @else display:none; @endif">
                  @csrf
                <div class="col-12">
                  <div class="row">
                  <!-- email link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-email">Email</label>
                      <input type="email" id="account-email" class="form-control @error('mb_email') is-invalid @enderror" name="mb_email" placeholder="Agregar Email" value="{{ old('mb_email',$mbAcounts->email) }}"/>
                      @error('mb_email')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- twitter link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-twitter">Twitter</label>
                      <input type="text" id="account-twitter" class="form-control @error('mb_twitter') is-invalid @enderror" name="mb_twitter" placeholder="Agregar Cuenta" value="{{ old('mb_twitter',$mbAcounts->twitter) }}"/>
                      @error('mb_twitter')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- facebook link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-facebook">Facebook</label>
                      <input type="text" id="account-facebook" class="form-control @error('mb_facebook') is-invalid @enderror" placeholder="Agregar Cuenta" name="mb_facebook" value="{{ old('mb_facebook',$mbAcounts->facebook) }}"/>
                      @error('mb_facebook')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- linkedin link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-linkedin">LinkedIn</label>
                      <input type="text" id="account-linkedin" class="form-control @error('mb_linkedin') is-invalid @enderror" placeholder="Agregar Cuenta" name="mb_linkedin" value="{{ old('mb_linkedin',$mbAcounts->linkedin) }}" value="https://www.linkedin.com"/>
                      @error('mb_linkedin')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- instagram link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-instagram">Instagram</label>
                      <input type="text" id="account-instagram" class="form-control @error('mb_instagram') is-invalid @enderror" name="mb_instagram" value="{{ old('mb_instagram',$mbAcounts->instagram) }}" placeholder="Agregar Cuenta" />
                      @error('mb_instagram')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- Whats app link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-whatsapp">Whats App</label>
                      <input type="number" minlength="10" id="account-whatsapp" class="form-control @error('mb_phone') is-invalid @enderror" value="{{ old('mb_phone',$mbAcounts->whats_app) }}" name="mb_phone" placeholder="Numero de Telefono sin 15 con codigo de area" />
                      @error('mb_phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- Pinterest link input -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="account-pinterest">Pinterest</label>
                      <input type="text" id="account-pinterest" class="form-control @error('mb_pinterest') is-invalid @enderror" value="{{ old('mb_pinterest',$mbAcounts->pinterest) }}" name="mb_pinterest" placeholder="Agregar Cuenta" />
                      @error('mb_pinterest')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                </div>
                  <!-- divider -->
                  <div class="col-12">
                    <hr class="my-2" />
                  </div>

                  <div class="col-12 mt-1">
                    <!-- profile connection header -->
                    <div class="d-flex align-items-center mb-3">
                      <i data-feather="user" class="font-medium-3"></i>
                      <h4 class="mb-0 ml-75">Redes Sociales Personales</h4>
                    </div>

                    <div class="row">
                      <!-- email link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-email">Email</label>
                          <input type="email" id="account-email" class="form-control @error('personal_email') is-invalid @enderror" name="personal_email" placeholder="Agregar Email" value="{{ old('personal_email',$perAcounts->email) }}"/>
                          @error('personal_email')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <!-- twitter link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-twitter">Twitter</label>
                          <input type="text" id="account-twitter" class="form-control @error('personal_twitter') is-invalid @enderror" name="personal_twitter" placeholder="Agregar Cuenta" value="{{ old('personal_twitter',$perAcounts->twitter) }}"/>
                          @error('personal_twitter')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <!-- facebook link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-facebook">Facebook</label>
                          <input type="text" id="account-facebook" class="form-control @error('personal_facebook') is-invalid @enderror" placeholder="Agregar Cuenta" name="personal_facebook" value="{{ old('personal_facebook',$perAcounts->facebook) }}"/>
                          @error('personal_facebook')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <!-- linkedin link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-linkedin">LinkedIn</label>
                          <input type="text" id="account-linkedin" class="form-control @error('personal_linkedin') is-invalid @enderror" placeholder="Agregar Cuenta" name="personal_linkedin" value="{{ old('personal_linkedin',$perAcounts->linkedin) }}" value="https://www.linkedin.com"/>
                          @error('personal_linkedin')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <!-- instagram link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-instagram">Instagram</label>
                          <input type="text" id="account-instagram" class="form-control @error('personal_instagram') is-invalid @enderror" name="personal_instagram" value="{{ old('personal_instagram',$perAcounts->instagram) }}" placeholder="Agregar Cuenta" />
                          @error('personal_instagram')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <!-- Whats app link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-whatsapp">Whats App</label>
                          <input type="number" minlength="10" id="account-whatsapp" class="form-control @error('personal_phone') is-invalid @enderror" value="{{ old('personal_phone',$perAcounts->whats_app) }}" name="personal_phone" placeholder="Numero de Telefono sin 15 con codigo de area" />
                          @error('personal_phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <!-- Pinterest link input -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="account-pinterest">Pinterest</label>
                          <input type="text" id="account-pinterest" class="form-control @error('personal_pinterest') is-invalid @enderror" value="{{ old('personal_pinterest',$perAcounts->pinterest) }}" name="personal_pinterest" placeholder="Agregar Cuenta" />
                          @error('personal_pinterest')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <!-- submit and cancel button -->
                      <button type="submit" class="btn btn-primary mr-1 mt-1">Guardar</button>
                      <button type="reset" id="btn_cancel_social" class="btn btn-outline-secondary mt-1">Cancelar</button>
                    </div>
                </form>
              </div>
              <!--/ form -->
            </div>
            <!--/ social -->
          </div>
        </div>
      </div>
    </div>
    <!--/ right content section -->
  </div>
</section>
<!-- / account setting page -->
@endsection

@section('vendor-script')
  <!-- vendor files -->
  {{-- select2 min js --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  {{--  jQuery Validation JS --}}
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/pages/page-account-settings.js')) }}"></script>
  <script>
      var oldSource;
      window.onload = function() {
        oldSource = document.getElementById('account-upload-img').src;
      };

      var btnEditImage = document.getElementById('btn_edit_image');
      var btnSaveImage = document.getElementById('btn_update_image');
      var btnCancelImage = document.getElementById('btn_cancel_image');
      var inputImage = document.getElementById('account-upload');
      var accountImage = document.getElementById('account-upload-img');
      

      btnEditImage.addEventListener('click', function() {
        inputImage.addEventListener('change', function() {
          btnEditImage.setAttribute('style', 'display:none;');
          btnSaveImage.setAttribute('style', 'display:inline-block;');
          btnCancelImage.setAttribute('style', 'display:inline-block;');
        });
      });

      btnCancelImage.addEventListener('click', function(){
        btnEditImage.setAttribute('style', 'display:inline-block;');
        btnSaveImage.setAttribute('style', 'display:none;');
        btnCancelImage.setAttribute('style', 'display:none;');
        inputImage.value = '';
        var oldImage = @json(Auth::user()->images);
        if(oldImage.length != 0) {
          accountImage.src = oldSource;
        } else {
          accountImage.src = @json(asset('img/600x600.jpg'));
        }
      });

      ////////////////
      
      var btnEditInfo = document.getElementById('btn_edit_info');
      var btnCancelInfo = document.getElementById('btn_cancel_info');
      var formEditInfo = document.getElementById('form_edit_info');
      var divInfo = document.getElementById('div_info');
      btnEditInfo.addEventListener('click', function () {
          btnEditInfo.setAttribute('style', 'margin-left: auto;order: 2;display:none;');
          formEditInfo.setAttribute('style', 'margin-top: 20px; display:block;');
          divInfo.setAttribute('style', 'margin-top:20px;display:none;');
      });

      btnCancelInfo.addEventListener('click', function () {
          btnEditInfo.setAttribute('style', 'margin-left: auto;order: 2;display:block;');
          formEditInfo.setAttribute('style', 'margin-top: 20px; display:none;');
          divInfo.setAttribute('style', 'margin-top:20px;display:block;');
      });

      //////////////
      var btnEditSocial = document.getElementById('btn_edit_social');
      var formSocial = document.getElementById('social-form');
      var divSocial = document.getElementById('div-social');
      var btnCancelSocial = document.getElementById('btn_cancel_social');
      btnEditSocial.addEventListener('click', function() {
        btnEditSocial.setAttribute('style', 'display:none;');
        formSocial.setAttribute('style', 'display:block;');
        divSocial.setAttribute('style', 'display:none;');
      });

      btnCancelSocial.addEventListener('click', function() {
        btnEditSocial.setAttribute('style', 'margin-left: auto;order: 2;display:block;');
        formSocial.setAttribute('style', 'display:none;');
        divSocial.setAttribute('style', 'display:block;');
      });
  </script>

<script src="{{ asset(mix('js/sweerAlertDeleteConfirmation.js')) }}"></script>
<script>
  var btn = document.getElementsByClassName('btn-outline-danger');
  for (let i = 0; i < btn.length; i++) {
    btn[i].addEventListener('click', deleteConfirmation.bind(null,btn[i].id, 'admin/settings'));
  }
</script>

<script>
  const openEditModalBtns = document.querySelectorAll('.editDegreeBtn');
  const editModal = document.getElementById('editDegreeModal');
  const editCloseModalBtns = document.querySelectorAll('.editClose');
  const editForm = document.getElementById('editDegreeForm');
  const degreeDescriptionEditInput = document.getElementById('editDescription');
  const degreeTypeEditInput = document.getElementById('editType');
  const openCreateModalBtn = document.getElementById('createDegreeBtn');
  const createModal = document.getElementById('createDegreeModal');
  const createCloseModalBtns = document.querySelectorAll('.createClose');
  const CreateForm = document.getElementById('createDegreeForm');
  const degreeDescriptionCreateInput = document.getElementById('descriptionCreate');
  const degreeTypeCreateInput = document.getElementById('typeCreate');

  let degreeId;

  openEditModalBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      degreeId = parseInt(this.getAttribute('data-id'));
      editModal.style.display = 'block';
      editModal.classList.add('show');
      loadDegreeValues(degreeId, this.getAttribute('data-old-description'), this.getAttribute('data-old-type'));
    });
  });

  openCreateModalBtn.addEventListener('click', function() {
    createModal.style.display = 'block';
    createModal.classList.add('show');
  });

  createCloseModalBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      createModal.style.display = 'none';
      createModal.classList.remove('show');
    });
  });

  editCloseModalBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      editModal.style.display = 'none';
      editModal.classList.remove('show');
    });
  });
  
  function loadDegreeValues(degreeId, description, type) {
    degreeDescriptionEditInput.value = description;
    degreeTypeEditInput.value = type;
    let actionUrl = "{{ route('update_degree', ['degreeId']) }}";
    actionUrl = actionUrl.replace('degreeId', degreeId);
    editForm.setAttribute('action', actionUrl);
  }
</script>
@endsection
