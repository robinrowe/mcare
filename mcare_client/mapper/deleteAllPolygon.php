<?php
	
include("db.php");

// deleteAllPolygon.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

$room = clean($_GET['room']);
$id = clean($_GET['id']);

$r1 = mysqli_query($dblink,"delete from floor where floorid='".$id."'");  

drawCustomPolygon($room);
drawFloor($room);
$segments = [];
goAuto($room);  
      	
header("location: addFloor.php?room=".$room);

?>