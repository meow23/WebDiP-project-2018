<?php
require ("database.class.php");


if(isset($_POST['usernameLog'])&&isset($_POST['passwordLog'])){

    $username = $_POST["usernameLog"];
    $password = $_POST["passwordLog"];

    date_default_timezone_set('Europe/Berlin');
    $date = date('Y-m-d  G:i:s', time());

    $sql = "SELECT * FROM  `Korisnik`  WHERE korisnicko_ime='" . $username . "' AND lozinka='" . $password . "'";

    $logUser = new Database();
    $logUser ->connectDB();

    $result = $logUser->sqlQuery($sql);
    $result = mysqli_num_rows($result);

    if($result==1){;
        $_SESSION['timeout'] = time()*8400;
        $_SESSION['usernameLog'] = $username;
        $_SESSION['passwordLog'] = $password;
        header("Location: https://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x138/proizvodi.php" );
        echo "<script>$('#logout').removeClass('button-hide')</script>";
    }
    else {
        echo "Invalid username or password!";
    }

}





