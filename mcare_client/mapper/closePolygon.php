<?php
	
// closePolygon.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$color = clean($_GET['color']);
$room = clean($_GET['room']);
	
$result = mysqli_query($dblink,"select max(cast(floorId as unsigned)) from floor");
while($row = mysqli_fetch_row($result)){
   $max = $row[0] + 1;
}
if($max == "") $max = "1";
if($color != "")$result = mysqli_query($dblink,"update floor set floorId='".$max."',color='".$color."',room='".$room."' where floorId=''");
	
drawCustomPolygon($room);
drawFloor($room);
$segments = [];
goAuto($room);

header("location: addFloor.php?room=".$room);	
	    
?>