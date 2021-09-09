<?php
	
// saveDivision.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");

$name = clean($_POST['name']);
$x = clean($_POST['x']);
$y = clean($_POST['y']);
$rot = clean($_POST['rot']);
$lvl = clean($_POST['lvl']);
$local = clean($_POST['local']);
$id = clean($_POST['id']);

if($id == ""){
    $query = "insert into plants (name,lvl,local) values ('".$name."','".$lvl."','".$local."')";
}else{
    $query = "update plants set name='".$name."',lvl='".$lvl."',local='".$local."' where id='".$id."'";
}

$result = mysqli_query($dblink,$query);

header("location: index.php?p=3&id=".$local);

?>
