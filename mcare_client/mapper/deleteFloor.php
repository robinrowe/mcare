<?php
	
// deleteFloor.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$room = clean($_GET['room']);
$result = mysqli_query($dblink,"delete from floors where id='".clean($_GET['id'])."'");  
drawCustomPolygon($room);
drawFloor($room);
$segments = [];
goAuto($room);        	
header("location: saveAutoFloor.php?room=".$room);

?>