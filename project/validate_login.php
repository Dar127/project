<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = mysqli_real_escape_string($link, $_POST["nim"]);
    $password = mysqli_real_escape_string($link, $_POST["password"]);

    if ($nim === 'admin' && $password === 'admin123') {
        $_SESSION["nim"] = $nim;
        $_SESSION["role"] = 'admin';
        header("Location: form.php");
        exit;
    } else {
        $query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
        $result = mysqli_query($link, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);
            $raw_date = strtotime($data["tanggal_lahir"]);
            $correct_password = date("dmY", $raw_date);

            if ($password === $correct_password) {
                $_SESSION["nim"] = $nim;
                $_SESSION["role"] = $data["role"];
                header("Location: form.php");
                exit;
            } else {
                $error_message = "Password salah!";
            }
        } else {
            $error_message = "NIM tidak ditemukan!";
        }

        mysqli_free_result($result);
        mysqli_close($link);

        header("Location: login.php?error=" . urlencode($error_message));
        exit;
    }
}
?>