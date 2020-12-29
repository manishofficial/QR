@extends('layouts.dashboard')

@section('title',trans('layout.order_list'))

@section('css')
    <link href="{{asset('vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <script>
        let orderDataTable='';
    </script>
@endsection

@section('main-content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.order')}}</h4>
                <p class="mb-0">{{trans('layout.your_order')}}</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.orders')}}</a></li>
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
                        <button type="button" id="check_new_order" class="btn btn-sm btn-info">{{trans('layout.check_new_order')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" id="orderTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><strong>{{trans('layout.name')}}</strong></th>
                                <th><strong>{{trans('layout.restaurant')}}</strong></th>
                                <th><strong>{{trans('layout.table')}}</strong></th>
                                <th><strong>{{trans('layout.amount')}}</strong></th>
                                <th><strong>{{trans('layout.delivered_within')}}</strong></th>
                                <th><strong>{{trans('layout.payment_status')}}</strong></th>
                                <th><strong>{{trans('layout.status')}}</strong></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script !src="">
        "use strict";
        function generateActionButton(order){
            let html='';
            const deleteHtml=`<button class="dropdown-item" type="button"
                                                        data-message="{{trans('layout.message.order_delete_warning')}}"
                                                        data-action='{{route('order.delete')}}'
                                                        data-input={"id":"${order.id}","_method":"delete"}
                                                        data-toggle="modal"
                                                        data-target="#modal-confirm">{{trans('layout.delete')}}</button>`;
            if(order.status=='pending'){
                html=`<button class="dropdown-item" data-toggle="modal"   data-input={"status":"approved","order_id":"${order.id}"} type="button" data-target="#delivered_within_modal">{{trans('layout.approve')}}</button>`;
            }else if(order.status=='approved'){
                html=`<button class="dropdown-item" type="button"
                                                        data-message="{{trans('layout.message.order_status_warning',['status'=>'ready for delivery'])}}"
                                                        data-action='{{route('order.update.status')}}'
                                                        data-input={"status":"ready_for_delivery","order_id":"${order.id}"}
                                                        data-toggle="modal"
                                                        data-isAjax="true"
                                                        data-target="#modal-confirm">{{trans('layout.ready_for_delivery')}}</button>`;
            }else if(order.status=='ready_for_delivery'){
                html=`<button class="dropdown-item" type="button"
                                                        data-message="{{trans('layout.message.order_status_warning',['status'=>'delivered'])}}"
                                                        data-action='{{route('order.update.status')}}'
                                                        data-input={"status":"delivered","order_id":"${order.id}"}
                                                        data-toggle="modal"
                                                        data-isAjax="true"
                                                        data-toggle="modal"
                                                        data-target="#modal-confirm">{{trans('layout.delivered')}}</button>`;
            }

            return html;

        }

         orderDataTable=$('#orderTable').DataTable({
            processing: true,
         //   serverSide: true,
            ajax: {
                "url": '{{route('order.getAll')}}',
                "dataSrc": "data"
            },
             columnDefs: [
                 { targets: 0, visible: false }
             ],
            columns: [
                {data: 'row'},
                {data: 'name'},
                {data: 'restaurant_name'},
                {data: 'table'},
                {data: 'total_price'},
                {data: 'delivered_within'},
                {data: 'payment_status'},
                {data: 'raw_status'},
                {data: function(row){
                    let html=`<div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp"
                                                    data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <circle fill="#000000" cx="5" cy="12" r="2"/>
                                                        <circle fill="#000000" cx="12" cy="12" r="2"/>
                                                        <circle fill="#000000" cx="19" cy="12" r="2"/>
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">
                                            @can('order_manage')
                                            ${generateActionButton(row)}
                                            @endcan
                                                <a href="{{route('order.show')}}?id=${row.id}" class="dropdown-item">{{trans('layout.details')}}</a>
                                            </div>
                                        </div>`;
                    return html;
                    }},
            ],
             order: [[ 0, 'asc' ]],
             bInfo: false,
             bLengthChange: false,
        });

        $('#check_new_order').on('click',function(e){
            e.preventDefault();
            orderDataTable.ajax.reload();
        })
    </script>

@endsection
