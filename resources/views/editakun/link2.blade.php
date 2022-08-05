<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Link Verification</title>
    </head>
    <body>
        @foreach($user as $u)
        <h4>Halo {{$u->name}},</h4>
        Silahkan untuk klik link berikut untuk melakukan verifikasi<br>
        <a href="{{route('verif',$u->encrypt_id)}}">Link</a>
        <br><br>
        Akun Anda :<br>
        username : {{$u->username}}<br>
        password : {{$password}}
        @endforeach
    </body>
</html>