<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') - The Twins Furniture</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/assets') }}/images/favicon.png">
    <link href="{{ url('public/assets') }}/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
<div class="authincation h-100" style="padding: 100px 0px;">

    @yield('content')
</div>


<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ url('public/assets') }}/vendor/global/global.min.js"></script>
<script src="{{ url('public/assets') }}/js/quixnav-init.js"></script>
<script src="{{ url('public/assets') }}/js/custom.min.js"></script>

</body>

</html>
