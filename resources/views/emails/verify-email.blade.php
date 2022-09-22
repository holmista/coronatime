<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&display=swap" rel="stylesheet">
    <style>
        a:hover {
            cursor: pointer;
        }

        a {
            text-decoration: none !important;
        }

        body {
            font-family: 'Inter';
        }

        .image {
            margin: 0 auto;
            display: block;
        }

        .img_wrapper {
            margin-top: 150px;
        }

        .verify_email {
            max-width: 392px;
            width: 100%;
            background-color: #0fba68;
            border-radius: 8px;
            max-height: 56px;
            margin: 0 auto;
        }

        .button {
            margin: 0 auto;
        }

        @media only screen and (max-width: 600px) {
            .img_wrapper {
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <div style="">
        <div class="img_wrapper">
            <img src="{{ $message->embed(public_path() . '/storage/emailConfirm.png') }}" alt="" class="image">
        </div>
        <br>
        <h1 style="font-size: 24px; font-weight: 900; text-align: center; color: black;">
            {{ __('texts.confirmation_email') }}
        </h1>
        <br>
        <p style="font-size: 18px; color:black; text-align: center;">
            {{ __('texts.click_this_button_to_verify_your_email') }}
        </p>
        <a href="{{ $confirmationUrl }}" class="button">
            <p class="verify_email"
                style="padding-top: 1rem; padding-bottom: 1rem; font-size: 16px; font-weight: 900;
            color: white; text-align: center; text-decoration: none; ">
                {{ strtoupper(__('texts.verify_email')) }}
            </p>
        </a>
        <br>
    </div>
</body>
