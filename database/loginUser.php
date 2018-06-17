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
    $result = mysqli_fetch_row($result);

    echo"<user>";
    if($result!=0){
        echo "<validUser>1</validUser>";
        $_SESSION['timeout'] = time()*8400;
        $_SESSION['usernameLog'] = $username;

    }
    else {
        echo "<validUser>0</validUser>";
        //unset($_SESSION['usernameLog']);
        //unset($_SESSION['passwordLog']);
        echo("session died!");
    }

    echo "</user>";
}





