<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit;
}
include("connection.php");

$is_admin = $_SESSION['role'] == 'admin';
$nim = $_SESSION['nim'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            background-color: #1A4D2E; /* Warna latar belakang gelap untuk area di belakang container */
        }
        .header-title {
            border-bottom: 2px solid #000; /* Warna dan ketebalan garis */
            padding-bottom: 5px; /* Jarak antara teks dan garis */
        }
        .container-custom {
            background-color: #ffffff; /* Warna latar belakang putih untuk container */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Bayangan untuk memberi efek kedalaman */
            position: relative; /* Menjadikan posisi container relative */
        }
        .logout-container {
            margin-top: 20px; /* Jarak antara tombol logout dan isi tabel */
            text-align: center;
        }
        .logo {
            position: absolute; /* Buat posisi logo menjadi absolute relatif terhadap container */
            top: 10px; /* Jarak dari atas container */
            right: 30px; /* Jarak dari kanan container */
            height: 70px; /* Atur tinggi logo sesuai kebutuhan */
        }
        .table th, .table td {
            vertical-align: middle; /* Menjadikan teks di tengah secara vertikal */
            text-align: center; /* Menjadikan teks di tengah secara horizontal */
        }
        .btn-action {
            margin-top: 5px; /* Jarak atas untuk tombol */
            margin-bottom: 5px; /* Jarak bawah untuk tombol */
        }
    </style>
</head>

<body>
    <div class="container mt-5 container-custom">
        <header class="header-title mb-4">
            <h1><a href="./form.php" style="text-decoration: none;"><span class="fw-normal text-dark">Sistem Informasi</span> 
            <span class="text-primary">Mahasiswa</span></a></h1>
        </header>
        <img src="logo-upnvj.png" alt="Logo" class="logo">
        <section>
            <h2 class="text-center">Data Mahasiswa</h2>
            <div class="clearfix">
                <?php if ($is_admin) { ?>
                <a href="add_mahasiswa.php" class="btn btn-primary float-end" style="width: 100px;">Add</a>
                <?php } ?>
            </div>
            <?php
            if (isset($_GET["message"])) {
                echo "<div class=\"alert alert-success my-3\">" . $_GET["message"] . "</div>";
            }

            // Adjust query to hide admin data if logged in as admin
            $query = $is_admin ? "SELECT * FROM mahasiswa WHERE role = 'student' ORDER BY nama ASC" : "SELECT * FROM mahasiswa WHERE nim = '$nim'";
            $result = mysqli_query($link, $query);
            if (!$result) {
                die("Query Error:" . mysqli_errno($link) . " -" . mysqli_error($link));
            }
            ?>
            <div class="table-responsive">
                <table class="table table-striped mt-4">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tempat Lahir</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">IPK</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($data = mysqli_fetch_assoc($result)) {
                            $raw_date = strtotime($data["tanggal_lahir"]);
                            $date = date("d - m - Y", $raw_date);
                            echo "<tr>";
                            echo "<th scope=\"row\">$i</th>";
                            echo "<td class=\"text-center\">$data[nim]</td>";
                            echo "<td class=\"text-center\">$data[nama]</td>";
                            echo "<td class=\"text-center\">$data[tempat_lahir]</td>";
                            echo "<td class=\"text-center\">$date</td>";
                            echo "<td class=\"text-center\">$data[jenis_kelamin]</td>";
                            echo "<td class=\"text-center\">$data[fakultas]</td>";
                            echo "<td class=\"text-center\">$data[jurusan]</td>";
                            echo "<td class=\"text-center\">$data[ipk]</td>";
                            echo "<th scope=\"row\" class=\"text-center\">";
                            if ($is_admin) {
                                echo "<form action=\"./update_mahasiswa.php\" method=\"post\" class=\"d-inline-block\">
                                <input type=\"hidden\" name=\"id\" value=\"$data[id]\">
                                <input type=\"submit\" name=\"submit\" value=\"Update\" style=\"width:80px\" class=\"btn btn-info text-white btn-action\">
                                </form>
                                <form action=\"./delete_mahasiswa.php\" method=\"post\" class=\"d-inline-block\">
                                <input type=\"hidden\" name=\"id\" value=\"$data[id]\">
                                <input type=\"submit\" name=\"submit\" value=\"Delete\" style=\"width:80px\" class=\"btn btn-danger btn-action\">
                                </form>";
                            }
                            echo "</th>";
                            echo "</tr>";
                            $i++;
                        }
                        mysqli_free_result($result);
                        mysqli_close($link);
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="logout-container">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
