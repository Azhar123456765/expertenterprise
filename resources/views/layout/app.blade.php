<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
    @include('layout.style')
</head>

<body>
    <div class="wrapper {{ request()->is('*finance*') ? 'sidebar_minimize' : '' }}">
        @include('layout.sidebar')
        <div class="main-panel">
            @include('layout.header')
            <div class="container">
                @yield('content')
            </div>
            @include('layout.footer')
        </div>
</body>
@include('inc.modals')

@include('layout.script')
</html>
