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
                                    <div>
                                    <i class="fa-solid fa-user fa-xl"></i>
                                    <h6>IPK</h6>
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
                    <div class="row">
                        
                    </div>
                    <div class="row">
                        
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