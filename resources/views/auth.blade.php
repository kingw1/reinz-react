<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.0
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">

<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/theme/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/theme/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/theme/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div className="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-image: url('/theme/media/auth/bg4.jpg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('/theme/media/auth/bg4-dark.jpg');
            }
        </style>

        @inertia
    </div>

    <script src="/theme/plugins/global/plugins.bundle.js"></script>
    <script src="/theme/js/scripts.bundle.js"></script>
</body>

</html>
