<!DOCTYPE html>
<html>
<head>

    @yield('head')

</head>
<body>

<div class="container">

    <header id="header">

        @yield('header')

    </header>

    <section id="navArea">

        @yield('nav')

    </section>

    <section id="sliderSection">

        <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-8">

                @yield('center')

            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">

                <aside class="right_content">

                    @yield('sidebar')

                </aside>

            </div>

        </div>

    </section>

    <footer id="footer">

        @yield('footer')

    </footer>

</div>

<script type="text/javascript">
    const baseUrl='{{ asset('') }}';
</script>

@yield('scripts')

</body>
</html>
