<html>
<head></head>
<body>
    <div>
        <p>
            Hello {{ $data['restaurant_name'] }},</br>
        </p>
        <p>
            Your Restaurant Request is Rejected. </br>
        </p>
        <p>
            Thank You, </br>
            Team {{ config('app.name') }}
        </p>
    </div>
</body>
</html>