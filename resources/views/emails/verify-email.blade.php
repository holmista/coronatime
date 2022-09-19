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
    </style>
</head>

<body>
    <div style="display: flex; justify-content: center; flex-direction: column; align-items: center">
        <div style="margin-top: 150px;">
            <img src="{{ $message->embed(public_path() . '/storage/emailConfirm.png') }}" alt="">
        </div>
        <h1 style="font-size: 24px; font-weight: 900; text-align: center; color: black;">
            {{ __('texts.confirmation_email') }}
        </h1>
        <p style="font-size: 18px; color:black; text-align: center;">
            {{ __('texts.click_this_button_to_verify_your_email') }}
        </p>
        <a href="{{ $confirmationUrl }}"
            style="max-width: 392px; width: 100%; background-color: rgb(15 186 104); border-radius: 8px; max-height: 56px;
             display: flex; justify-content: center; align-items: center;">
            <p
                style="padding-top: 1rem; padding-bottom: 1rem; font-size: 16px; font-weight: 900;color: rgb(255 255 255); text-align: center; text-decoration: none;">
                {{ strtoupper(__('texts.confirmation_email')) }}
            </p>
        </a>
    </div>
</body>
