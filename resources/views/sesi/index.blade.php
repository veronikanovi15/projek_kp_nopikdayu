<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tambahkan Bootstrap CSS jika belum ada -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya untuk kontainer formulir login */
        .login-container {
            max-width: 400px;
            margin: 50px auto; /* Memusatkan kontainer secara vertikal dan horizontal */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Gaya untuk judul formulir */
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5rem;
        }

        /* Gaya untuk tombol */
        .login-container .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 1rem;
        }

        .login-container .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Gaya untuk alert */
        .login-container .alert-danger {
            margin-top: 10px;
        }

        /* Gaya untuk paragraf di bawah formulir */
        .login-container p {
            text-align: center;
            margin-top: 15px;
        }

        .login-container a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </div>
    <!-- Tambahkan Bootstrap JS jika diperlukan -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
