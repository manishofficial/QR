@extends('layouts.dashboard')

@section('title',trans('layout.plan_edit'))

@section('css')

@endsection

@section('main-content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.plan')}}</h4>
                <p class="mb-0">{{trans('layout.plan_edit')}}</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('plan.index')}}">{{trans('layout.plan')}}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.edit')}}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('layout.edit')}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('plan.update',$plan)}}" method="post" id="step-form-horizontal"
                          class="step-form-horizontal" enctype="multipart/form-data">
                        @method('put')
                        @include('plans.form')
                        <div class="pull-right">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
