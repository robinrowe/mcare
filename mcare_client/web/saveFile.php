<?php
	
// saveFile.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");

$plant = clean($_POST['imgplant']);
$now = date("YmdHis");

if(!empty($_FILES)){
    $name = $_FILES['file']['name'];
    $tempFile = $_FILES['file']['tmp_name'];
    $targetFile = "uploads/".$_FILES['file']['name'];
    if(! move_uploaded_file($tempFile,$targetFile)){
        //echo "erro";
    }
    
    $query = "insert into images (plant,image,timestamp) values ('".$plant."','".$targetFile."','".$now."')";
    $result = mysqli_query($dblink,$query);
}

header("location: main.php?p=5&id=".$plant);

?>

