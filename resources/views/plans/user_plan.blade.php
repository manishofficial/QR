@extends('layouts.dashboard')

@section('title',trans('layout.user_plan_title'))

@section('css')

@endsection

@section('main-content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.user_plan')}}</h4>
                <p class="mb-0"></p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.user_plan')}}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('layout.list')}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                            <tr>
                                <th><strong>{{trans('layout.name')}}</strong></th>
                                <th><strong>{{trans('layout.plan_name')}}</strong></th>
                                <th><strong>{{trans('layout.start_date')}}</strong></th>
                                <th><strong>{{trans('layout.expiry_date')}}</strong></th>
                                <th><strong>{{trans('layout.other_info')}}</strong></th>
                                <th><strong>{{trans('layout.status')}}</strong></th>
                                <th><strong>{{trans('layout.action')}}</strong></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userPlans as $userPlan)
                                <tr>
                                    <td>{{$userPlan->user->name}}</td>
                                    <td>{{$userPlan->plan->title}}</td>
                                    <td>{{formatDate($userPlan->start_date)}}</td>
                                    @if($userPlan->expired_date=='')
                                        <td>Lifetime</td>
                                    @else
                                        <td>{{formatDate($userPlan->expired_date)}}</td>
                                    @endif
                                    <td style="width: 300px">
                                        @php  $obj = ""; @endphp
                                        @if ($userPlan->other_info)
                                            @php $array = (array)json_decode($userPlan->other_info);
                                                    unset($array['payment_type']);
                                        $obj = json_encode(array_combine(array_map("ucfirst", array_keys($array)), array_values($array)));
                                            @endphp
                                        @endif
                                        {{str_replace(['_', '"', "{", "}"], [' ', ' ', '', ''], $obj)}}
                                    </td>
                                    <td>
                                        @if($userPlan->status=='approved')
                                            <span class="badge light badge-success">{{trans('layout.approved')}}</span>
                                        @elseif($userPlan->status=='rejected')
                                            <span class="badge light badge-danger">{{trans('layout.rejected')}}</span>
                                        @elseif($userPlan->status=='pending')
                                            <span class="badge light badge-primary">{{trans('layout.pending')}}</span>
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
                                                @if($userPlan->status=='pending')
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.userplan_approve_warning')}}"
                                                            data-action='{{route('user.plan.change')}}'
                                                            data-input={"status":"approved","id":"{{$userPlan->id}}"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.approve')}}</button>
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.userplan_reject_warning')}}"
                                                            data-action='{{route('user.plan.change')}}'
                                                            data-input={"status":"rejected","id":"{{$userPlan->id}}"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.reject')}}</button>
                                                @elseif($userPlan->status=='approved')
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.change_user_plan_warning')}}"
                                                            data-action='{{route('user.plan.change')}}'
                                                            data-input={"status":"pending","id":"{{$userPlan->id}}"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.pending')}}</button>
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.userplan_reject_warning')}}"
                                                            data-action='{{route('user.plan.change')}}'
                                                            data-input={"status":"rejected","id":"{{$userPlan->id}}"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.reject')}}</button>
                                                @elseif($userPlan->status=='rejected')
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.userplan_approve_warning')}}"
                                                            data-action='{{route('user.plan.change')}}'
                                                            data-input={"status":"approved","id":"{{$userPlan->id}}"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.approve')}}</button>
                                                    <button class="dropdown-item" type="button"
                                                            data-message="{{trans('layout.message.change_user_plan_warning')}}"
                                                            data-action='{{route('user.plan.change')}}'
                                                            data-input={"status":"pending","id":"{{$userPlan->id}}"}
                                                            data-toggle="modal"
                                                            data-target="#modal-confirm">{{trans('layout.pending')}}</button>
                                            </div>
                                            @endif
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
