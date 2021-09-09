<?php
	
// deleteimage.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");
$id = clean($_GET['id']);

$result_p = mysqli_query($dblink,"select plant from images where id='".$id."'");
while($row_p = mysqli_fetch_row($result_p)){
   $plant = $row_p[0];
}

$result = mysqli_query($dblink,"delete from images  where id='".$id."'");
header("location: main.php?p=5&id=".$plant);

?>