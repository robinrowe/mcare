<?php
	
// changeTheme.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");
$theme = clean($_GET['theme']);
$sql = "update settings set theme='".$theme."'";

$resulti = mysqli_query($dblink,$sql);
header("location: main.php")

?>