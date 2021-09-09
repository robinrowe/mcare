<?php
	
// saveDotFloor.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
	
$x1 = clean($_GET['x1']);
$y1 = clean($_GET['y1']);
$room = clean($_GET['room']);
$x1 = getDividedBy5($x1);
$y1 = getDividedBy5($y1);
	
$query = "insert into floor (x1,y1,floorId,color,room) values ('".$x1."','".$y1."','','','".$room."')";
$result = mysqli_query($dblink,$query);
    
drawCustomPolygon($room);
drawFloor($room);
$segments = [];
goAuto($room);
    
function getDividedBy5($numero){
   $resto = $numero%5;
   if($resto == 1) $numero = $numero - 1;
   if($resto == 2) $numero = $numero - 2;
   if($resto == 3) $numero = $numero + 2;
   if($resto == 4) $numero = $numero + 1;
   return($numero);
}
    
?>