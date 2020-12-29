@extends('layouts.dashboard')

@section('title',trans('layout.restaurant_create'))

@section('css')
    <link href="{{asset('vendor/jquery-steps/css/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/summernote/summernote.css')}}" rel="stylesheet">
@endsection

@section('main-content')

    <div class="row page-titles mx-0">
        <div class="col-sm-12 text-center">
            <h5 class="text-red font-weight-bolder">{{$extend_message}}</h5>
        </div>
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.restaurant')}}</h4>
                <p class="mb-0">{{trans('layout.restaurant_create')}}</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('restaurant.index')}}">{{trans('layout.restaurant')}}</a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.create')}}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('layout.create')}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('restaurant.store')}}" method="post" id="step-form-horizontal"
                          class="step-form-horizontal" enctype="multipart/form-data">
                        @include('restaurant.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('vendor/jquery-steps/build/jquery.steps.min.js')}}"></script>
    <script src="{{asset('js/plugins-init/jquery-steps-init.js')}}"></script>
    @if($extend_message)
        <script>
            $(document).ready(function (e) {
                $theSteps = $('.actions ul');
                $($theSteps).find('li').addClass('disabled').css('display', 'none');
            });

        </script>
    @endif
@endsection
