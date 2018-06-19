<?php

require 'database.class.php';

if (sizeof($_POST) < 1)
    exit("Query not sent");

$db = new Database();

$db->connectDB();

echo $db->sqlQueryJson($_POST["query"]);

$db->CloseConnection();