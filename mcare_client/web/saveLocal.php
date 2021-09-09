<?php
	
// saveLocal.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");

$name = clean($_POST['name']);
$country = clean($_POST['localCountry']);
$city = clean($_POST['city']);
$longitude = clean($_POST['longitude']);
$latitude = clean($_POST['latitude']);
$idLocal = clean($_POST['idLocal']);
$gmaps = clean($_POST['gmaps']);

if($idLocal == ""){
    $query = "insert into locals (name,country,city,latitude,longitude,gmaps) values ('".$name."','".$country."','".$city."','".$latitude."','".$longitude."','".$gmaps."')";
    $result = mysqli_query($dblink,$query);
    $newid = mysqli_insert_id($dblink);
}else{
    $query = "update locals set name='".$name."',country='".$country."',city='".$city."',latitude='".$latitude."',longitude='".$longitude."',gmaps='".$gmaps."' where id='".$idLocal."'";
    $result = mysqli_query($dblink,$query);
    $newid = $idLocal;
}


header("location: index.php?p=3&id=".$newid);

?>