<html>
<head></head>
<body>
    <div>
        <p>
            Hello {{ $data['first_name'] }} {{ $data['last_name'] }},</br>
        </p>
        <p>
            Your Restaurant - {{ $data['restaurant_name'] }} is registered successfully. Wait for admin to approve your restaurant request. </br>
        </p>
        <p>
            Thank You, </br>
            Team {{ config('app.name') }}
        </p>
    </div>
</body>
</html>