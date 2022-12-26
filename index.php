<?php
include("./script/connect.php");
include("./script/calendar.php");

$calender = new Calendar();
session_start();
if(empty($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true){
    echo "not logged in";
    header("Refresh:0,'./script/login.php'");
}
#IPK

$stmt = $database->prepare("SELECT kode_matakuliah,nilai FROM nilai WHERE stud_id=?");
$stmt->bind_param("s", $_SESSION["user_id"]);
$stmt->execute();
$enrollment = $stmt->get_result()->fetch_all();
$jumlah_sks = 0;
$IPK = 0;

foreach($enrollment as $temp){
    $stmt = $database->prepare("SELECT sks FROM matakuliah WHERE kode=?");
    $stmt->bind_param("s", $temp[0]);
    $stmt->execute();
    $sks = $stmt->get_result()->fetch_array();
    $sks = $sks[0];
    $jumlah_sks = $jumlah_sks + $sks;
    $IPK = $IPK + ($temp[1] * $sks);
}

$IPK = $IPK / $jumlah_sks;
$stmt = $database -> prepare("UPDATE user SET ipk=? WHERE no=?");
$stmt->bind_param("ss", $IPK, $_SESSION["user_id"]);
$stmt->execute();


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
                    <a href="#">
                        <i class="fa-solid fa-bars fa-2xl"></i>
                    </a>
                </div>
                <div class="sidecontent">
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="active">
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
                                    <a href="./aktivitas_kuliah.php">Aktivitas Kuliah</a>
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
                <div class="container-fluid text-center vh-100">
                    <div class="row h-100">
                        <div class="col" id="kolom1">
                            <div class="row h-60 justify-content-center align-items-center">
                                <?php
                                 echo ($calender);
                                ?>
                            </div>
                        
                            <div class="row h-40 justify-content-center align-items-center mt-1">
                                <h4>Tugas</h4>
                                <table class="table">
                                    <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Nama Tugas</th>
                                    <th>Pengumpulan</th>
                                </tr>
                            <?php
                            $stmt = $database->prepare("SELECT * FROM tugas WHERE stud_id=? AND progress=0");
                            $stmt->bind_param("s", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $result = $result ->fetch_all();
                            foreach($result as $tugas){
                                $kode_tugas = $tugas[0];
                                $kode = $tugas[1];
                                $nama_tugas = $tugas[3];
                                $deadline = $tugas[4];
                                $progress = $tugas[5];
                                $stmt = $database->prepare("SELECT nama FROM matakuliah WHERE kode=?");
                                $stmt->bind_param("s", $kode);
                                $stmt->execute();
                                $nama = $stmt->get_result()->fetch_array();
                                $nama = $nama[0];
                                $time = strtotime($deadline);
                                if(time() > $time){
                                    $stmt = $database->query("DELETE from tugas WHERE no=$kode_tugas");
                                }
                                else{

                                    echo "<tr>";
                                    echo "<td>" . $nama . "</td>";
                                    echo "<td>" . $nama_tugas . "</td>";
                                    echo "<td>" . $deadline . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <h4>Pengumuman</h4>
                            </div>

                            <?php
                            $stmt = $database->query("SELECT * FROM pengumuman");
                            $result = $stmt->fetch_all();
                            #print_r($result);
                            $i = 1;

                            foreach($result as $news){
                                $load_html = sprintf(
                                "<div class='row text-end news m-2' id='news%d'></div>
                                <script>
                                    $(document).ready( function() {
                                    $('#news%d').load('%s');
                                });
                                </script>
                                 ",$i,$i,$news[2]);
                                echo ($load_html);
                                $i++;

                            }
                            
                            ?>
                             </div>
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