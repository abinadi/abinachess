<!DOCTYPE html>

<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title>AbinaChess</title>

    @section('style')
        <link href="https://fonts.googleapis.com/css?family=Lato|Lustria" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">

        <style type="text/css">
            html, body {
                font-family: 'Lato', sans-serif;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: Lustria, serif;
            }
        </style>
    @show

    @yield('script')

</head>

<body>

@yield('content')

@section('script-footer')
    <script src="/js/app.js"></script>
@show

</body>
</html>
