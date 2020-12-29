@extends('layouts.dashboard')
@section('title',trans('layout.plan_title'))
@section('css')
    <style>
        #packagelist .wrapper {
            font-weight: 400;
            color: #9f9f9f;
            font-size: 15px;
        }

        #packagelist .package {
            box-sizing: border-box;
            width: 301px;
            height: 380px;
            border: 3px solid #e8e8e8;
            border-radius: 7px;
            display: inline-block;
            padding: 24px;
            text-align: center;
            float: left;
            -webkit-transition: margin-top .5s linear;
            transition: margin-top .5s linear;
            position: relative;
            margin-right: 11px;
            margin-bottom: 45px;
        }

        #packagelist .package:hover {
            margin-top: -30px;
            -webkit-transition: margin-top .3s linear;
            transition: margin-top .3s linear;
        }

        #packagelist .name {
            color: #565656;
            font-weight: 300;
            font-size: 2rem;
            margin-top: -5px;
        }

        #packagelist .price {
            margin-top: 7px;
            font-weight: bold;
        }

     /*   #packagelist .price::after {
            content: " / per user";
            font-weight: normal;
        }*/

        #packagelist hr {
            background-color: #dedede;
            border: none;
            height: 1px;
        }

        #packagelist .trial {
            font-size: .9rem;
            font-weight: 600;
            padding: 2px 21px 2px 21px;
            color: #2f4cdd;
            border: 1px solid #e4e4e4;
            display: inline-block;
            border-radius: 15px;
            background-color: white;
            position: relative;
            bottom: -30px;
        }

        #packagelist ul {
            list-style: none;
            padding: 0;
            text-align: left;
            margin-top: 29px;
        }

        #packagelist li {
            margin-bottom: 15px;
        }

        #packagelist li:before {
            font-size: 1.3rem;
            color: #2f4cdd;
            margin-right: 3px;
        }

        #packagelist .checkIcon, #packagelist li:before, #packagelist .active-plan::after {
            font-family: "FontAwesome";
            content: "\f00c";
        }

        #packagelist .active-plan {
            border-color: #2f4cdd;
        }

        #packagelist .active-plan::before {
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 64px 64px 0 0;
            border-color: #2f4cdd transparent transparent transparent;
            position: absolute;
            left: 0;
            top: 0;
            content: "";
        }

        #packagelist .active-plan::after {
            color: white;
            position: absolute;
            left: 9px;
            top: 6px;
            text-shadow: 0 0 2px #37c5b6;
            font-size: 1.4rem;
        }

        .individual-plan {
            cursor: pointer;
        }
    </style>
@endsection
@section('main-content')
    <div class="row" id="packagelist">
        @if($plans)
            @foreach($plans as $plan)
                <div class="col-sm-4">
                    <div
                        class="package {{isset(auth()->user()->current_plans[0]) && auth()->user()->current_plans[0]->plan_id==$plan->id?'active-plan':''}} individual-plan"
                        data-href="{{route('payment',['id'=>$plan->id])}}">
                        <div class="name">{{$plan->title}}</div>
                       <div class="price"> <span>{{ucfirst($plan->recurring_type)}}</span>  {{formatNumberWithCurrSymbol($plan->cost)}}</div>
                        <hr>
                        <ul>
                            <li>
                                <strong>{{$plan->table_limit}}</strong>
                                {{trans('layout.table_limit')}}
                            </li>
                            <li>
                                <strong>{{$plan->restaurant_limit}}</strong>
                                {{trans('layout.restaurant_limit')}}
                            </li>
                            <li>
                                <strong>{{$plan->item_limit}}</strong>
                                {{trans('layout.item_limit')}}
                            </li>
                            <li>
                                {{trans('layout.unlimited_support')}}
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    </div>

@endsection
@section('js')
    <script !src="">
        "use strict";
        $(document).ready(function ($) {
            $(".individual-plan").on('click', function () {
                if(!$(this).hasClass('active-plan')){
                    document.location.href = $(this).attr("data-href");
                }
            });
        });
    </script>
@endsection
