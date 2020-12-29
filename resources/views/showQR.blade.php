@extends('layouts.dashboard')

@section('main-content')

    <img src="data:image/png;base64, {!! clean(base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!'))) !!} ">
@endsection
