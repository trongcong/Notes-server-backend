<?php

require_once 'DBOperations.php';
require_once 'Functions.php';

$db = new DBOperations();
$fun = new Functions();

// $db -> insertUser("Cờ Ông Công", "trongcong96@gmail.com", 'admin!@#', '0987485414');


// $db->checkPass("trongcong96@gmail.com", "admin!@#");
// $db->checkUserExist("trongcong96@gmail.com" );
// echo $fun -> registerUser("Cong", "a@gmail.com", "", "0123");
echo $fun -> loginUser("trongcong96@gmail.com", "admin!@#");