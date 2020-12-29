@extends('layouts.dashboard')

@section('title',trans('layout.restaurant_list'))

@section('css')

@endsection

@section('main-content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.restaurant')}}</h4>
                <p class="mb-0">{{trans('layout.your_restaurant')}}</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.restaurants')}}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('layout.list')}}</h4>
                    @if(auth()->user()->type!='admin')
                        <div class="pull-right">
                            <a href="{{route('restaurant.create')}}"
                               class="btn btn-sm btn-primary">{{trans('layout.create')}}</a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                            <tr>
                                <th style="width:80px;"><strong>#</strong></th>
                                <th><strong>{{trans('layout.name')}}</strong></th>
                                <th><strong>{{trans('layout.timing')}}</strong></th>
                                <th><strong>{{trans('layout.total_item')}}</strong></th>
                                <th><strong>{{trans('layout.location')}}</strong></th>
                                <th><strong>{{trans('layout.status')}}</strong></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($restaurants as $key=>$restaurant)
                                <tr>
                                    <td><strong>{{$key+1}}</strong></td>
                                    <td>{{$restaurant->name}}</td>
                                    <td>{{$restaurant->timing}}</td>
                                    <td>{{$restaurant->items->count()}}</td>
                                    <td>{{$restaurant->location}}</td>
                                    <td>
                                        @if($restaurant->status=='active')
                                            <span class="badge light badge-success">{{trans('layout.active')}}</span>
                                        @elseif($restaurant->status=='inactive')
                                            <span class="badge light badge-warning">{{trans('layout.inactive')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp"
                                                    data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <circle fill="#000000" cx="5" cy="12" r="2"/>
                                                        <circle fill="#000000" cx="12" cy="12" r="2"/>
                                                        <circle fill="#000000" cx="19" cy="12" r="2"/>
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a target="_new" class="dropdown-item"
                                                   href="{{route('show.restaurant',['slug'=>$restaurant->slug,'id'=>$restaurant->id])}}">{{trans('layout.preview')}}</a>
                                                <a class="dropdown-item"
                                                   href="{{route('restaurant.edit',[$restaurant])}}">{{trans('layout.edit')}}</a>
                                                <button class="dropdown-item" type="button"
                                                        data-message="{{trans('layout.message.restaurant_delete_warning')}}"
                                                        data-action='{{route('restaurant.destroy',[$restaurant])}}'
                                                        data-input={"_method":"delete"}
                                                        data-toggle="modal"
                                                        data-target="#modal-confirm">{{trans('layout.delete')}}</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
