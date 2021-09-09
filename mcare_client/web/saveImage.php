<?php
	
// saveImage.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");
$img = clean($_POST['hidden_data']);
$plant = $_POST['plant'];   
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = "uploads/".time().'.png';
$success = file_put_contents($file, $data);
$now = date("YmdHis");
$query = "insert into images (plant,image,timestamp) values ('".$plant."','".$file."','".$now."')";
$result = mysqli_query($dblink,$query);
echo $result;

?>