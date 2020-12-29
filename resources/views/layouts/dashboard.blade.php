<!DOCTYPE html>
<html lang="{{session()->get('locale')}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('uploads/'.json_decode(get_settings('site_setting'))->favicon)}}">

    <link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">

    <link href="{{asset('vendor/lineicons/2.0/LineIcons.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("vendor/toastr/css/toastr.min.css")}}">
    @yield('css')
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
</head>
<body>


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">


    <div class="nav-header">
        <a href="{{route('dashboard')}}" class="brand-logo">
            <img class="logo-abbr" src="{{asset('uploads/'.json_decode(get_settings('site_setting'))->logo)}}" alt="">
            <span class="logo-compact header-logo">{{json_decode(get_settings('site_setting'))->name}}</span>
            <span class="brand-title header-logo">{{json_decode(get_settings('site_setting'))->name}}</span>
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left"></div>

                    @if(auth()->check())
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell bell-link primary" href="#" role="button"
                                   data-toggle="dropdown">
                                    <i class="fa fa-language"></i>
                                </a>
                                <div class="header-profile">
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{route('set.locale',['type'=>'en'])}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-language"></i>
                                            <span class="ml-2">{{trans('layout.english')}} </span>
                                        </a>
                                        <a href="{{route('set.locale',['type'=>'bn'])}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-language"></i>
                                            <span class="ml-2">{{trans('layout.bengali')}} </span>
                                        </a>
                                        <a href="{{route('set.locale',['type'=>'ar'])}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-language"></i>
                                            <span class="ml-2">{{trans('layout.arabic')}} </span>
                                        </a>
                                        <a href="{{route('set.locale',['type'=>'pt'])}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-language"></i>
                                            <span class="ml-2">{{trans('layout.portuguese')}} </span>
                                        </a>
                                        <a href="{{route('set.locale',['type'=>'jp'])}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-language"></i>
                                            <span class="ml-2">{{trans('layout.japanese')}} </span>
                                        </a>
                                        <a href="{{route('set.locale',['type'=>'es'])}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-language"></i>
                                            <span class="ml-2">{{trans('layout.spanish')}} </span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon warning" href="#" role="button" data-toggle="dropdown">
                                    <svg width="24" height="24" viewBox="0 0 26 26" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.75 14.8385V12.0463C21.7471 9.88552 20.9385 7.80353 19.4821 6.20735C18.0258 4.61116 16.0264 3.61555 13.875 3.41516V1.625C13.875 1.39294 13.7828 1.17038 13.6187 1.00628C13.4546 0.842187 13.2321 0.75 13 0.75C12.7679 0.75 12.5454 0.842187 12.3813 1.00628C12.2172 1.17038 12.125 1.39294 12.125 1.625V3.41534C9.97361 3.61572 7.97429 4.61131 6.51794 6.20746C5.06159 7.80361 4.25291 9.88555 4.25 12.0463V14.8383C3.26257 15.0412 2.37529 15.5784 1.73774 16.3593C1.10019 17.1401 0.751339 18.1169 0.75 19.125C0.750764 19.821 1.02757 20.4882 1.51969 20.9803C2.01181 21.4724 2.67904 21.7492 3.375 21.75H8.71346C8.91521 22.738 9.45205 23.6259 10.2331 24.2636C11.0142 24.9013 11.9916 25.2497 13 25.2497C14.0084 25.2497 14.9858 24.9013 15.7669 24.2636C16.548 23.6259 17.0848 22.738 17.2865 21.75H22.625C23.321 21.7492 23.9882 21.4724 24.4803 20.9803C24.9724 20.4882 25.2492 19.821 25.25 19.125C25.2486 18.117 24.8998 17.1402 24.2622 16.3594C23.6247 15.5786 22.7374 15.0414 21.75 14.8385ZM6 12.0463C6.00232 10.2113 6.73226 8.45223 8.02974 7.15474C9.32723 5.85726 11.0863 5.12732 12.9212 5.125H13.0788C14.9137 5.12732 16.6728 5.85726 17.9703 7.15474C19.2677 8.45223 19.9977 10.2113 20 12.0463V14.75H6V12.0463ZM13 23.5C12.4589 23.4983 11.9316 23.3292 11.4905 23.0159C11.0493 22.7026 10.716 22.2604 10.5363 21.75H15.4637C15.284 22.2604 14.9507 22.7026 14.5095 23.0159C14.0684 23.3292 13.5411 23.4983 13 23.5ZM22.625 20H3.375C3.14298 19.9999 2.9205 19.9076 2.75644 19.7436C2.59237 19.5795 2.50014 19.357 2.5 19.125C2.50076 18.429 2.77757 17.7618 3.26969 17.2697C3.76181 16.7776 4.42904 16.5008 5.125 16.5H20.875C21.571 16.5008 22.2382 16.7776 22.7303 17.2697C23.2224 17.7618 23.4992 18.429 23.5 19.125C23.4999 19.357 23.4076 19.5795 23.2436 19.7436C23.0795 19.9076 22.857 19.9999 22.625 20Z"
                                            fill="#000"/>
                                    </svg>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3">
                                        <ul class="timeline">
                                            @foreach(get_notifications() as $notification)
                                                <li>
                                                    <div class="timeline-panel">
                                                        <div class="media mr-2">
                                                            <svg width="24" height="24" viewBox="0 0 26 26" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M21.75 14.8385V12.0463C21.7471 9.88552 20.9385 7.80353 19.4821 6.20735C18.0258 4.61116 16.0264 3.61555 13.875 3.41516V1.625C13.875 1.39294 13.7828 1.17038 13.6187 1.00628C13.4546 0.842187 13.2321 0.75 13 0.75C12.7679 0.75 12.5454 0.842187 12.3813 1.00628C12.2172 1.17038 12.125 1.39294 12.125 1.625V3.41534C9.97361 3.61572 7.97429 4.61131 6.51794 6.20746C5.06159 7.80361 4.25291 9.88555 4.25 12.0463V14.8383C3.26257 15.0412 2.37529 15.5784 1.73774 16.3593C1.10019 17.1401 0.751339 18.1169 0.75 19.125C0.750764 19.821 1.02757 20.4882 1.51969 20.9803C2.01181 21.4724 2.67904 21.7492 3.375 21.75H8.71346C8.91521 22.738 9.45205 23.6259 10.2331 24.2636C11.0142 24.9013 11.9916 25.2497 13 25.2497C14.0084 25.2497 14.9858 24.9013 15.7669 24.2636C16.548 23.6259 17.0848 22.738 17.2865 21.75H22.625C23.321 21.7492 23.9882 21.4724 24.4803 20.9803C24.9724 20.4882 25.2492 19.821 25.25 19.125C25.2486 18.117 24.8998 17.1402 24.2622 16.3594C23.6247 15.5786 22.7374 15.0414 21.75 14.8385ZM6 12.0463C6.00232 10.2113 6.73226 8.45223 8.02974 7.15474C9.32723 5.85726 11.0863 5.12732 12.9212 5.125H13.0788C14.9137 5.12732 16.6728 5.85726 17.9703 7.15474C19.2677 8.45223 19.9977 10.2113 20 12.0463V14.75H6V12.0463ZM13 23.5C12.4589 23.4983 11.9316 23.3292 11.4905 23.0159C11.0493 22.7026 10.716 22.2604 10.5363 21.75H15.4637C15.284 22.2604 14.9507 22.7026 14.5095 23.0159C14.0684 23.3292 13.5411 23.4983 13 23.5ZM22.625 20H3.375C3.14298 19.9999 2.9205 19.9076 2.75644 19.7436C2.59237 19.5795 2.50014 19.357 2.5 19.125C2.50076 18.429 2.77757 17.7618 3.26969 17.2697C3.76181 16.7776 4.42904 16.5008 5.125 16.5H20.875C21.571 16.5008 22.2382 16.7776 22.7303 17.2697C23.2224 17.7618 23.4992 18.429 23.5 19.125C23.4999 19.357 23.4076 19.5795 23.2436 19.7436C23.0795 19.9076 22.857 19.9999 22.625 20Z"
                                                                    fill="#000"/>
                                                            </svg>
                                                        </div>
                                                        <div class="media-body">
                                                            @if($notification->type=='plan')
                                                                <h6 class="mb-1"><a
                                                                        href="{{route('plan.list')}}">{{$notification->message}}</a>
                                                                </h6>
                                                            @elseif($notification->type=='order')
                                                                <h6 class="mb-1"><a
                                                                        href="{{route('order.show',['id'=>$notification->ref_id])}}">{{$notification->message}}</a>
                                                                </h6>
                                                            @endif
                                                            <small
                                                                class="d-block">{{$notification->created_at->diffForHumans()}}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <a class="all-notification d-none" href="#">{{trans('layout.all_notification')}} <i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <div class="header-info">
                                        <span>{{trans('layout.hello')}} <strong>{{short_word(auth()->user()->name,1,'')}}</strong></span>
                                    </div>
                                    <img src="{{asset('uploads/'.auth()->user()->picture)}}" width="20" alt=""/>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">

                                    @if(auth()->user()->type=='customer')
                                        <a href="{{route('order.index')}}" class="dropdown-item ai-icon">
                                            <i class="fa fa-list"></i>
                                            <span class="ml-2">{{trans('layout.my_order')}} </span>
                                        </a>
                                    @endif

                                    <a href="{{route('settings')}}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                             width="18" height="18" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ml-2">{{trans('layout.profile')}} </span>
                                    </a>
                                    <a href="{{route('logout')}}" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                             width="18" height="18" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ml-2">{{trans('layout.logout')}} </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
            </nav>
        </div>
    </div>

    <div class="deznav">
        <div class="deznav-scroll">
            @if(isset($rest_categories))
                @include('layouts.includes.restaurant_sidebar')
            @else
                @include('layouts.includes.sidebar')

            @endif

        </div>
    </div>

    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            @yield('main-content')
        </div>
    </div>

    <div class="footer">
        <div class="copyright">
            <p>{{trans('layout.copyright_footer')}} <a href="//picotech.com.bd" target="_blank">Pico
                    Technology</a> {{date('Y')}}</p>
        </div>
    </div>


</div>

<!-- Confirmation modal -->
<div class="modal fade" id="modal-confirm">
    <div class="modal-dialog">
        <form id="modal-form">
            @csrf
            <div id="customInput"></div>
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h4 class="modal-title">{{trans('layout.confirmation')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer p-2">
                    <button id="modal-confirm-btn" type="button"
                            class="btn btn-primary btn-sm">{{trans('layout.confirm')}}</button>
                    <button type="button" class="btn btn-secondary btn-sm"
                            data-dismiss="modal">{{trans('layout.cancel')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Delivered Within modal -->
<div class="modal fade" id="delivered_within_modal">
    <div class="modal-dialog">
        <form id="delivered_within_modal_form" method="post" action="{{route('order.update.status')}}">
            @csrf
            <div id="deliveredWithinCustomInput"></div>
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h4 class="modal-title">{{trans('layout.confirmation')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>{{trans('layout.within')}}</label>
                            <input name="time" required type="number" class="form-control" placeholder="Ex: 20">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{trans('layout.time')}}</label>
                            <select name="type" class="form-control" required>
                                <option value="minutes">{{trans('layout.minutes')}}</option>
                                <option value="hours">{{trans('layout.hours')}}</option>
                                <option value="days">{{trans('layout.days')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button id="within-modal-confirm-btn" type="submit"
                            class="btn btn-primary btn-sm">{{trans('layout.confirm')}}</button>
                    <button type="button" class="btn btn-secondary btn-sm"
                            data-dismiss="modal">{{trans('layout.cancel')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script src="{{asset('front/js/popper.min.js')}}"></script>
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/deznav-init.js')}}"></script>
<script src="{{asset("vendor/toastr/js/toastr.min.js")}}"></script>


<!-- Toastr -->

@php $allErrors=''; @endphp

@if (isset($errors) && count($errors) > 0)
    @foreach ($errors->all() as $error)
        @php $allErrors.=$error.'<br/>' @endphp
    @endforeach
    <script>
        $(function () {
            toastr.error('{!! clean($allErrors) !!}', 'Failed', {timeOut: 5000});
        });

    </script>
@endif
@if(session()->has('success'))
    <script>
        $(function () {
            toastr.info('{{session()->get('success')}}', 'Success', {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            });
        });

    </script>
@endif


@yield('js')


</body>

</html>
