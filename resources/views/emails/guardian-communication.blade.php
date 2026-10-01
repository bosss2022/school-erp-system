<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; padding:30px;">

<div style="max-width:700px; margin:auto; background:#ffffff; border-radius:8px; overflow:hidden;">

    <div style="background:#198754; color:#fff; padding:20px;">

        <h2 style="margin:0;">
            {{ config('app.name') }}
        </h2>

        <p style="margin-top:8px;">
            Guardian Communication
        </p>

    </div>

    <div style="padding:30px;">

        <h3>{{ $communication->title }}</h3>

        <p>

            {!! nl2br(e($communication->message)) !!}

        </p>

        <br>

        <p>

            Regards,

            <br>

            <strong>

                {{ config('app.name') }}

            </strong>

        </p>

    </div>

    <div style="background:#eeeeee; padding:15px; text-align:center;">

        © {{ date('Y') }}

        {{ config('app.name') }}

    </div>

</div>

</body>
</html>