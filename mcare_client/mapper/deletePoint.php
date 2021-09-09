<?php
	
// deletePoint.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");

$resulta = mysqli_query($dblink,"select roomname from maps where id='".clean($_GET['id'])."'"); 
while($rowa = mysqli_fetch_row($resulta)){
   $room = $rowa[0];
}
$result = mysqli_query($dblink,"delete from maps where id='".clean($_GET['id'])."'");  
draw($room);   
     	
header("location: start.php?room=".$room);

?>