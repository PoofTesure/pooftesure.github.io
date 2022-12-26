
<!DOCTYPE html>
<html lang="id">
<?php
include("./connect.php");
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

    if(isset($_POST['Edit'])){
         $stmt = $database -> prepare("UPDATE user SET Nama=?,Email=?,NIM=?,HP=?,Tempat_lahir=?,Tanggal_lahir=?,Alamat=?");
    $stmt->bind_param('sssssss', $_POST['nama'], $_POST['email'],$_POST['nim'],$_POST['hp'],$_POST['tempatLahir'],$_POST['tanggalLahir'],$_POST['alamat']);
    if(!$stmt -> execute()){
        echo "Error";
    }
    else{
        header("Refresh:0,'../profil.php'");
    }
    }

    if(isset($_GET["delete"])){
    $stmt = $database->prepare("DELETE FROM user WHERE no=?");
    $stmt->bind_param("s", $_SESSION['user_id']);
    if(!$stmt -> execute()){
        echo "Error";
    }
    else{
        header("Refresh:0,'./logout.php'");
    }

    }


?>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/calender.css">
        <script src="../js/bootstrap.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.2.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="wrapper">
        <nav class="sidebar">
                <div id="nav-header" style="margin: 20px;">
                    <a href="../index.php">
                        <i class="fa-solid fa-bars fa-2xl"></i>
                    </a>
                </div>
                <div class="sidecontent">
                    <ul class="list-unstyled">
                        <li>
                            <a href="../index.php">
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
                                    <a href="../aktivitas_kuliah.php">Aktivitas Kuliah</a>
                                </li>
                                <li>
                                    <a href="../tugas_kuliah.php">Tugas Kuliah</a>
                                </li>
                                <li>
                                    <a href="../nilai_kuliah.php">Nilai Kuliah</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="../perwalian.php">
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
                        <a href="../index.php" class="navbar-brand">
                            <img src="../img/logo-full.png" id="logoFull" height="40px">
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
                                        <a href="../profil.php">Profil</a>
                                    </li>
                                    <li>
                                        <a href="../script/logout.php">Logout</a>
                                    </li>
                                </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container">
                    <div class="row">
                        <form id="profil" action="" method="POST">
                            <div class="form-group row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="nim" value=<?php echo ($result['NIM']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="nama" value="<?php echo ($result['Nama']);?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Email" class="col-sm-2 col-form-label">Email :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="email" value=<?php echo ($result['Email']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hp" class="col-sm-2 col-form-label">Nomor HP :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="hp" value=<?php echo ($result['HP']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tempat" class="col-sm-2 col-form-label">Tempat Lahir :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="tempatLahir" value=<?php echo ($result['Tempat_lahir']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Lahir :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="tanggalLahir" value=<?php echo ($result['Tanggal_lahir']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label">Alamat :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" name="alamat" value="<?php echo ($result['Alamat']);?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dosen" class="col-sm-2 col-form-label">Dosen Wali :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control-plaintext" readonly name="dosen" value="<?php echo ($result['Doswal']);?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="batas" class="col-sm-2 col-form-label">Batas Studi :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control-plaintext" readonly name="batasStudi" value=<?php echo ($result['BatasStudi']);?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="prodi" class="col-sm-2 col-form-label">Program Studi :</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control-plaintext" readonly name="prodi" value="<?php echo ($result['Prodi']);?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="Edit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>