<?php
	
// functions.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

function scaleDB(){
    global $dblink;
    //get biggest x value
    $result = mysqli_query($dblink,"select max(x) from plantPoints where plant='1'");
    while($row = mysqli_fetch_row($result)){
       $max_x = $row[0];
    }
    //get biggest y value
    $result2 = mysqli_query($dblink,"select max(y) from plantPoints where plant='1'");
    while($row2 = mysqli_fetch_row($result2)){
       $max_y = $row2[0];
    }
    $max = $max_x;
    if($max_y > $max) $max = $max_y;
    if($max > 500){
        $multiplicador = 500/$max;
    
       //update resized values
       $result3 = mysqli_query($dblink,"select x,y,id from plantPoints where plant='1'");
       while($row3 = mysqli_fetch_row($result3)){
          $v_x = $row3[0];
          $v_y = $row3[1];
          $id = $row3[2];
          $newx = round($v_x * $multiplicador);
          $newy = round($v_y * $multiplicador);
          $result4 = mysqli_query($dblink,"update plantPoints set x='".$newx."',y='".$newy."' where plant='1' and id='".$id."'");
       }
    }
}

function checkpoint($x,$y){
    global $polygon;
    $pointLocation = new pointLocation();
    $point = $x." ".$y;
    return($pointLocation->pointInPolygon($point, $polygon));
}

function getNewSize($size){
   $newsize = (($size/100)*2)-5;
   return($newsize);
}

function getComprimento($x,$y,$x1,$y1){
   $a = $x1-$x;
   $b = $y1-$y;
   $comprimento = ($a*$a) + ($b*$b);
   $comprimento = sqrt($comprimento);
   $centerx = $x + ($a/2);
   $centery = $y + ($b/2);
   if($a == 0){
      $rotacao = 90;
   }else{
      $rotacao = rad2deg(atan($b/$a));
   }
   $rotacao = $rotacao + 90;
   $out[] = $comprimento;
   $out[] = $centerx;
   $out[] = $centery;
   $out[] = $rotacao;
   return($out);
} 

function newcenter($x,$y,$centerx,$centery,$x2,$y2){
    $checkx = $x + 1;
    $checky = $y + 1;
    $checkx2 = $x2 + 1;
    $checky2 = $y2 + 1;
    $checkpoint = checkpoint($checkx,$checky);
    $checkpoint2 = checkpoint($checkx2,$checky2);
    if($checkpoint == "outside" && $checkpoint2 == "outside"){
       $centerxw = $centerx + 0.01;
       $centeryw = $centery + 0.01;
       $out[0] = $centerxw;
       $out[1] = $centeryw;
       return($out);
    }
    
    $checkx = $x + 1;
    $checky = $y - 1;
    $checkx2 = $x2 + 1;
    $checky2 = $y2 - 1;
    $checkpoint = checkpoint($checkx,$checky); 
    $checkpoint2 = checkpoint($checkx2,$checky2);
    if($checkpoint == "outside" && $checkpoint2 == "outside"){
       $centerxw = $centerx + 0.01;
       $centeryw = $centery - 0.01;
       $out[0] = $centerxw;
       $out[1] = $centeryw;
       return($out);
    }
    
    $checkx = $x - 1;
    $checky = $y + 1;
    $checkx2 = $x2 - 1;
    $checky2 = $y2 + 1;
    $checkpoint = checkpoint($checkx,$checky);  
    $checkpoint2 = checkpoint($checkx2,$checky2);
    if($checkpoint == "outside" && $checkpoint2 == "outside"){
       $centerxw = $centerx - 0.01;
       $centeryw = $centery + 0.01;
       $out[0] = $centerxw;
       $out[1] = $centeryw;
       return($out);
    }
    
    $checkx = $x - 1;
    $checky = $y - 1;
    $checkx2 = $x2 - 1;
    $checky2 = $y2 - 1;
    $checkpoint = checkpoint($checkx,$checky);  
    $checkpoint2 = checkpoint($checkx2,$checky2);
    if($checkpoint == "outside" && $checkpoint2 == "outside"){
       $centerxw = $centerx - 0.01;
       $centeryw = $centery - 0.01;
       $out[0] = $centerxw;
       $out[1] = $centeryw;
       return($out);
    }
}

class pointLocation {
    var $pointOnVertex = true; 

    function pointLocation() {
    }

    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;

        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }

        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }

        $intersections = 0; 
        $vertices_count = count($vertices);

        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }

    }

    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

}
?>