<?php
	
// saveDot.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
	
$x1 = clean($_GET['x1']);
$y1 = clean($_GET['y1']);
$x2 = clean($_GET['x2']);
$y2 = clean($_GET['y2']);
$room = clean($_GET['room'];
	
$valoresa = getNearest($x1,$y1,$x2,$y2);
$x1 = $valoresa[0];
$y1 = $valoresa[1];
$x2 = $valoresa[2];
$y2 = $valoresa[3];
	
if (abs($y2-$y1) < 3) $y2 = $y1;
if (abs($x2-$x1) < 3) $x2 = $x1;
	
$query = "insert into maps (x1,y1,x2,y2,roomname) values ('".$x1."','".$y1."','".$x2."','".$y2."','".$room."')";
$result = mysqli_query($dblink,$query);
draw($room);
    
?>