<?php
require ("database.class.php");


if(isset($_POST['usernameLog'])&&isset($_POST['passwordLog'])){

    $username = $_POST["usernameLog"];
    $password = $_POST["passwordLog"];

    date_default_timezone_set('Europe/Berlin');
    $date = date('Y-m-d  G:i:s', time());

    $sql = "SELECT * FROM  Korisnik  WHERE korisnicko_ime='" . $username . "' AND lozinka='" . $password . "'";

    $logUser = new Database();
    $logUser ->connectDB();


    $result = $logUser->sqlQuery($sql);
    $userFound = mysqli_num_rows($result);
    $userLogInfo = mysqli_fetch_assoc($result);

    if($userFound==1){
        if($password === $userLogInfo['lozinka']){
            session_start();
            setcookie("Korisnik",$userLogInfo['idKorisnik'],time() + (86400 * 30));

            $_SESSION['timeout'] = time()*8400;
            $_SESSION['usernameLog'] = $username;
            $_SESSION['userID']=$userLogInfo['idKorisnik'];
            $_SESSION['userRole']=$userLogInfo['Uloge_idUloge'];
            $loginSql = "INSERT INTO dnevnikPrijava (prijavljen, vrijemePrijave, Korisnik_idKorisnik) VALUES (1, NOW(), " . $userLogInfo['idKorisnik'] . " )";
            $logUser->sqlQuery($loginSql);
            header("location: ../proizvodi.php");
        }

    }
    else {
        $loginSql = "INSERT INTO dnevnikPrijava (prijavljen,vrijemePrijave) VALUES (0, NOW() )";
        var_dump($loginSql);
        $logUser->sqlQuery($loginSql);
        echo "Invalid username or password!";
    }



}





