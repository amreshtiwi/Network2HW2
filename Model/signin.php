<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db = "EmployeesDB";

$con = new PDO("mysql:host={$hostname};dbname={$db}", $username, $password);

if(!isset($_REQUEST['ID']) || !isset($_REQUEST['password'])){
    echo 'NO USER!';
    return;
}

$usrID = $_REQUEST['ID'];
$usrPswd = sha1($_REQUEST['password']);

$sql2 = "SELECT * FROM EMPLOYEE WHERE ID =" . $usrID . " AND password =" .$usrPswd;
$stmt = $con->prepare( $sql2 );
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if( $row != null ){
    if ($row['adminflag'] == 1) echo "ADMIN";
    else echo "EMPLOYEE";
    echo "|&|" . $row["ID"] . "|&|" . $row["Name"]. "|&|" . $row["Address"]. "|&|" . $row["Email"] ;
} 
else echo'NO USER FOUND!';

$con = null;
