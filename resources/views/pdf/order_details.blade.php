<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Order #{{$order->id}} | {{trans('layout.order_details')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            outline: none;
            padding: 0;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            height: 100%;
            position: relative;
            max-width: 100%;
            font-size: 1rem;
        }

        body {
            margin: 0;
            font-family: "Roboto", sans-serif;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #000;
            text-align: left;
        }

        .col-md-1, .col-md-2, .col-md-3, .col-md-4,
        .col-md-5, .col-md-6, .col-md-7, .col-md-8,
        .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
            float: left;
        }


        .col-md-6 {
            width: 50%;
        }

        .float-right {
            float: right !important;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .card {
            margin-bottom: 1.875rem;
            background-color: #fff;
            position: relative;
            border: 0px solid transparent;
            border-radius: 20px;
            box-shadow: 0px 12px 23px 0px rgba(62, 73, 84, 0.04);
            height: calc(100% - 30px);
        }

        .mt-3, .my-3 {
            margin-top: 1rem !important;
        }

        .card-header:first-child {
            border-radius: calc(0.75rem - 1px) calc(0.75rem - 1px) 0 0;
        }

        .card-header {
            border-color: #f0f1f5;
            position: relative;
            background: transparent;
            padding: 1.5rem 1.875rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-body {
            padding: 1.875rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #000;
        }

        table {
            border-collapse: collapse;
        }

        .table:not(.table-bordered) thead th {
            border-top: none;
        }

        .table thead th {
            border-bottom-width: 1px;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-color: #f0f1f5;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #EEEEEE;
        }

        .table th, .table td {
            border-color: #f0f1f5;
            padding: 12px 9px;
        }

        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #EEEEEE;
        }

        th {
            text-align: inherit;
        }

        .table tbody tr td {
            vertical-align: middle;
            border-color: #f0f1f5;
        }

        .mt-4, .my-4 {
            margin-top: 1.5rem !important;
        }

        @media (min-width: 1200px) {
            .col-xl-3 {
                flex: 0 0 25%;
                max-width: 25%;
            }
        }

        @media (min-width: 992px) {
            .col-lg-3 {
                flex: 0 0 25%;
                max-width: 25%;
            }
        }

        @media (min-width: 768px) {
            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (min-width: 576px) {
            .col-sm-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto, .col-xxl-1, .col-xxl-2, .col-xxl-3, .col-xxl-4, .col-xxl-5, .col-xxl-6, .col-xxl-7, .col-xxl-8, .col-xxl-9, .col-xxl-10, .col-xxl-11, .col-xxl-12, .col-xxl, .col-xxl-auto {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        h6, .h6 {
            font-size: 0.938rem;
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
            color: #000;
        }

        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        .ml-auto, .mx-auto {
            margin-left: auto !important;
        }


        .col-lg-4 {
            flex: 0 0 33.3333333333%;
            max-width: 33.3333333333%;
        }


        .col-sm-5 {
            flex: 0 0 41.6666666667%;
            max-width: 41.6666666667%;
        }

    </style>

    <link rel="stylesheet" href="{{public_path().'/css/only-grid.css'}}">
</head>
<body>


<div class="row">
    <div class="col-lg-12">

        <div class="card mt-3">
            <div class="card-header"><strong>Order #{{$order->id}}</strong> <span
                    class="float-right">
                                    <strong>{{trans('layout.status')}}:</strong> {{$order->status}}</span></div>
            <div class="card-body">
                <div class="row mb-5">
                    <div style="width: 50%;" class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <h6>{{trans('layout.invoice_by')}}:</h6>
                        <div><strong>{{$order->restaurant->name}}</strong></div>
                        <div>Email: {{$order->restaurant->email}}</div>
                        <div>Phone: {{$order->restaurant->phone_number}}</div>
                        <div>Address: {{$order->restaurant->location}}</div>
                    </div>
                    <div style="width: 50%;margin-bottom: 20px;top:-20px" class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <h6>{{trans('layout.invoice_to')}}:</h6>
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
                            <th>{{trans('layout.price')}}</th>
                            <th>{{trans('layout.discount')}}</th>
                            <th>{{trans('layout.total')}}</th>
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
                                <td>{{formatNumberWithCurrSymbol($details->item->price)}}</td>
                                <td>{{formatNumberWithCurrSymbol($details->discount)}}</td>
                                <td>{{formatNumberWithCurrSymbol($details->total)}}</td>
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
                                <td class="left"><strong>{{trans('layout.grand_total')}}</strong></td>
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


</body>
</html>
