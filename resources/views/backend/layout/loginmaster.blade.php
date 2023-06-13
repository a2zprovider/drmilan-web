@php
$setting = App\Models\Setting::first();
@endphp
<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') | {{ $setting->title ? $setting->title : 'Admin' }}</title>
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="robots" content="noindex,nofollow">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('images/setting',$setting->favicon) }}" sizes="32x32" />

    <!-- Include Styles -->
    <!-- BEGIN: Theme CSS-->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('admin/vendor/fonts/boxiconse04f.css?id=7bed0c381d8a5b57f43c7bd313947977') }}" />
    <link rel="stylesheet" href="{{ url('admin/vendor/fonts/fontawesomeb34a.css?id=f55d5b6721febc124275199b7dddbb5b') }}" />
    <link rel="stylesheet" href="{{ url('admin/vendor/fonts/flag-iconsc977.css?id=7018802e2db10780041f73a184e4bebe') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('admin/vendor/css/rtl/core29d0.css?id=7ea028d8943e4d11544610602e504b70') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('admin/vendor/css/rtl/theme-defaultde12.css?id=3cdafbb15e4b7f9cbb567018a632af10') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('admin/css/demo6e6a.css?id=8a804dae81f41c0f9fcbef2fa8316bdd') }}" />

    <link rel="stylesheet" href="{{ url('admin/vendor/libs/perfect-scrollbar/perfect-scrollbarb440.css?id=d9fa6469688548dca3b7e6bd32cb0dc6') }}" />
    <link rel="stylesheet" href="{{ url('admin/vendor/libs/typeahead-js/typeahead3881.css?id=8fc311b79b2aeabf94b343b6337656c') }}f" />

    <!-- Vendor Styles -->
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ url('admin/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Page Styles -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ url('admin/vendor/css/pages/page-auth.css') }}">

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <!-- laravel style -->
    <script src="{{ url('admin/vendor/js/helpers.js') }}"></script>

    <script src="{{ url('admin/vendor/js/template-customizer.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('admin/js/config.js') }}"></script>

</head>

<body>
    <!-- Layout Content -->

    @yield('content')

    <!--/ Layout Content -->

    <!-- Include Scripts -->
    <!-- BEGIN: Vendor JS-->
    <script src="{{ url('admin/vendor/libs/jquery/jquery40f4.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/popper/popper885d.js') }}"></script>
    <script src="{{ url('admin/vendor/js/bootstrap0983.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar4d5e.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/hammer/hammerc38e.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/i18n/i18n5fec.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/typeahead-js/typeaheada766.js') }}"></script>
    <script src="{{ url('admin/vendor/js/menu7d39.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ url('admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ url('admin/js/mainc3d7.js') }}"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ url('admin/js/pages-auth.js') }}"></script>
    <!-- END: Page JS-->

</body>

</html>