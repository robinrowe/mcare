<?php
	
// pathMark.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
	
$x = clean($_GET['x1']);
$y = clean($_GET['y1']);
$room = clean($_GET['room']);
$type = clean($_GET['type']);

$query = "insert into pathMarks (x,y,roomname,type) values ('".$x."','".$y."','".$room."','".$type."')";
$result = mysqli_query($dblink,$query);
drawPath('plantPath_'.$room.'.jpg',$room);
	
header("location: path.php?room=".$room);	

?>