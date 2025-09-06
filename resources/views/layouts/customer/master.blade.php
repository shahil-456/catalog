<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light"
    data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-bs-theme="{{ session('theme', 'light') }}" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Amer Leads - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('layouts.admin.head-css')
    @livewireStyles
    {!! ToastMagic::styles() !!}
</head>
@section('body')
@include('layouts.admin.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.admin.topbar')
    @include('layouts.admin.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.admin.footer')
    </div>
    <!-- end main content-->
</div>


<script>
    document.querySelector('.light-dark-mode').addEventListener('click', function () {
    let current = document.documentElement.getAttribute('data-bs-theme') || 'light';
    let next = current === 'light' ? 'dark' : 'light';

    fetch('/admin/set-theme', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ theme: next })
    });
});

</script>
<!-- END layout-wrapper -->

{{-- @include('layouts.customizer') --}}

<!-- JAVASCRIPT -->
{!! ToastMagic::scripts() !!}
@include('layouts.admin.vendor-scripts')
@livewireScripts


</body>

</html>
