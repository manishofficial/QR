@extends('layouts.dashboard')

@section('title',trans('layout.qr_maker'))

@section('css')
    <link href="{{asset('vendor/jquery-asColorPicker/css/asColorPicker.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/nouislider/nouislider.min.css')}}">
@endsection


@section('main-content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{trans('layout.qr_maker')}}</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{trans('layout.qr_maker')}}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('layout.generate')}}</h4>
                    <div class="pull-right">
                        <a href="{{route('restaurant.create')}}"
                           class="btn btn-xs btn-primary">{{trans('layout.restaurant_create')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">

                            <div class="basic-form min-h-300">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>{{trans('layout.restaurant_select')}}:</label>
                                            <div class="dropdown bootstrap-select form-control">
                                                <select class="form-control" id="restaurant">
                                                    <option value=""></option>
                                                    @foreach($restaurants as $restaurant)
                                                        <option
                                                            data-url="{{route('show.restaurant', ['slug' => $restaurant->slug, 'id' => $restaurant->id])}}"
                                                            value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>{{trans('layout.table_select')}}:</label>
                                            <div class="dropdown bootstrap-select form-control">
                                                <select class="form-control" id="selectTable">
                                                    <option value=""></option>
                                                    @foreach($tables as $table)
                                                        <option value="{{$table->id}}">{{$table->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="color-pick-as">
                                                <p class="mb-1">{{trans('layout.fill_color')}}</p>
                                                <input id="fillColor" type="text" class="as_colorpicker form-control"
                                                       value="#067f72">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="color-pick-as">
                                                <p class="mb-1">{{trans('layout.bg_color')}}</p>
                                                <input id="bgColor" type="text" class="as_colorpicker form-control"
                                                       value="#ffffff">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text">
                                                <p class="mb-1">{{trans('layout.design_type')}}</p>
                                                <select name="qr_mode" id="qrMode">
                                                    <option value="0">{{trans('layout.normal')}}</option>
                                                    <option value="1">{{trans('layout.text_strip')}}</option>
                                                    <option selected value="2">{{trans('layout.text')}}</option>
                                                    <option value="3">{{trans('layout.image_strip')}}</option>
                                                    <option value="4">{{trans('layout.image')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group" id="customization">

                                    <div class="row">
                                        <div class="col-8">
                                            <label for="">{{trans('layout.size')}}</label>
                                            <div class="snap">
                                                <input type="hidden" id="qrTextSize" value="0.1">
                                                <div id="size"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="">{{trans('layout.pos_x')}}</label>
                                            <div class="snap">
                                                <input type="hidden" id="qrPosX" value="0.5">
                                                <div id="qrPosXSlider"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="">{{trans('layout.pos_y')}}</label>
                                            <div class="snap">
                                                <input type="hidden" id="qrPosY" value="0.5">
                                                <div id="qrPosYSlider"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group" id="textSection">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="text">
                                                    <p class="mb-1">{{trans('layout.text')}}</p>
                                                    <input id="qrText" type="text" class="form-control" value="{{$restaurant->name}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="color-pick-as">
                                                <p class="mb-1">{{trans('layout.text_color')}}</p>
                                                <input id="textColor" type="text" class="as_colorpicker form-control"
                                                       value="#92054d">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group" id="imageSection">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="color-pick-as">
                                                <label class="mb-1">{{trans('layout.image')}}</label>
                                                <div class="d-none">
                                                    <img src="{{asset('images/picoqr.PNG')}}" alt="picoqr image"
                                                         id="qrPreImage">
                                                </div>
                                                <input id="qrImage" accept="image/*" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div id="qrCodeGeneratedSection">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div id="qrCode">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div>
                                            <button id="downloadImage" type="button"
                                                    class="btn btn-xs btn-primary display-none">{{trans('layout.download')}}</button>
                                        </div>
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

@section('js')
    <script src="{{asset('vendor/jquery-asColor/jquery-asColor.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js')}}"></script>
    <script src="{{asset('vendor/qr/qr.min.js')}}"></script>
    <script src="{{asset('vendor/nouislider/nouislider.min.js')}}"></script>
    <script src="{{asset('js/plugins-init/qr-maker.min.js')}}"></script>
@endsection
