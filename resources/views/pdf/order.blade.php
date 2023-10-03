<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<body>
<section>
    <h1 style="font-size: 24px; text-align: center; font-weight: 500">Ваші білети</h1>
    <p style="font-size: 15px; text-align: center">Не забудьте збереги! Друкування не обов'язкове.</p>
    <ul class="tickets">
        @foreach($order['seats'] as $seat)
            <li class="ticket">
                <h3 class="ticket-header">
                    {{ $order['screening']['movie']['title'] }}
                </h3>

                <div class="ticket-main" style="position: relative">
                    <div class="ticket-main__qr-code" style="position: absolute; right: 1rem">
                        <img src="data:image/png;base64,{{ $order['qr_code'] }}" alt="QR Code">
                    </div>
                    <div class="ticket-main__item">
                        Зал <span>#{{ $order['screening']['hall']['number'] }}</span>
                    </div>

                    <div class="ticket-main__item-group">
                        <div class="ticket-main__item">
                            Ряд
                            <span>{{ $seat['row_number'] }}</span>
                        </div>
                        <div class="ticket-main__item">
                            Місце
                            <span>{{ $seat['seat_number'] }}</span>
                        </div>
                    </div>

                    <div class="ticket-main__item">
                        Кінотеатр <span>{{ $order['screening']['hall']['address'] }}</span>
                    </div>

                    <div class="ticket-main__item">
                        Сеанс <span>{{ $order['screening']['date'] }} {{ $order['screening']['start_time'] }} | {{ $order['screening']['end_time'] }}</span>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</section>
</body>
</html>
<style>

    /* Reset and base styles  */
    * {
        padding: 0;
        margin: 0;
        border: none;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /* Links */

    a, a:link, a:visited {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    /* Common */

    aside, nav, footer, header, section, main {
        display: block;
    }

    h1, h2, h3, h4, h5, h6, p {
        font-size: inherit;
        font-weight: inherit;
    }

    ul, ul li {
        list-style: none;
    }

    img {
        vertical-align: top;
    }

    img, svg {
        max-width: 100%;
        height: auto;
    }

    address {
        font-style: normal;
    }

    /* Form */

    input, textarea, button, select {
        font-family: inherit;
        font-size: inherit;
        color: inherit;
        background-color: transparent;
    }

    input::-ms-clear {
        display: none;
    }

    button, input[type="submit"] {
        display: inline-block;
        box-shadow: none;
        background-color: transparent;
        background: none;
        cursor: pointer;
    }

    input:focus, input:active,
    button:focus, button:active {
        outline: none;
    }

    button::-moz-focus-inner {
        padding: 0;
        border: 0;
    }

    label {
        cursor: pointer;
    }

    legend {
        display: block;
    }

</style>

<style>
    * {
        font-family: 'Rubik', sans-serif;
    }

    body {
        margin: 10px 20px;
    }

    .tickets {
        margin-top: 1rem;
    }

    .ticket {
        background-color: #fff;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 0.5rem;
    }

    .ticket-header {
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .ticket-main__item span {
        font-weight: 500;
    }
</style>
