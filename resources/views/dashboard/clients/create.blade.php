@extends('layouts.dashboard.app')

@section('title', __('site.add_client'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>@lang('site.add_client')</h1>

            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                            class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">@lang('site.clients')</a></li>
                <li class="breadcrumb-item active">@lang('site.add_client')</li>
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

                    <form action="{{ route('dashboard.clients.store') }}" method="post">
                        @csrf
                        @method('post')

                            <div class="form-group">
                                <label>@lang('site.client_name')</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                        <div class="form-group">
                            <label>@lang('site.phone')</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.address')</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-plus"></i>@lang('site.add_client')</button>
                        </div>

                    </form>


                </div>

            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

@endsection
