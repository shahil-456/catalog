@extends('layouts.user.master')
@section('title')
@lang('translation.analytics')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('user.components.breadcrumb')
@slot('li_1')
Dashboards
@endslot
@slot('title')
Analytics
@endslot
@endcomponent
<!-- end table responsive -->
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
