@extends('layouts.dashboard.app')

@section('title', __('site.add_product'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>@lang('site.add_product')</h1>

            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                            class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">@lang('site.products')</a></li>
                <li class="breadcrumb-item active">@lang('site.add_product')</li>
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

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        @foreach(config('translatable.locales') as $locale)

                            <div class="form-group">
                                {{-- sit.ar.name --}}

                                <label>@lang('site.' . $locale . '.product_name')</label>

                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ old( $locale . '.name' ) }}">
                                {{-- ar[name] --}}
                                @if ($errors->has( $locale . '.name'))
                                    <span class="text-danger">{{ $errors->first($locale . '.name') }}</span>
                                @endif
                            </div>

                        @endforeach

                        @foreach(config('translatable.locales') as $locale)

                            <div class="form-group">
                                {{-- sit.ar.name --}}

                                <label>@lang('site.' . $locale . '.description')</label>

                                <textarea type="text" name="{{$locale}}[description]" class="form-control ckeditor" >{{ old( $locale . '.description' ) }}</textarea>
                                {{-- ar[description] --}}
                                @if ($errors->has( $locale . '.description'))
                                    <span class="text-danger">{{ $errors->first($locale . '.description') }}</span>
                                @endif
                            </div>

                        @endforeach

                        <div class="form-group">

                            <label>@lang('site.category')</label>
                            <select name="category_id" id="" class="form-control">
                                <option disabled>Select Category of product</option>
                            @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('category_id'))
                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
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
                            <img src="{{ asset('uploads/user_images/default.png') }}" class="img-thumbnail image-preview" alt="" width="120" height="120"/>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.buy_price')</label>
                            <input type="number" name="buy_price" class="form-control" value="{{ old('buy_price') }}">
                            @if ($errors->has('buy_price'))
                                <span class="text-danger">{{ $errors->first('buy_price') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.sale_price')</label>
                            <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                            @if ($errors->has('sale_price'))
                                <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                            @if ($errors->has('stock'))
                                <span class="text-danger">{{ $errors->first('stock') }}</span>
                            @endif
                        </div>




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
