<html>
<head></head>
<body>
    <div>
        <p>
            Hello {{ $data['first_name'] }} {{ $data['last_name'] }},</br>
        </p>
        @if(isset($data['email']) && !empty($data['email']))
            <p>Your account  is registered successfully. </br></p>
            <p>please click and login</p></br>
            <p>Email : {{$data['email']}}</p></br>
            <p>Password : {{$data['password']}}</p></br>
            <p>Please <a href="{{$data['login_url']}}">login</a></p></br>
        @else
        <p>Your user - {{ $data['first_name'] }} {{ $data['last_name'] }} is registered successfully. </br></p>
        @endif
        <p>Thank You,</p></br>
        <p>Team {{ config('app.name') }}</p>
    </div>
</body>
</html>