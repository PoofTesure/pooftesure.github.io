
<!DOCTYPE html>
<html lang="id">
<?php
include("./script/connect.php");
session_start();
    if(empty($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true){
    echo "not logged in";
    header("Refresh:0,'./script/login.php'");
    }
    $user_id = $_SESSION['user_id'];

    $stmt = $database->prepare("SELECT * from user WHERE No=?");
    $stmt -> bind_param('s', $user_id);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $result = $result ->fetch_array();

?>
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
                            <a href="./index.php">
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
                                    <a>Kehadiran Kuliah</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#subAdmin" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="fa-solid fa-computer fa-2xl"></i>
                                <h3>Administrasi</h3>
                            </a>
                            <ul class="collapse" id="subAdmin">
                                <li>
                                    <a>Keuangan</a>
                                </li>
                                <li>
                                    <a>Hal 2</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
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
                        <a href="./index.php" class="navbar-brand">
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
                                    <li class="active">
                                        <a>Profil</a>
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
                <div class="container">
                    <div class="row">
                        <form id="profil">
                            <div class="form-group row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" name="nim" value=<?php echo ($result['NIM']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="nama" value="<?php echo ($result['Nama']);?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Email" class="col-sm-2 col-form-label">Email :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="email" value=<?php echo ($result['Email']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hp" class="col-sm-2 col-form-label">Nomor HP :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="hp" value=<?php echo ($result['HP']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tempat" class="col-sm-2 col-form-label">Tempat Lahir :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="tempatLahir" value=<?php echo ($result['Tempat_lahir']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Lahir :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="tanggalLahir" value=<?php echo ($result['Tanggal_lahir']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label">Alamat :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="alamat" value="<?php echo ($result['Alamat']);?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dosen" class="col-sm-2 col-form-label">Dosen Wali :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="dosen" value="<?php echo ($result['Doswal']);?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="batas" class="col-sm-2 col-form-label">Batas Studi :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="batasStudi" value=<?php echo ($result['BatasStudi']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="prodi" class="col-sm-2 col-form-label">Program Studi :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="prodi" value="<?php echo ($result['Prodi']);?>">
                                </div>
                            </div>
                            <a href="./script/edit_profile.php" class="btn btn-primary">Edit</a>
                            <a href="./script/edit_profile.php?delete=1" class="btn btn-danger">Hapus Akun</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>