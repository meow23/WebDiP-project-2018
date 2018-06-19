<?php
session_start();
session_unset();
//unset($_SESSION);
session_destroy();
header('Location: https://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x138/prijava.php');