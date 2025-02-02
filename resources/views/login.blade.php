<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" src="../resources/sass/app.scss" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>

    <title>Login</title>
</head>

<body class="bg-screen">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card rounder-login d-flex align-items-center" style="width: 100%; max-width: 400px;">
            <img src="/img/imgProfile.png" alt="img-login-user" class="img-login-user mb-6">
            <form action="{{ route('login') }}" method="POST" class="w-100 text-center">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electronico"
                        required>
                </div>
                <div class="form-group mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña"
                        required>
                </div>
                @if (session('data'))
                    <div class="alert alert-danger">
                        {{ session('data') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary text-align-center">Iniciar sesion</button>
            </form>
        </div>
    </div>
</body>

</html>
<style>
    * {
        font-family: 'Roboto';
    }

    .rounder-login {
        border-radius: 24px;
    }

    .bg-screen {
        background: #393939;
    }

    .img-login-user {
        margin-top: -100px;
        height: 180px;
        width: 180px;
        border-radius: 200px;
        box-shadow: 0px 4px 4px 0px #00000061;
        margin-bottom: 60px;
    }

    .card {
        padding: 20px 80px 80px 80px;
    }

    input {
        background-color: #F0F0F0 !important;
        color: #2c2c2c;
        font-size: 14px !important;
        border: none !important;
        padding: 10px 12px !important;
        border-radius: 10px !important;
    }

    input::placeholder {
        color: #b3b3b3 !important;
    }

    .btn-primary {
        padding: 10px 20px;
        border-radius: 40px;
        font-size: 14px;
        background: #1958F7;
    }

    a {
        font-size: 12px;
    }
    @media only screen and (max-width: 417px){
        .card {
            padding: 20px 40px 40px 40px !important;
        }
        .img-login-user {
        height: 150px;
        width: 150px;
    }
    }
</style>