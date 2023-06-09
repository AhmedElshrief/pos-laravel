@extends('layouts.dashboard.app')

@section('title', __('site.products'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>@lang('site.products')</h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a> </li>
                     <li class="breadcrumb-item active"><a href="">@lang('site.products')</a></li>
                </ol>

        </section>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title" style="margin: 10px 10px 20px 10px;">{{ __('site.products') }}</h3> <span class="badge bg-primary" style="font-size: 15px">{{ $products->total() }}</span>

                    <form action="{{ route('dashboard.products.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
{{--                                I will search by js later --}}
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <select name="category_id" class="form-control">
                                    <option value="" disabled selected>{{ __('site.all_categories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == request()->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_products'))
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add_product')</a>
                                @else
                                    <button class="btn btn-primary disabled"><i class="fa fa-plus"></i>@lang('site.add_product')</button>
                                @endif
                            </div>

                        </div>
                    </form>

                </div>

                <div class="box-body">

                    @if($products->count() > 0)

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.buy_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.profit_percent') %</th>
                                <th>@lang('site.stock')</th>
                                <th colspan="2">@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($products as $index => $product)

                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td><img src="{{ $product->image_path }}" class="img-thumbnail img-lg" alt=""></td>
                                    <td>{{ $product->buy_price }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ $product->profit_percent }} %</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>

                                        @if(auth()->user()->hasPermission('update_products'))
                                            <a href="{{route('dashboard.products.edit', $product->id)}}" class="btn btn-info"><span></span>@lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-info disabled"><i class="fa fa-edit"></i>@lang('site.update')</button>
                                        @endif

                                    </td>
                                    <td>
                                      @if(auth()->user()->hasPermission('delete_products'))
                                            <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                {{--                                            // I will delete by js later--}}
                                                <button type="submit" class="btn btn-danger delete" data-id="{{ $product->id }}"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger disabled"> <i class="fa fa-trash"></i>@lang('site.delete')</button>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                        {{ $products->appends(request()->query())->links() }}

                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div><!-- end of box body -->

            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

@endsection
