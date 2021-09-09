<?php
	
// redrawPath.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$room = clean($_GET['room']);

$out = "";
$points = 0;
$result = mysqli_query($dblink,"select x1,y1,x2,y2,id from path where room='".$room."'");
while($row = mysqli_fetch_row($result)){
   $x1 = $row[0];
   $y1 = $row[1];
   $id = $row[4];
   $x2 = $row[2];
   $y2 = $row[3];
   $showx1 = substr("0000".$x1,-4);
   $showy1 = substr("0000".$y1,-4);
   $showx2 = substr("0000".$x2,-4);
   $showy2 = substr("0000".$y2,-4);
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview(".$x1.",".$y1.",".$x2.",".$y2.")' style='font-size:12px'>".$showx1." : ".$showy1."  ".$showx2." : ".$showy2.'</span>&nbsp;<a class="prompt" href="deletePath.php?id='.$id.'&room='.$room.'">Delete</a>&nbsp;&nbsp;&nbsp;<br>';
   $points = $points + 1;
}
     
$out = $out."<h3>Marks</h3>";
//marks
$resultw = mysqli_query($dblink,"select x,y,id from pathMarks where roomname='".$room."'");
while($roww = mysqli_fetch_row($resultw)){
   $x1 = $roww[0];
   $y1 = $roww[1];
   $id = $roww[2];
   $showx1 = substr("0000".$x1,-4);
   $showy1 = substr("0000".$y1,-4);
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview2(".$x1.",".$y1.")' style='font-size:12px'>".$showx1." : ".$showy1.'</span>&nbsp;<a class="prompt" href="deleteMark.php?id='.$id.'&room='.$room.'">Delete</a>&nbsp;&nbsp;&nbsp;<br>';
       
}

echo $out;

?>