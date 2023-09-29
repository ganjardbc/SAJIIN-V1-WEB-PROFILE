<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <meta name="generator" content="Saji-in" />
    <meta name="description" content="Aplikasi Point of Sale sederhana yang berfokus pada pengelolaan pesanan dan peningkatan performa pelayanan bagi pengusaha F&B." />
    <meta name="keywords" content="Aplikasi Kasir Digital, Aplikasi Kasir Online, Aplikasi Kasir Simpel, Aplikasi Kasir Sederhana, Aplikasi Kasir Geratis" />
    <meta name="google-site-verification" content="sRbr0-NS6TYhTddR1uovzAzBeXN1d7kJGpA0zFYQEL0" />
    <title>Saji-in | Serve All You Want</title>
    <link data-vue-meta="1" rel="icon" href="https://undangabi.com/images/icon.png">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/app.css') }}?v={{ time() }}" type="text/css" rel="stylesheet"/>
    <style>
        .bg-light {
            background-color: #eae9e9 !important;
        }
    </style>
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
            {'gtm.start': new Date().getTime(),event:'gtm.js'});
            var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
            j.async=true;
            j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
            f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PWTN22G');
    </script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <div id="app" />
    <script src="{{ mix('js/app.js') }}?v={{ time() }}" type="text/javascript"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWTN22G"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>
</html>