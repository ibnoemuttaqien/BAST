<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-top: 5px solid #ff0000;
            /* Merah */
            border-bottom: 5px solid #000000;
            /* Hitam */
        }

        .login-container img {
            margin-top: 10px;
            width: 300px;
            margin-bottom: 20px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #000000;
            /* Hitam */
        }

        .login-container .form-control {
            border-radius: 20px;
        }

        .login-container .btn {
            width: 100%;
            border-radius: 20px;
            background-color: #ff0000;
            /* Merah */
            color: #ffffff;
            border: none;
        }

        .login-container .btn:hover {
            background-color: #cc0000;
            /* Merah lebih gelap */
        }

        .login-container .alert {
            margin-bottom: 0;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <img src="{{ asset('img/logo.jpg') }}" alt="Logo"> <!-- Ganti dengan path logo Anda -->
        <h2>Login</h2>
        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}"
                    required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-lg mt-3">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
