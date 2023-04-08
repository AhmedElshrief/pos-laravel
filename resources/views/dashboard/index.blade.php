@extends('layouts.dashboard.app')

@section('title', __('site.dashboard'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>@lang('site.dashboard') </h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
                </ol>

        </section>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">

               <h1> Ahmed</h1>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

@endsection
