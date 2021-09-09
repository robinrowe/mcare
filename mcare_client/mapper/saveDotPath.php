<?php
	
// saveDotPath.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
	
$x1 = clean($_GET['x1']);
$y1 = clean($_GET['y1']);
$x2 = clean($_GET['x2']);
$y2 = clean($_GET['y2']);
$bi = clean($_GET['bi']);
$room = clean($_GET['room']);
$white = clean($_GET['white']);
		
$x1 = getDividedBy5($x1);
$y1 = getDividedBy5($y1);
$x2 = getDividedBy5($x2);
$y2 = getDividedBy5($y2);
	
$query = "insert into path (x1,y1,x2,y2,bidirectional,room,white) values ('".$x1."','".$y1."','".$x2."','".$y2."','".$bi."','".$room."','".$white."')";
$result = mysqli_query($dblink,$query);
drawPath('plantPath_'.$room.'.jpg',$room);
    
function getDividedBy5($numero){
   $resto = $numero%5;
   if($resto == 1) $numero = $numero - 1;
   if($resto == 2) $numero = $numero - 2;
   if($resto == 3) $numero = $numero + 2;
   if($resto == 4) $numero = $numero + 1;
   return($numero);
}
	
?>