@extends('layouts.dashboard.app')

@section('title', __('site.categories'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>@lang('site.categories')</h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a> </li>
                     <li class="breadcrumb-item active"><a href="">@lang('site.categories')</a></li>
                </ol>

        </section>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title" style="margin: 10px 10px 20px 10px;">{{ __('site.categories') }}</h3> <span class="badge bg-primary" style="font-size: 15px">{{ $categories->total() }}</span>

                    <form action="{{ route('dashboard.categories.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
{{--                                I will search by js later --}}
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="@lang('site.search')">
                            </div>


                            <div class="col-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_categories'))
                                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add_category')</a>
                                @else
                                    <button class="btn btn-primary disabled"><i class="fa fa-plus"></i>@lang('site.add_category')</button>
                                @endif
                            </div>
                        </div>
                    </form>

                </div>

                <div class="box-body">

                    @if($categories->count() > 0)

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.num_products')</th>
{{--                                <th>@lang('site.related_products')</th>--}}
                                <th colspan="2">@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($categories as $index => $category)

                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products->count() }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.products.index', ['category_id' => $category->id]) }}" class="btn btn-info"><i class="fa fa-list"></i>{{ __('site.related_products') }}</a>
                                    </td>
                                    <td>

                                        @if(auth()->user()->hasPermission('update_categories'))
                                            <a href="{{route('dashboard.categories.edit', $category->id)}}" class="btn btn-bitbucket"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-info disabled"><i class="fa fa-edit"></i>@lang('site.update')</button>
                                        @endif

                                    </td>
                                    <td>
                                      @if(auth()->user()->hasPermission('delete_categories'))
                                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                {{--                                            // I will delete by js later--}}
                                                <button type="submit" class="btn btn-danger delete" data-id="{{ $category->id }}"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger disabled"> <i class="fa fa-trash"></i>@lang('site.delete')</button>
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                        {{ $categories->appends(request()->query())->links() }}

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
