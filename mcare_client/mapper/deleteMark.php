<?php
	
// deleteMark.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$room = clean($_GET['room']);
$r1 = mysqli_query($dblink,"delete from pathMarks where id='".clean($_GET['id'])."'");  
drawPath('plantPath_'.$room.'.jpg',$room);
header("location: path.php?room=".$room);

?>