<?php
	
// saveProp.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
	
$x = clean($_GET['x']);
$y = clean($_GET['y']);
$angle = clean($_GET['angle']);
$size = clean($_GET['size']);
$type = clean($_GET['type']);
$room = clean($_GET['room']);

$x_array = explode(",", $x);
$y_array = explode(",", $y);
$angle_array = explode(",", $angle);
$size_array = explode(",", $size);
$type_array = explode(",", $type);

$result = mysqli_query($dblink,"delete from props");

for($n=0;$n<count($x_array);$n=$n+1){
	$thistype = $type_array[$n];
	$thistype = str_replace("1", "", $thistype);
	$thistype = str_replace("2", "", $thistype);
	$thistype = str_replace("3", "", $thistype);
	$thistype = str_replace(".png", "", $thistype);
	$thistype = str_replace("enfermaria", "bed", $thistype);
	$thistype = str_replace("armazem", "warehouse", $thistype);
	$thistype = str_replace("salaespera", "chairs", $thistype);
	$thistype = str_replace("consultorio", "desks", $thistype);
	$q = "insert into props (x,y,size,type,angle,room) values ('".round($x_array[$n])."','".round($y_array[$n])."','".round($size_array[$n])."','".$thistype."','".round($angle_array[$n])."','".$room."')";
	if($thistype != "")$result = mysqli_query($dblink,$q);
	
}

header("location: addProp.php?room=".$room);	
	
?>