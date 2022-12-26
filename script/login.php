<?php
require("./connect.php");
session_start();
if(isset($_POST['login'])){
    $username = $_POST['nim'];
    $password = $_POST['pin'];
    
    if(empty($username) || empty($password)){
        echo '<script language="javascript">';
        echo 'alert("NIM dan ID tidak boleh kosong")';
        echo '</script>';
    }

    else{
    //Prepare SQL statement

    $stmt = $database -> prepare("SELECT * FROM user WHERE NIM=? ");
    $stmt -> bind_param('s', $username);
    $stmt -> execute();
    $result = $stmt ->get_result();
    $result = $result -> fetch_assoc();
    
    if(!$result){
        echo '<script language="javascript">';
		echo 'alert("Username atau Password salah")';
		echo '</script>';
    } else{
        if($password == $result["PIN"]){
            //Create session when user logged in
            $_SESSION['user_id'] = $result['No'];
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $result['Nama'];
            header("Refresh:0,'../index.php'");
        }
        else{
            echo '<script language="javascript">';
		    echo 'alert("Username atau Password salah")';
		    echo '</script>';
        }
    }
}
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/bootstrap.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.2.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container">
            <div id="login" class="row row-cols-2 justify-content-center align-items-center vh-100">
                <div class="row mb-10 vh-10" id="loginHeader">
                    <img src="../img/logo-full.png">
                    <h2 style="text-align: center;">Portal Mahasiswa</h2>
                </div>
                <div class="row vh-90" id="loginForm">
                <form action="" method="POST">
                    <div class="form-floating mb-3" id="nimLogin">
                        <input id="userNim" class="form-control" type="text" placeholder="NIM" name="nim">
                        <label for="userNim" class="form-label">NIM </label>
                    </div>
                    <div class="form-floating mb-3" id="passwordPin">
                        <input id="userPin" class="form-control" type="password" placeholder="PIN" name="pin">
                        <label for="userPin" class="form-label"> PIN</label>
                    </div>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                </div>
                </form>
            </div>
        </div>
    </body>
</html>