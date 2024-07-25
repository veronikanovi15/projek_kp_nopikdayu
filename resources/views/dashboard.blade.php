<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575d63;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .card-title {
            font-size: 1.5rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a {float: left;}
            .content {margin-left: 0;}
        }
        @media (max-width: 768px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#dashboard">Dashboard</a>
        <a href="#data-kinerja">Data Kinerja Pegawai</a>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Informasi Aplikasi Pemkab Badung</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <form class="d-flex ms-auto">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav ms-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                                <li><a class="dropdown-item" href="sesi/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h1>Aplikasi Pemkab Badung</h1>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">E-Surat</h5>
                            <p class="card-text">jskajs</p>
                            <a href="#" class="btn btn-light">Info Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Agenda</h5>
                            <p class="card-text">dsdsadasd</p>
                            <a href="#" class="btn btn-light">Info Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-dark mb-3">
                        <div class="card-body">
                            <h5 class="card-title">TTE</h5>
                            <p class="card-text">dssfdsfsd</p>
                            <a href="#" class="btn btn-light">Info Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
