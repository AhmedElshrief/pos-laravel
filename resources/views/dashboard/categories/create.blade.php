@extends('layouts.dashboard.app')

@section('title', __('site.add_user'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>@lang('site.add_user')</h1>

            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                            class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">@lang('site.categories')</a></li>
                <li class="breadcrumb-item active">@lang('site.add_category')</li>
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

                    <form action="{{ route('dashboard.categories.store') }}" method="post">
                        @csrf
                        @method('post')

                        @foreach(config('translatable.locales') as $locale)

                            <div class="form-group">
                                {{-- sit.ar.name --}}

                                <label>@lang('site.' . $locale . '.name')</label>

                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ old( $locale . '.name' ) }}">
                                {{-- ar[name] --}}
                                @if ($errors->has( $locale . '.name'))
                                    <span class="text-danger">{{ $errors->first($locale . '.name') }}</span>
                                @endif
                            </div>

                        @endforeach


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-plus"></i>@lang('site.add_category')</button>
                        </div>

                    </form>


                </div>

            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

@endsection
