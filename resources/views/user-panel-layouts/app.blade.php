<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('user-panel-layouts.metadata')

    <title>{{config('app.name')}}</title>

    @include('user-panel-layouts.styles')
    @yield('custom-styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed pace-primary">
<div class="wrapper">
    @include('user-panel-layouts.header')
    @include('user-panel-layouts.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @yield('content-header')
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @yield('content-body')
            </div>
        </section>
    </div>

    @include('user-panel-layouts.footer')
</div>

@include('user-panel-layouts.scripts')

@yield('custom-scripts')
</body>
</html>
