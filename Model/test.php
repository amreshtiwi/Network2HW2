<?php

$host = "localhost";
$db_name = "casescovid19";
$username = "root";
$password = "";
 
$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

if(!empty($_GET["AllCity"]) && !empty($_GET["City"]) && !empty($_GET["Type"])){
  if($_GET["Type"] == "AllCases"){
    $sql2 = "SELECT SUM(Death) AS value_sum FROM cases where City='".$_GET["City"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumD = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Confirmed) AS value_sum FROM cases where City='".$_GET["City"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumC = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Recovered) AS value_sum FROM cases where City='".$_GET["City"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumR = $row['value_sum'];
   
    if($sumC == 0 or $sumR == 0 or $sumD == 0  ){
      echo 0;
      echo " ";
      echo 0 ." ". 0 ." ". 0;  
    }
    else{
      echo $sumC;
      echo " ";
      echo $sumC-$sumR-$sumD ." ". $sumR ." ". $sumD;
    }
  }
  else{
    $sql2 = "SELECT SUM(Death) AS value_sum FROM cases where City='".$_GET["City"]."' and Date='".$_GET["Type"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumD = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Confirmed) AS value_sum FROM cases where City='".$_GET["City"]."' and Date='".$_GET["Type"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumC = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Recovered) AS value_sum FROM cases where City='".$_GET["City"]."' and Date='".$_GET["Type"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumR = $row['value_sum'];
    
    if($sumC == 0 or $sumR == 0 or $sumD == 0  ){
      echo 0;
      echo " ";
      echo 0 ." ". 0 ." ". 0;  
    }
    else{
      echo $sumC;
      echo " ";
      echo $sumC ." ". $sumR ." ". $sumD;
    }
  }
}
else
  if(!empty($_GET["All"])){

    $sql2 = "SELECT SUM(Death) AS value_sum FROM cases";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumD = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Confirmed) AS value_sum FROM cases";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumC = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Recovered) AS value_sum FROM cases";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumR = $row['value_sum'];
   
    echo $sumC;
    echo " ";
    echo $sumC-$sumR-$sumD ." ". $sumR ." ". $sumD;
    
  } 
  else
  if(!empty($_GET["AllCity"])){

    $sql2 = "SELECT SUM(Death) AS value_sum FROM cases";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumD = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Confirmed) AS value_sum FROM cases";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumC = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Recovered) AS value_sum FROM cases";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumR = $row['value_sum'];
   
    echo $sumC;
    echo " ";
    echo $sumC-$sumR-$sumD ." ". $sumR ." ". $sumD;
    
   
  }
else
  if(!empty($_GET["CityToAdd"]) && !empty($_GET["DateToAdd"]) && (!empty($_GET["Confirmed"]) || $_GET["Confirmed"] == 0 ) && (!empty($_GET["Recoverd"]) || $_GET["Recoverd"] == 0 ) && (!empty($_GET["Death"]) || $_GET["Death"] == 0 )){
    $query = "select City FROM cases"; 
    $count = 0;
    $stmt = $con->prepare( $query );
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $count = $count + 1 ;
    }
    $count += 1;

    $query = "select City, Date, Confirmed, Recovered, Death FROM cases where City='".$_GET["CityToAdd"]."' and Date='".$_GET["DateToAdd"]."'"; 
    $stmt = $con->prepare( $query );
    $stmt->execute();
    
    $flag = 0;
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $flag = $flag+1;
    }
    if($flag !=  0){
      $newCo = $row['Confirmed'] +  $_GET["Confirmed"];
      $newRe = $row['Recovered'] + $_GET["Recoverd"];
      $newDe = $row['Death'] + $_GET["Death"];
      $sql = "UPDATE cases SET Confirmed='".$newCo."',Recovered='".$newRe."',Death='".$newDe."'WHERE Date='".$_GET["DateToAdd"]."' and City='".$_GET["CityToAdd"]."'";

      if ($con->query($sql) == TRUE) {
        echo "Record updated successfully";
      } else {
        echo "lost";
      }
    }
    else{
      //echo $_GET["CityToAdd"] ." ". $_GET["DateToAdd"] ." ". $_GET["Confirmed"] ." ". $_GET["Recoverd"] ." ". $_GET["Death"];
      $sql = "INSERT INTO `cases` (`ID`, `City`, `Date`, `Confirmed`, `Recovered`, `Death`) VALUES ('".$count."', '".$_GET["CityToAdd"]."', '".$_GET["DateToAdd"]."', '".$_GET["Confirmed"]."', '".$_GET["Recoverd"]."', '".$_GET["Death"]."')";
      if ($con->query($sql) == TRUE) {
        echo "New record created successfully";
      } else {
        echo "lost";
      }
    }
  }
else
  if(!empty($_GET["Edit"]) && !empty($_GET["CityToEditCase"]) && !empty($_GET["DateToEditCase"])){
    
    $sql2 = "SELECT SUM(Death) AS value_sum FROM cases where City='".$_GET["CityToEditCase"]."' and Date='".$_GET["DateToEditCase"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumD = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Confirmed) AS value_sum FROM cases where City='".$_GET["CityToEditCase"]."' and Date='".$_GET["DateToEditCase"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumC = $row['value_sum'];
    
    $sql2 = "SELECT SUM(Recovered) AS value_sum FROM cases where City='".$_GET["CityToEditCase"]."' and Date='".$_GET["DateToEditCase"]."'";
    $stmt = $con->prepare( $sql2 );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sumR = $row['value_sum'];
    
    if($sumC == 0 or $sumR == 0 or $sumD == 0  ){
      echo 0 ." ". 0 ." ". 0;  
    }
    else{
      echo $sumC ." ". $sumR ." ". $sumD;
    }
  }
else
  if(!empty($_GET["Edit"]) && !empty($_GET["CityToEditCaseUpdate"]) && !empty($_GET["DateToEditCaseUpdate"]) && (!empty($_GET["Conf"]) or $_GET["Conf"] == 0) && (!empty($_GET["Rec"]) or $_GET["Rec"] == 0) && (!empty($_GET["De"]) or $_GET["De"] == 0)  ){
    $sql = "UPDATE cases SET Confirmed='".$_GET["Conf"]."', Recovered='".$_GET["Rec"]."', Death='".$_GET["De"]."' WHERE City='".$_GET["CityToEditCaseUpdate"]."' and Date='".$_GET["DateToEditCaseUpdate"]."'";

    if ($con->query($sql) == TRUE) {
      echo "Record updated successfully";
    } else {
      echo "lost";
    }

  }
else{
  echo "GG WP DOTA2";
  //echo $_GET["CityToAdd"] . $_GET["DateToAdd"] . $_GET["Confirmed"] . $_GET["Recoverd"] . $_GET["Death"];
}

 /*
//get from database
$query = "SELECT City FROM cases";
$stmt = $con->prepare( $query );
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<div>Name: " . $row['City'] . "</div>";
//


// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 */


// Attempt insert query execution
/*
$sql = "INSERT INTO `cases` (`ID`, `City`, `Date`, `Confirmed`, `Recovered`, `Death`) VALUES ('5333', 'Jerusalem', '28-7-2020', '22', '14', '3')";
if ($con->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "lost";
}

*/


/*
// sql to delete a record
$sql = "DELETE FROM cases WHERE id=23";

if ($con->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "lost";
}
*/

//Update SQL
/*
$sql = "UPDATE cases SET city='Ramallah' WHERE id=1";

if ($con->query($sql) == TRUE) {
  echo "Record updated successfully";
} else {
  echo "lost";
}
*/

/*
// get sum 
$sql2 = "SELECT SUM(Death) AS value_sum FROM cases";
$stmt = $con->prepare( $sql2 );
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sumD = $row['value_sum'];

$sql2 = "SELECT SUM(Confirmed) AS value_sum FROM cases";
$stmt = $con->prepare( $sql2 );
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sumC = $row['value_sum'];

$sql2 = "SELECT SUM(Recovered) AS value_sum FROM cases";
$stmt = $con->prepare( $sql2 );
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sumR = $row['value_sum'];

echo $sumD , "<br>";
echo $sumC , "<br>";
echo $sumR , "<br>";
echo $sumD + $sumC + $sumR;
*/


?>