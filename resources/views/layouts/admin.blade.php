<!DOCTYPE html>
<html>
<head>

@yield('head')

</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        @yield('header')

    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        @yield('sidebar')

    </aside>


    <div class="content-wrapper">

        @yield('center')

    </div>


    @yield('footer')

</div>

@yield('scripts')

</body>
</html>
