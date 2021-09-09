<?php
	
// deletePlant.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");
$id = clean($_GET['id']);

$result_p = mysqli_query($dblink,"select local from plants where id='".$id."'");
while($row_p = mysqli_fetch_row($result_p)){
   $local = $row_p[0];
}

$result = mysqli_query($dblink,"delete from plants  where id='".$id."'");
header("location: index.php?p=3&id=".$local);

?>