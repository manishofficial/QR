@extends('layouts.dashboard')

@section('title',trans('layout.plan_title'))

@section('css')

@endsection

@section('main-content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.plan')}}</h4>
                <p class="mb-0"></p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.plan')}}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('layout.list')}}</h4>
                    <div class="pull-right">
                        <a href="{{route('plan.create')}}"
                           class="btn btn-sm btn-primary">{{trans('layout.create')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead class="text-center">
                            <tr>
                                <th><strong>{{trans('layout.title')}}</strong></th>
                                <th><strong>{{trans('layout.cost')}}</strong></th>
                                <th><strong>{{trans('layout.recurring_type')}}</strong></th>
                                <th><strong>{{trans('layout.table_limit')}}</strong></th>
                                <th><strong>{{trans('layout.restaurant_limit')}}</strong></th>
                                <th><strong>{{trans('layout.item_limit')}}</strong></th>
                                <th><strong>{{trans('layout.status')}}</strong></th>
                                <th><strong>{{trans('layout.action')}}</strong></th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if($plans)
                                @foreach($plans as $plan)
                                    <tr>
                                        <td>{{$plan->title}}</td>
                                        <td>{{formatNumberWithCurrSymbol($plan->cost)}}</td>
                                        <td>{{$plan->recurring_type}}</td>
                                        <td>{{$plan->table_limit}}</td>
                                        <td>{{$plan->restaurant_limit}}</td>
                                        <td>{{$plan->item_limit}}</td>
                                        <td>
                                            @if($plan->status=='active')
                                                <span
                                                    class="badge light badge-success">{{trans('layout.active')}}</span>
                                            @elseif($plan->status=='inactive')
                                                <span
                                                    class="badge light badge-warning">{{trans('layout.inactive')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-success light sharp"
                                                        data-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <circle fill="#000000" cx="5" cy="12" r="2"/>
                                                            <circle fill="#000000" cx="12" cy="12" r="2"/>
                                                            <circle fill="#000000" cx="19" cy="12" r="2"/>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('plan.edit',[$plan])}}">{{trans('layout.edit')}}</a>
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.plan_delete_warning')}}"
                                                            data-action='{{route('plan.destroy',[$plan])}}'
                                                            data-input={"_method":"delete"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.delete')}}</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
