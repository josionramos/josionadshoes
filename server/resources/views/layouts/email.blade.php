<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ public_path('css/email/app.css') }}">
    </head>

    <body>
        <table class="root" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table class="container" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table class="header" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>{{ config('app.name') }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="main" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>@yield('content')</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="footer" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="text-center">
                                            <p>
                                                {{ config('app.name') }}<br>
                                                <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
