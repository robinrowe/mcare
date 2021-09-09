<?php
	
// saveAutoFloor.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$x = clean($_GET['x1']);	
$y = clean($_GET['y1']);
$color = clean($_GET['color']);
$room = clean($_GET['room']);

if(isset($_GET['x1']))$r = mysqli_query($dblink,"insert into floors (x,y,color,room) values ('".$x."','".$y."','".$color."','".$room."')");

drawCustomPolygon($room);
drawFloor($room);
$segments = [];
goAuto($room);

header("location: autoFloor.php?room=".$room);
	
?>