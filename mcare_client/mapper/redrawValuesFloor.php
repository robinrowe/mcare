<?php
	
// redrawValuesFloor.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
include("db.php");
$out = "";
$points = 0;
$room = clean($_GET['room']);

$floortodelete = "0";
$result = mysqli_query($dblink,"select x1,y1,id from floor where room='".$room."'");
while($row = mysqli_fetch_row($result)){
   $x1 = $row[0];
   $y1 = $row[1];
   $id = $row[2];
   $showx1 = substr("0000".$x1,-4);
   $showy1 = substr("0000".$y1,-4);
       
   if($floorId != $floortodelete){
      $floortodelete = $floorId;
      if($floorId != "") $out = $out."<br><span class='prompt'><a href='deleteAllPolygon.php?room=".$room."&id=".$floorId."'>Delete all room ".$floorId."</a><br><br>";
   }
       
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview(".$x1.",".$y1.")' style='font-size:12px'>".$showx1." : ".$showy1.'</span>&nbsp;<a class="prompt" href="deletePointFloor.php?id='.$id.'&room='.$room.'">Delete</a>&nbsp;&nbsp;&nbsp;<br>';
   $points = $points + 1;
}

echo $out;

?>