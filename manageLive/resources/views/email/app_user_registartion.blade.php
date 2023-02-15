<html>
<head></head>
<body>
    <div>
        <p>
            Hello {{ $data['first_name'] }} {{ $data['last_name'] }},</br>
        </p>
        <p>
            Your user - {{ $data['first_name'] }} {{ $data['last_name'] }} is registered successfully. </br>
        </p>
        <p>
            Thank You, </br>
            Team {{ config('app.name') }}
        </p>
    </div>
</body>
</html>