@extends('layouts.dashboard.app')

@section('title', __('site.clients'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>@lang('site.clients')</h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a> </li>
                     <li class="breadcrumb-item active"><a href="">@lang('site.clients')</a></li>
                </ol>

        </section>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title" style="margin: 10px 10px 20px 10px;">{{ __('site.clients') }}</h3> <span class="badge bg-primary" style="font-size: 15px">{{ $clients->total() }}</span>

                    <form action="{{ route('dashboard.clients.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
{{--                                I will search by js later --}}
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="@lang('site.search')">
                            </div>


                            <div class="col-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_clients'))
                                    <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add_client')</a>
                                @else
                                    <button class="btn btn-primary disabled"><i class="fa fa-plus"></i>@lang('site.add_client')</button>
                                @endif
                            </div>
                        </div>
                    </form>

                </div>

                <div class="box-body">

                    @if($clients->count() > 0)

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th colspan="2">@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($clients as $index => $client)

                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>

                                        @if(auth()->user()->hasPermission('update_clients'))
                                            <a href="{{route('dashboard.clients.edit', $client->id)}}" class="btn btn-bitbucket"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-info disabled"><i class="fa fa-edit"></i>@lang('site.update')</button>
                                        @endif

                                    </td>
                                    <td>
                                      @if(auth()->user()->hasPermission('delete_clients'))
                                            <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                {{--                                            // I will delete by js later--}}
                                                <button type="submit" class="btn btn-danger delete" data-id="{{ $client->id }}"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger disabled"> <i class="fa fa-trash"></i>@lang('site.delete')</button>
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                        {{ $clients->appends(request()->query())->links() }}

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
