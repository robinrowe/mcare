<?php

// deleteLocal.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");
$id = clean($_GET['id']);
$result = mysqli_query($dblink,"delete from locals  where id='".$id."'");
header("location: index.php?p=1");

?>