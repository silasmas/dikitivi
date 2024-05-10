<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- ============ Streamo CSS File ============ -->
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/plugins.css') }}">

        <title>Count</title>
    </head>
    <body>
                                    <div class="count text-muted">
                                        @lang('miscellaneous.views')@lang('miscellaneous.colon_after_word') <span class="d-inline-block me-3">{{ thousandsCurrencyFormat(count($views)) }}</span>
                                        @lang('miscellaneous.likes')@lang('miscellaneous.colon_after_word') <span class="d-inline-block">{{ thousandsCurrencyFormat(count($likes)) }}</span>
                                    </div>
    </body>
</html>
