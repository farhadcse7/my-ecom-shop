<!doctype html>
<html class="no-js" lang="zxx">
<head>
    @include('website.includes.meta')
    @include('website.includes.style')
</head>

<body>
@include('website.includes.header')

<!-- main area start -->
<main>
    @yield('body')
</main>
<!-- main area end -->

@include('website.includes.footer')
@include('website.includes.script')
</body>

</html>
