@extends('layouts.auth')
@section('title',trans('auth.forget_pass'))

@section('main-content')
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">{{trans('auth.forget_pass')}}</h4>
                                    <form action="{{route('password.reset')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>{{trans('auth.email')}}</strong></label>
                                            <input name="email" type="email" class="form-control"
                                                   placeholder="{{trans('auth.email_ex')}}">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                    class="btn btn-primary btn-block">{{trans('auth.submit')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
