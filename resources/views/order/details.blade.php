@extends('layouts.dashboard')

@section('title',trans('layout.order_details'))

@section('main-content')

    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <button class="btn btn-sm btn-info" id="print" type="button">Print</button>
                <button class="btn btn-sm btn-info" id="pdf" type="button">Pdf</button>
            </div>
        </div>
    </div>
    <div class="row" id="printableSection">
        <div class="col-lg-12">

            <div class="card mt-3">
                <div class="card-header"> {{trans('layout.details')}} <strong>Order #{{$order->id}}</strong> <span
                        class="float-right">
                                    <strong>{{trans('layout.status')}}:</strong> {{$order->status}}</span></div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                            <h6>{{trans('layout.customer')}}:</h6>
                            <div><strong>{{$order->name}}</strong></div>
                            @if($order->user)
                                <div>Email: {{$order->user->email}}</div>
                                <div>Phone: {{$order->user->phone_number}}</div>
                            @endif
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>{{trans('layout.item')}}</th>
                                <th>{{trans('layout.quantity')}}</th>
                                <th>{{trans('layout.comment')}}</th>
                                <th>{{trans('layout.price')}}</th>
                                <th>{{trans('layout.discount')}}</th>
                                <th>{{trans('layout.total_price')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $discount=0; @endphp
                            @foreach($order->details as $key=>$details)
                                @php $discount+=$details->discount; @endphp
                                <tr>
                                    <td class="center">{{$key+1}}</td>
                                    <td>{{$details->item->name}}</td>
                                    <td>{{$details->quantity}}</td>
                                    <td>{{$details->order->comment}}</td>
                                    <td>{{formatNumber($details->item->price)}}</td>
                                    <td>{{formatNumber($details->discount)}}</td>
                                    <td>{{formatNumber($details->total)}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5"></div>
                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                <tr>
                                    <td class="left"><strong>{{trans('layout.total_discount')}}</strong></td>
                                    <td class="right">{{formatNumberWithCurrSymbol($discount)}}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>{{trans('layout.total')}}</strong></td>
                                    <td class="right">{{formatNumberWithCurrSymbol($order->total_price)}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script !src="">
        "use strict";
        $('#print').on('click', function (e) {
            e.preventDefault();
            window.open('{{route('order.print',['id'=>$order->id])}}');
        });

        $('#pdf').on('click', function (e) {
            e.preventDefault();
            window.open('{{route('order.print',['id'=>$order->id])}}&type=pdf');
        })
    </script>
@endsection
