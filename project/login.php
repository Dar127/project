<?php
session_start();
if (isset($_SESSION['nim'])) {
    header("Location: form.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Informasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #1A4D2E; /* Background color yang terang */
        }
        .container {
            max-width: 500px; /* Atur lebar container */
            width: 100%;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px;
            text-align: left; /* Mengatur text align ke kiri */
        }
        .container img {
            display: block;
            margin: 0 auto 20px; /* Menempatkan logo di tengah dengan margin bawah */
            max-width: 100px;
        }
        .form-label {
            text-align: left; /* Mengatur label ke kiri */
            display: block;
        }
        .form-control {
            width: 100%; /* Mengatur input agar full width */
        }
        .header-title {
            text-align: center; /* Header tetap di tengah */
        }
        .mb-3-custom {
            margin-bottom: 30px !important; /* Menambahkan jarak antara input field dan button dengan !important */
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo-upnvj.png" alt="Logo UPN" class="img-fluid">
        <header class="header-title mb-4">
            <h1 class="h4">Selamat Datang</h1>
            <hr>
        </header>
        <section>
            <form action="validate_login.php" method="post">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM/Username</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>
                <div class="mb-3 mb-3-custom">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <?php
                if (isset($_GET["error"])) {
                    echo "<div class=\"alert alert-danger\">" . $_GET["error"] . "</div>";
                }
                ?>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
