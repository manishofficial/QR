<!DOCTYPE html>
<html lang="{{session()->get('locale')}}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('uploads/'.json_decode(get_settings('site_setting'))->favicon)}}">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("vendor/toastr/css/toastr.min.css")}}">

</head>

<body class="h-100">
@yield('main-content')


<script src="{{asset('front/js/jquery.min.js')}}"></script>
<script src="{{asset("vendor/toastr/js/toastr.min.js")}}"></script>

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

</body>
</html>
