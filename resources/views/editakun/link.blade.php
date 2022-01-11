<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Link Update Password</title>
    </head>
    <body>
        @foreach($user as $u)
        <h4>Halo {{$u->name}},</h4>
        Silahkan untuk klik link berikut untuk melakukan update password<br>
        <a href="{{route('update',$u->encrypt_id)}}">Link</a>
        @endforeach
    </body>
</html>