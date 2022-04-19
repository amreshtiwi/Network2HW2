<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db = "EmployeesDB";

$con = new PDO("mysql:host={$hostname};dbname={$db}", $username, $password);

if(isset($_REQUEST['']))



$sql2 = "SELECT * FROM EMPLOYEE WHERE ID = 0";
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
while ( $row != null && $count < 5){
    echo "|&&|" . $row["ID"] . "|&|" . $row["Name"]. "|&|" . $row["Address"]. "|&|" . $row["Email"]. "|&&|" ;
    $count++;
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

$con = null;
