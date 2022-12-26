<?php
include("./script/connect.php");
include("./script/calendar.php");

session_start();
    $calender = new Calendar();
    if(empty($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true){
    echo "not logged in";
    header("Refresh:0,'./script/login.php'");
}
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <link rel="stylesheet" href="./css/bootstrap.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/calender.css">
        <script src="./js/bootstrap.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.2.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="wrapper">
            <nav class="sidebar">
                <div id="nav-header" style="margin: 20px;">
                    <a href="/index.php">
                        <i class="fa-solid fa-bars fa-2xl"></i>
                    </a>
                </div>
                <div class="sidecontent">
                    <ul class="list-unstyled">
                        <li>
                            <a href="index.php">
                                <i class="fa-solid fa-house fa-2xl"></i>
                                <h3>Home</h3>
                            </a>
                        </li>
                        <li>
                            <a data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle" href="#subBelajar">
                                <i class="fa-solid fa-book fa-2xl"></i>
                                <h3>Pembelajaran</h3>
                            </a>
                            <ul class="collapse" id="subBelajar">
                                <li>
                                    <a>Aktivitas Kuliah</a>
                                </li>
                                <li>
                                    <a href="./tugas_kuliah.php">Tugas Kuliah</a>
                                </li>
                                <li>
                                    <a href="./nilai_kuliah.php">Nilai Kuliah</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="./perwalian.php">
                                <i class="fa-solid fa-person-chalkboard fa-2xl"></i>
                                <h3>Perwalian</h3>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="content">
                <nav class="navbar" id="topbar">
                    <div class="container-fluid">
                        <a href="#" class="navbar-brand">
                            <img src="./img/logo-full.png" id="logoFull" height="40px">
                        </a>
                        <div class="navbar-right">
                            <ul class="list-unstyled just">
                                <li>
                                <a id="profilToggle" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle" href="#subProfil">
                                    <div class="container">
                                        <div class="row h-50">
                                        <svg height=25px xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                                        </div>
                                        <div class="row">
                                            <h6><?php
                                            $stmt = $database->prepare("SELECT ipk FROM user WHERE no=?");
                                            $stmt->bind_param("s", $_SESSION["user_id"]);
                                            $stmt->execute();
                                            $IPK = $stmt->get_result()->fetch_array();
                                            $IPK = $IPK[0];
                                            echo "IPK : ". $IPK;
                                            ?></h6>
                                        </div>
                                    </div>
                                </a>
                                <ul class="collapse list-unstyled" id="subProfil">
                                    <li>
                                        <a href="./profil.php">Profil</a>
                                    </li>
                                    <li>
                                        <a href="./script/logout.php">Logout</a>
                                    </li>
                                </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container-fluid text-center">
                    <div class="row">
                        <h4>Jadwal Pelajaran</h4>
                        <table class="table" width="100%">
                            <tr>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Jenis</th>
                                <th>Hari</th>
                                <th>Jam</th>
                            </tr>
                        <?php
                        $stmt = $database->prepare("SELECT * FROM enrollment WHERE user_id=?");
                        $stmt->bind_param("s", $_SESSION['user_id']);
                        $stmt -> execute();
                        if ($stmt->execute()) {
                            $result = $stmt ->get_result();
                            $result = $result -> fetch_all();
                            #print_r($result);
                            foreach($result as $matkul){
                                $stmt = $database->prepare("SELECT * FROM matakuliah WHERE kode=?");
                                $stmt->bind_param("s", $matkul[2]);
                                $stmt->execute();
                                $rslt = $stmt->get_result();
                                $rslt = $rslt->fetch_assoc();
                                #print_r($rslt);
                                $kode = $rslt["kode"];
                                $matkul = $rslt["nama"];
                                $sks = $rslt["sks"];
                                $jenis = $rslt["tipe"];
                                $hari = $rslt["jadwal"];
                                $jam = $rslt["jam"];
                                $uas = $rslt['UAS'];
                                $uts = $rslt['UTS'];

                                switch ($jenis) {
                                    case 0:
                                        $jenis = "Kuliah";
                                        break;
                                    case 1:
                                        $jenis = "Praktikum";
                                        break;
                                    case 2:
                                        $jenis = "Asistensi";
                                        break;
                                }

                                switch ($hari) {
                                    case 0:
                                        $hari = "Minggu";
                                        break;
                                    case 1:
                                        $hari = "Senin";
                                        break;
                                    case 2:
                                        $hari = "Selasa";
                                        break;
                                    case 3:
                                        $hari = "Rabu";
                                        break;
                                    case 4:
                                        $hari = "Kamis";
                                        break;
                                    case 5:
                                        $hari = "Jumat";
                                        break;
                                    case 6:
                                        $hari = "Sabtu";
                                        break;
                                }
                                echo "<tr>";
                                echo "<td>" . $kode . "</td>";
                                echo "<td>" . $matkul . "</td>";
                                echo "<td>" . $sks . "</td>";
                                echo "<td>" . $jenis . "</td>";
                                echo "<td>" . $hari . "</td>";
                                echo "<td>" . $jam . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                        </table>
                    </div>
                    <div class="row">
                        <h4>Jadwal Ujian</h4>
                        <table class="table">
                            <tr>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>UTS</th>
                                <th>UAS</th>
                            </tr>
                            <?php 
                             $stmt = $database->prepare("SELECT * FROM enrollment WHERE user_id=?");
                             $stmt->bind_param("s", $_SESSION['user_id']);
                             $stmt -> execute();
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                $result = $result->fetch_all();
                                #print_r($result);
                                foreach ($result as $matkul) {
                                    $stmt = $database->prepare("SELECT nama,kode,UAS,UTS FROM matakuliah WHERE kode=?");
                                    $stmt->bind_param("s", $matkul[2]);
                                    $stmt->execute();
                                    $rslt = $stmt->get_result();
                                    $rslt = $rslt->fetch_assoc();
                                    
                                    echo "<tr>";
                                    echo "<td>" . $rslt['kode'] . "</td>";
                                    echo "<td>" . $rslt['nama'] . "</td>";
                                    echo "<td>" . $rslt['UTS'] . "</td>";
                                    echo "<td>" . $rslt['UAS'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {

                $('#nav-header').on('click', function () {
                    $('.sidebar').toggleClass("active");
                });

                });
            </script>
        </div>
    </body>
</html>