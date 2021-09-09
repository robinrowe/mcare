<?php
	
// db.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

$dblink =  mysqli_connect("host","user","password");
if (!$dblink) die('Could not connect: ' . mysql_error());
mysqli_select_db($dblink,"who");
mysqli_query($dblink,"SET NAMES 'utf8';");
mysqli_query($dblink,"SET CHARACTER SET 'utf8';");

function clean($string){
   $string = str_replace('"', '', $string);
   $string = str_replace("'", '', $string);
   $string = str_replace('&', '', $string);	
   $string = str_replace(';', '', $string);	
   $string = str_replace('>', '', $string);
   $string = str_replace('<', '', $string);	
   return($string);	
}

?>