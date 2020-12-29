@extends('layouts.auth')

@section('title',trans('auth.login_title'))
@section('main-content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="text-center mt-2 d-none"><span class="text-red font-weight-bolder">{{trans('Database is being refreshed every 2 hours')}}</span></div>

                            <div class="auth-form">
                                <h4 class="text-center mb-4">{{trans('auth.login_title')}}</h4>
                                <form action="{{route('authenticate')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>{{trans('auth.email')}}</strong></label>
                                        <input type="email" class="form-control"
                                               placeholder="{{trans('auth.email_ex')}}" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>{{trans('auth.password')}}</strong></label>
                                        <input type="password" class="form-control"
                                               placeholder="{{trans('auth.password')}}" name="password">
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox ml-1">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="basic_checkbox_1" name="remember_me">
                                                <label class="custom-control-label"
                                                       for="basic_checkbox_1">{{trans('auth.remember_pass')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <a href="{{route('forget.password')}}">{{trans('auth.forget_pass')}}?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                                class="btn btn-primary btn-block">{{trans('auth.sign_in')}}</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    <p>{{trans('auth.haven\'t_account')}} <a class="text-primary"
                                                                             href="{{route('registration',['type'=>request()->get('type')])}}">{{trans('auth.sign_up')}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
