@extends('layouts.auth')

@section('title',trans('layout.registration'))

@section('main-content')
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">{{trans('auth.sign_up_title')}}</h4>
                                    <form action="{{route('user.store')}}" method="post">
                                        @csrf
                                        @if(request()->has('type'))
                                            <input type="hidden" name="type" value="{{request()->get('type')}}">
                                            @endif
                                        <div class="form-group">
                                            <label class="mb-1"><strong>{{trans('auth.name')}}</strong></label>
                                            <input type="text" class="form-control"
                                                   placeholder="{{trans('auth.name_ex')}}"
                                                   name="name">
                                        </div>
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
                                        <div>
                                            <span>{{trans('auth.agreement')}}</span> <a class="text-blue" href="#">{{trans('auth.terms_condition')}}</a> {{trans('auth.and')}} <a class="text-blue" href="#">{{trans('auth.privacy_policy')}}</a>
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit"
                                                    class="btn btn-primary btn-block">{{trans('auth.sign_up_btn')}}</button>
                                        </div>

                                    </form>

                                    <div class="new-account mt-3">
                                        <p>{{trans('auth.allready_sign_in')}} <a class="text-primary"
                                                                                 href="{{route('login',['type'=>request()->get('type')])}}">{{trans('auth.sign_in_attr')}}</a>
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
