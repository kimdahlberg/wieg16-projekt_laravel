<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
html, body {
    background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
    height: 100vh;
        }

        .flex-center {
    align-items: center;
            justify-content: center;
            max-width: 640px;
            margin: 0 auto;
        }

        .position-ref {
    position: relative;
}

        .top-right {
    position: absolute;
    right: 10px;
            top: 18px;
        }

        .content {
    text-align: center;
        }

        .title {
    font-size: 84px;
        }

        .links > a {
    color: #636b6f;
    padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
    margin-bottom: 30px;
        }
    </style>
</head>

        <body>
        <div class="flex-center position-ref full-height">


        <div class="content">
            <div class="title m-b-md">
        Klarna Confirmation
            </div>
            <div>{!! $checkout['html_snippet'] !!}</div>

            <script
                    src="https://code.jquery.com/jquery-3.2.1.min.js"
                    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                    crossorigin="anonymous"></script>



</div>
</div>
        <script id="klarna-code" data-order-id="{{$orderId}}">
            // jQuery förvandlar data-order-id till orderId
            var orderId = $('#klarna-code').data('orderId');
            (function($) {
                window._klarnaCheckout(function (api) {
                    console.log("This is the checkout");
                    $.getJSON('/klarna-acknowledge?order_id=' + orderId)
                        .then(function(response){

                    });
                });
            })(jQuery);
        </script>
</body>
</html>