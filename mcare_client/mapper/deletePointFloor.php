<?php
	
// deletePointFloor.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");

$result = mysqli_query($dblink,"select floorId,room from floor where id='".clean($_GET['id'])."'");
while($row = mysqli_fetch_row($result)){
   $floor = $row[0];
   $room = $row[1];
}               
               
$r = mysqli_query($dblink,"update floor set floorId='' where floorId ='".$floor."' and room='".$room."'"); 
$r1 = mysqli_query($dblink,"delete from floor where id='".clean($_GET['id'])."'");  

drawCustomPolygon($room);
drawFloor($room);
$segments = [];
goAuto($room);  
      	
header("location: addFloor.php?room=".$room);

?>