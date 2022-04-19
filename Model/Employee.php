<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db = "EmployeesDB";

$con = new PDO("mysql:host={$hostname};dbname={$db}", $username, $password);

$sql2 = "SELECT * FROM EMPLOYEE WHERE adminflag != 0";
$stmt = $con->prepare( $sql2 );
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_GET['startFrom'])){
    $count = 0;
    while ( $row != null && $count < $_GET['startFrom']){
        $count++;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
$count = 0;

if($row == null){
    echo 'NOT';
}

while ( $row != null && $count < 5){
    echo "|&&|" . $row["ID"] . "|&|" . $row["Name"]. "|&|" . $row["Address"]. "|&|" . $row["Email"]. "|&&|" ;
    $count++;
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}


$con = null;
