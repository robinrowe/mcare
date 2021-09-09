<?php
	
// redrawValues.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$out = "";
$room = clean($_GET['room']);
$result = mysqli_query($dblink,"select x1,y1,x2,y2,id from maps where roomname='".$room."'");
while($row = mysqli_fetch_row($result)){
   $x1 = $row[0];
   $x2 = $row[2];
   $y1 = $row[1];
   $y2 = $row[3];
   $id = $row[4];
       
   $showx1 = substr("0000".$x1,-4);
   $showx2 = substr("0000".$x2,-4);
   $showy1 = substr("0000".$y1,-4);
   $showy2 = substr("0000".$y2,-4);
       
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview(".$x1.",".$y1.",".$x2.",".$y2.")' style='font-size:12px'>".$showx1." ".$showy1." | ".$showx2." ".$showy2.'</span> <a class="prompt" href="deletePoint.php?id='.$id.'">Delete</a><br>';
}

echo $out;	
	
?>