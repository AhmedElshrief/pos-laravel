@extends('layouts.dashboard.app')

@section('title', __('site.edit_user'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>@lang('site.edit_user')</h1>

            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                            class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">@lang('site.categories')</a></li>
                <li class="breadcrumb-item active">@lang('site.edit_user')</li>
            </ol>

        </section>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>

                <div class="box-body">

                    <form action="{{ route('dashboard.categories.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email}}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email}}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <img src="{{ $user->image_path }}" class="img-thumbnail image-preview" alt="" width="120" height="120"/>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.permissions')</label>

                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['categories', 'categories', 'products', 'clients', 'orders'];
                                    $trans = ['read', 'create', 'update', 'delete'];
                                @endphp
                                <ul class="nav nav-tabs">
                                    @foreach($models as $index => $model)

                                        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                    @endforeach

                                </ul> <!-- end nav tabs -->

                                <div class="tab-content">
                                    @foreach($models as $index => $model)
                                        <div class="tab-pane {{ $index ==0 ? 'active' : '' }}" id="{{$model}}">
                                            @foreach($trans as $tran)
                                                <div class="checkbox-wrapper-14">
                                                    <input id="s1-14" type="checkbox" {{ $user->hasPermission($tran . '_' . $model) ? 'checked' : '' }} name="permissions[]" value="{{$tran}}_{{$model}}"  class="switch">
                                                    <label for="s1-14">@lang('site.'.$tran)</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                <!-- /.tab-content -->

                            </div>
                            <!-- nav-tabs-custom -->
                            @if ($errors->has('permissions'))
                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif
                        </div>
                        <!-- /.col -->


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-edit"></i>@lang('site.edit_user')</button>
                        </div>

                    </form>


                </div>

            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

@endsection
