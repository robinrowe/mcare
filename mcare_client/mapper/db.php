<?php
	
// db.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

$dblink =  mysqli_connect("host","user","password");
if (!$dblink) {
    die('Could not connect: ' . mysql_error());
}
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

function draw($room){
   global $dblink;
   $image = imagecreatefromjpeg('original_'.$room.'.jpg');
   list($width, $height, $type, $attr) = getimagesize('original_'.$room.'.jpg');
   $imageEmpty = imagecreatetruecolor($width, $height);
   $bg = imagecolorallocate ( $imageEmpty, 255, 255, 255 );
   imagefilledrectangle($imageEmpty,0,0,$width,$height,$bg);

   $green = imagecolorallocate($image, 0, 255, 0);
   $blue = imagecolorallocate($image, 0, 0, 255);
   imagesetthickness($image, 1);
   $result = mysqli_query($dblink,"select x1,y1,x2,y2 from maps where roomname='".$room."'");
   while($row = mysqli_fetch_row($result)){
      $x1 = $row[0];
      $y1 = $row[1];
      $x2 = $row[2];
      $y2 = $row[3];
      imageline($image, $x1, $y1,  $x2 , $y2, $green);
      imagefilledellipse($image, $x1, $y1, 5, 5, $blue);
      imagefilledellipse($image, $x2, $y2, 5, 5, $blue);
      imageline($imageEmpty, $x1, $y1,  $x2 , $y2, $green);
      imagefilledellipse($imageEmpty, $x1, $y1, 5, 5, $blue);
      imagefilledellipse($imageEmpty, $x2, $y2, 5, 5, $blue);
   }
   imagejpeg($image,"plant_".$room.".jpg");
   imagejpeg($imageEmpty,"emptyPlant_".$room.".jpg");
   imagedestroy($image);
   imagedestroy($imageEmpty);
}
	
function drawFloor($room){
   global $dblink;
   $image = imagecreatefromjpeg('plantaFloor.jpg');
   list($width, $height, $type, $attr) = getimagesize('plantaFloor.jpg');
   $imageEmpty = imagecreatetruecolor($width, $height);
   $bg = imagecolorallocate ( $imageEmpty, 255, 255, 255 );
   imagefilledrectangle($imageEmpty,0,0,$width,$height,$bg);

   $green = imagecolorallocate($image, 0, 255, 0);
   $blue = imagecolorallocate($image, 0, 0, 255);
   imagesetthickness($image, 1);
	    
   $result = mysqli_query($dblink,"select x1,y1 from floor where floorId='' and room='".$room."' order by id desc");
   while($row = mysqli_fetch_row($result)){
      $x1[] = $row[0];
      $y1[] = $row[1];
   }   
   if(count($x1) > 1){
      for($z=0;$z<count($x1)-1;$z=$z+1){
         $r = $z+1;
         imageline($image, $x1[$z], $y1[$z],  $x1[$r] , $y1[$r], $green);
         imagefilledellipse($image, $x1[$z], $y1[$z], 5, 5, $blue);
         imagefilledellipse($image, $x1[$r], $y1[$r], 5, 5, $blue);
         imageline($imageEmpty, $x1[$z], $y1[$z],  $x1[$r] , $y1[$r], $green);
         imagefilledellipse($imageEmpty, $x1[$z], $y1[$z], 5, 5, $blue);
         imagefilledellipse($imageEmpty, $x1[$r], $y1[$r], 5, 5, $blue);
      }
   }
        
   imagejpeg($image,"plantaFloor.jpg");
   //imagejpeg($imageEmpty,"plantaEmptyFloor.jpg");
   imagedestroy($image);
   imagedestroy($imageEmpty);
}

function drawCustomPolygon($room){
   global $dblink;
   $image = imagecreatefromjpeg("emptyPlant_".$room.".jpg");
   list($width, $height, $type, $attr) = getimagesize("emptyPlant_".$room.".jpg");
   $imageEmpty = imagecreatetruecolor($width, $height);
   $bg = imagecolorallocate ( $imageEmpty, 255, 255, 255 );
   imagefilledrectangle($imageEmpty,0,0,$width,$height,$bg);

   $green = imagecolorallocate($image, 0, 255, 0);
   $blue = imagecolorallocate($image, 0, 0, 255);
   $red = imagecolorallocate($image, 255, 0, 0);
   $yellow = imagecolorallocate($image, 255,255,0);
   $black = imagecolorallocate($image, 0,0,0);
	    
   imagesetthickness($image, 1);
	    
   $resultx = mysqli_query($dblink,"select distinct(floorId) from floor where room='".$room."'");
   while($rowx = mysqli_fetch_row($resultx)){
      $floor = $rowx[0];
	  $numpoints = 0;
	  $result = mysqli_query($dblink,"select x1,y1,color from floor where floorId='".$floor."' and room='".$room."'order by id desc");
       while($row = mysqli_fetch_row($result)){
          $x1 = $row[0];
          $y1 = $row[1];
          $color = $row[2];
          $numpoints = $numpoints + 1;
          $values[] = $x1;
          $values[] = $y1;
      }   
      if($color == 1) $c = $red;
      if($color == 2) $c = $green;
      if($color == 3) $c = $blue;
      if($color == 4) $c = $yellow;
      if($color == 5) $c = $black;
      if($color == 6) $c = "pattern1.png";
      if($color == 7) $c = "pattern2.png";
      if($color == 8) $c = "pattern3.png";
      if($color == 9) $c = "pattern4.png";
            
      if($color < 5){
         imagefilledpolygon($image, $values, $numpoints, $c);
         imagefilledpolygon($imageEmpty, $values, $numpoints, $c);
      //patterns
      }else{
         imagefilledpolygon($image, $values, $numpoints, $black);
         imagefilledpolygon($imageEmpty, $values, $numpoints, $black);
         if($color > 5) {
            $image = imagealphamask( $imageEmpty,$c,1,$image);
            $imageEmpty = imagealphamask( $imageEmpty,$c,2,"");
         }     
      }
      unset($values);
   }    
   imagejpeg($image,"floorPlant_".$room.".jpg");
   imagejpeg($imageEmpty,"emptyFloorPlant_".$room.".jpg");
   imagedestroy($image);
   imagedestroy($imageEmpty);
} 

function process($id){
   global $segments;
   $segments[] = cleanId($id);	
}

function cleanId($id){
   if(substr($id,0,1) == "0") $id = substr($id,1);
   if(substr($id,0,1) == "0") $id = substr($id,1);
   if(substr($id,0,1) == "0") $id = substr($id,1);
   if(substr($id,0,1) == "0") $id = substr($id,1);
   return($id);
}



function getneighbour($id,$room){
   global $dblink;$out = "";
   $id = cleanId($id);
   global $segments;
   
   $result = mysqli_query($dblink,"select x1,y1,x2,y2 from maps where id='".$id."'");
    while($row = mysqli_fetch_row($result)){
       $x1 = $row[0];
       $y1 = $row[1];
       $x2 = $row[2];
       $y2 = $row[3];
    }
    //no ponto 1 ver quantoas ligacoes existem 
    $c1 = 0;
    $select = "select id from maps where roomname='".$room."' and  ((x1='".$x1."' and y1='".$y1."') or (x2='".$x1."' and y2='".$y1."')) and id <>'".$id."'";
    //echo $select."<br>";
    $result2 = mysqli_query($dblink,$select);
    while($row2 = mysqli_fetch_row($result2)){
       $pontosnoponto1[] = $row2[0];
       $c1 = $c1 + 1;
    }
    //no ponto 2 ver quantoas ligacoes existem 
    $c2 = 0;
    $select = "select id from maps where roomname='".$room."' and ((x1='".$x2."' and y1='".$y2."') or (x2='".$x2."' and y2='".$y2."')) and id <>'".$id."'";
    //echo $select."<br>";
    $result3 = mysqli_query($dblink,$select);
    while($row3 = mysqli_fetch_row($result3)){
       $pontosnoponto2[] = $row3[0];
       $c2 = $c2 + 1;
    } 
    
    if($c1 == 1){
	    $segments[] = $pontosnoponto1[0];
	    //getneighbour($pontosnoponto1[0]);
	}
    if($c2 == 1){
	    $segments[] = $pontosnoponto2[0];
	    //getneighbour($pontosnoponto2[0]);
	}
    
}


function getNearestPoint($x,$y,$room){
	global $dblink;
	$dst_out = 99999999999999;
	$out_id = "";
	$out_x = "";
	$out_y = "";
	$result = mysqli_query($dblink,"select x1,y1,x2,y2,id from maps where room='".$room."'");
    while($row = mysqli_fetch_row($result)){
       $x1 = $row[0];
       $y1 = $row[1];
       $x2 = $row[2];
       $y2 = $row[3];
       $id = $row[4];
       
       $xx = round(abs(($x2+$x1)/2));
       $yy = round(abs(($y2+$y1)/2));
       
       if($x2-$x1 == 0 ) $xx = $x2;
       if($y2-$y1 == 0 ) $yy = $y2;
       
       $dst = round(sqrt((($xx-$x)*($xx-$x)) + (($yy-$y)*($yy-$y))));
       $q = "insert into prov (idline,distance) values ('".$id."','".$dst."')";  
	   $r = mysqli_query($dblink,$q);  
	}
	$result = mysqli_query($dblink,"select idline,distance from prov order by distance");
    while($row = mysqli_fetch_row($result)){
       $idout = $row[0];
	   $distanceout = $row[1];
	   $out[] = substr("00000".$idout,-5)."#".$distanceout;
	}
	return($out);
}

//ordenar por proximidade
function ordena($position){
	$nextPosition = $position + 1;
	$nextPositionPlus = $position + 2;
	$nextPositionPlusTwo = $position + 3;
	global $dblink;
    $distancia = 99999999;
    $cnt = 0;
    $result7 = mysqli_query($dblink,"select x,y,id,segment from prov2 where position is null");
    while($row7 = mysqli_fetch_row($result7)){
       $x = $row7[0];
       $y = $row7[1];
       $id = $row7[2];
       $segment = $row7[3];
   
       if($cnt == 0){
	      $xref = $x;
	      $yref = $y;
	      $idref = $id;
	      $segmentref = $segment;
	      $result77 = mysqli_query($dblink,"update prov2 set position ='".$position."' where id='".$idref."'");
	      //vai buscar outra ponta do segmento
	      $result7a = mysqli_query($dblink,"select x,y,id from prov2 where segment='".$segmentref."' and id<>'".$idref."'");
	      while($row7a = mysqli_fetch_row($result7a)){
             $xref2 = $row7a[0];
             $yref2 = $row7a[1];
             $idref2 = $row7a[2];
          }   
          $result77a = mysqli_query($dblink,"update prov2 set position ='".$nextPosition."' where id='".$idref2."'");
	      
       }else{
	      if($segmentref != $segment){
	         $dst = round(sqrt((($x-$xref2)*($x-$xref2)) + (($y-$yref2)*($y-$yref2))));
	         if($dst < $distancia){
		        $distancia = $dst;
		        $endid = $id;
		        $endsegment = $segment;
	         }
	      }
       }
       $cnt = $cnt + 1;
    }
    $result77 = mysqli_query($dblink,"update prov2 set position ='".$nextPositionPlus."' where id='".$endid."'");
    $result77 = mysqli_query($dblink,"update prov2 set position ='".$nextPositionPlusTwo."' where id<>'".$endid."' and segment='".$endsegment."' ");
}


function goAuto($room){
   global $dblink;
   global $segments;
   global $image;
   global $imageEmpty;
   $image = imagecreatefromjpeg('emptyFloorPlant_'.$room.'.jpg');
   list($width, $height, $type, $attr) = getimagesize('floorPlant_'.$room.'.jpg');
   //$imageEmpty = imagecreatefromjpeg("emptyPlant_".$room.".jpg");

   $result = mysqli_query($dblink,"select x,y,color from floors where room='".$room."'");
   while($row = mysqli_fetch_row($result)){
      $thisx = $row[0];
      $thisy = $row[1];
      $thiscolor = $row[2];
      drawfloornow($thisx,$thisy,$thiscolor,$room);
      $segments = array();
      $segments = [];
   }	

   imagejpeg($image,'emptyFloorPlant_'.$room.'.jpg');
   //imagejpeg($imageEmpty,"floorPlant_".$room.".jpg");
   imagedestroy($image);
   imagedestroy($imageEmpty);
}

function drawfloornow($x,$y,$color,$room){
   global $segments;
   global $image;
   global $imageEmpty;
   
   list($width, $height, $type, $attr) = getimagesize('planta.jpg');
   $bg = imagecolorallocate ( $imageEmpty, 255, 255, 255 );
   imagefilledrectangle($imageEmpty,0,0,$width,$height,$bg);
   $green = imagecolorallocate($image, 0, 255, 0);
   $blue = imagecolorallocate($image, 0, 0, 255);
   $red = imagecolorallocate($image, 255, 0, 0);
   $yellow = imagecolorallocate($image, 255,255,0);
   $black = imagecolorallocate($image, 0,0,0);
   imagesetthickness($image, 1);
   global $dblink;
   $r = mysqli_query($dblink,"delete from prov");
   $r = mysqli_query($dblink,"delete from prov2");
   
   $maisperto = getNearestPoint($x,$y,$room);
   for($n=0;$n<3;$n=$n+1){
	  $id = substr($maisperto[$n],0,5);
	  process($id);
	  getneighbour($id,$room);
   }

   $numpoints = 0; 
   $result = array_unique($segments);
   sort($result);
   
   for($r=0;$r<count($result);$r=$r+1){
	  $id = $result[$r];
      $result5 = mysqli_query($dblink,"select x1,y1,x2,y2 from maps where id='".$id."'");
      while($row5 = mysqli_fetch_row($result5)){
	     $rx = mysqli_query($dblink,"insert into prov2 (x,y,segment) values ('".$row5[0]."','".$row5[1]."','".$numpoints."') ");
	     $rx = mysqli_query($dblink,"insert into prov2 (x,y,segment) values ('".$row5[2]."','".$row5[3]."','".$numpoints."') ");
         $numpoints = $numpoints + 2;
      }	
   }

   $numeroPontos = 0;
   $result6 = mysqli_query($dblink,"select x,y,id from prov2");
   while($row6 = mysqli_fetch_row($result6)){
      $x = $row6[0];
      $y = $row6[1];
      $id = $row6[2];
   
      //ver primeiro se id existe na bd
      $existe = "";
      $result66 = mysqli_query($dblink,"select x from prov2 where id='".$id."'");
      while($row66 = mysqli_fetch_row($result66)){
         $existe = $row66[0];
      }   
      if($existe != "") $rx2 = mysqli_query($dblink,"delete from prov2 where x='".$x."' and y='".$y."' and id <>'".$id."'");
      $numeroPontos = $numeroPontos + 1;
   }

   $result7 = mysqli_query($dblink,"select count(id) from prov2");
   while($row7 = mysqli_fetch_row($result7)){
      $numeroPontos = $row7[0];	
   }
	

   for($t=1;$t<$numeroPontos;$t=$t+4){
      ordena($t);
   }

   $numpoints = 0;
   $result8 = mysqli_query($dblink,"select x,y from prov2 order by position");
   while($row8 = mysqli_fetch_row($result8)){
      $x = $row8[0];
      $y = $row8[1];
      $values[] = $x;
      $values[] = $y;
      $numpoints = $numpoints + 1;
   }
   
   $clr = $red;
   if($color == "2") $clr = $green;
   if($color == "3") $clr = $blue;
   if($color == "4") $clr = $yellow;
   if($color == "5") $clr = $black;
   
   imagefilledpolygon($image, $values, $numpoints, $clr);
   imagefilledpolygon($imageEmpty, $values, $numpoints, $clr);
} 



function imagealphamask( $img, $pattern,$type,$original) {
   $picture = $img; 
   if($original != "") $real = $original;
   $mask = imagecreatefrompng( $pattern );
   $xSize = imagesx( $picture );
   $ySize = imagesy( $picture );
   $newPicture = imagecreatetruecolor( $xSize, $ySize );
   imagesavealpha( $newPicture, true );
   imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

   if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) {
      $tempPic = imagecreatetruecolor( $xSize, $ySize );
      imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
      imagedestroy( $mask );
      $mask = $tempPic;
   }
   
   for( $x = 0; $x < $xSize; $x++ ) {
      for( $y = 0; $y < $ySize; $y++ ) {
          $alpha = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
          if(($alpha['red'] == 0) && ($alpha['green'] == 0) && ($alpha['blue'] == 0) && ($alpha['alpha'] == 0)){
                $color = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
                imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], 0 ) );
                if($type =="1") imagesetpixel( $real, $x, $y, imagecolorallocatealpha( $real, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], 0 ) );
                
          }else{
                $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
                //$color2 = imagecolorsforindex( $picture, imagecolorat( $real, $x, $y ) );
                imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], 0 ) );
                //imagesetpixel( $real, $x, $y, imagecolorallocatealpha( $real, $color2[ 'red' ], $color2[ 'green' ], $color2[ 'blue' ], 0 ) );
          }
      }
   }
   if($type =="1") return( $real);
   return( $newPicture);
}

function drawPath($name,$room){
   global $dblink;
   
   if($name == "plantaEmptyFloor.jpg"){
	  $image = imagecreatefromjpeg("preview/plantaEmptyFloor.jpg"); 
   }else{
      $image = imagecreatefromjpeg('emptyPlant_'.$room.'.jpg');
   }
   $image2 = imagecreatefromjpeg('emptyFloorPlant_'.$room.'.jpg');
   list($width, $height, $type, $attr) = getimagesize('emptyPlant_'.$room.'.jpg');
   $seta = imagecreatefrompng('setaazul.png');
   list($width2, $height2, $type2, $attr2) = getimagesize('setaazul.png');
   imagealphablending($seta, false);
   imagesavealpha($seta, true);
   $setabi = imagecreatefrompng('setaazulbi.png');
   imagealphablending($setabi, false);
   imagesavealpha($setabi, true);
   $seta2 = imagecreatefrompng('setabranca.png');
   imagealphablending($seta2, false);
   imagesavealpha($seta2, true);
   $setabi2 = imagecreatefrompng('setabrancabi.png');
   imagealphablending($setabi2, false);
   imagesavealpha($setabi2, true);
   
   $result = mysqli_query($dblink,"select x1,y1,x2,y2,bidirectional,white from path where room='".$room."'");
   while($row = mysqli_fetch_row($result)){
      $x1 = $row[0];
      $y1 = $row[1];
      $x2 = $row[2];
      $y2 = $row[3];
      $bi = $row[4];
      $white = $row[5];
      
      $length = round(sqrt((($x2-$x1)*($x2-$x1)) + (($y2-$y1)*($y2-$y1))));
      
      $pi = pi();
      $rotacao = round(-atan2($y2 - $y1, $x2 - $x1) * 180 / $pi)-90;
      
      $deltax = 0;
      $deltay = 0;
      if(($x1 == $x2) & ($y1 < $y2)){
	      $rotacao = 180;
	      $deltax = -8;
	  }
      if(($x1 == $x2) & ($y1 > $y2)){
	      $rotacao = 0;
	      $deltax = -8;
	      $deltay = -$length;
	  }
      if(($y1 == $y2) & ($x1 < $x2)){
	      $rotacao = -90;
	      $deltay = -8;
	  }
      if(($y1 == $y2) & ($x1 > $x2)){
	      $rotacao = 90;
	      $deltay = -8;
	      $deltax = -$length;
      }
      
      //echo "comprimento: ".$length." rotacao: ".$rotacao."<br>";
      
      if($white == "1"){
         if($bi != "1"){
            $cropped = imagecrop($seta2, ['x' => 0, 'y' => 0, 'width' => $width2, 'height' => $length]);
            $rotate = imagerotate ($cropped,$rotacao ,imageColorAllocateAlpha($seta2, 0, 0, 0, 127));
         }else{
	        $cropped = imagecrop($setabi2, ['x' => 0, 'y' => 0, 'width' => $width2, 'height' => $length]);
            $rotate = imagerotate ($cropped,$rotacao ,imageColorAllocateAlpha($setabi2, 0, 0, 0, 127));
         }
      }else{
	     if($bi != "1"){
            $cropped = imagecrop($seta, ['x' => 0, 'y' => 0, 'width' => $width2, 'height' => $length]);
            $rotate = imagerotate ($cropped,$rotacao ,imageColorAllocateAlpha($seta, 0, 0, 0, 127));
         }else{
	        $cropped = imagecrop($setabi, ['x' => 0, 'y' => 0, 'width' => $width2, 'height' => $length]);
            $rotate = imagerotate ($cropped,$rotacao ,imageColorAllocateAlpha($setabi, 0, 0, 0, 127));
         } 
      }
      
      
      imagealphablending($rotate, false);
      imagesavealpha($rotate, true);
      $width3 = imagesx ($rotate);
      $height3 = imagesy ($rotate);
      
      if(($x1 < $x2) & ($y1 > $y2)){
	      $deltay = -$height3;
	  }
	  if(($x1 > $x2) & ($y1 > $y2)){
	      $deltay = -$height3;
	      $deltax = -$width3;
	  }
	  if(($x1 > $x2) & ($y1 < $y2)){
	      $deltax = -$width3;
	  }
      
      imagecopy($image, $rotate, $x1 + $deltax , $y1 + $deltay, 0, 0, $width3, $height3);
      imagecopy($image2, $rotate, $x1 + $deltax , $y1 + $deltay, 0, 0, $width3, $height3);
      imagedestroy($cropped);
   }
   
   
   //marks
   $result3 = mysqli_query($dblink,"select x,y,type from pathMarks where roomname='".$room."'");
      while($row3 = mysqli_fetch_row($result3)){
         $x_mark = $row3[0];
         $y_mark = $row3[1];
         $type_mark = $row3[2];
         if($type_mark == "3") $im_mark = "amb.png";
         if($type_mark == "4") $im_mark = "redin.png";
         if($type_mark == "5") $im_mark = "redout.png";
         if($type_mark == "6") $im_mark = "greenin.png";
         if($type_mark == "7") $im_mark = "greenout.png";
         if($type_mark == "8") $im_mark = "tria.png";
         
         $im_mark = imagecreatefrompng($im_mark);
         imagealphablending($im_mark, false);
         imagesavealpha($im_mark, true);
         
         imagecopy($image, $im_mark, $x_mark-20, $y_mark-20, 0, 0, 40, 40);
         imagecopy($image2, $im_mark, $x_mark-20, $y_mark-20, 0, 0, 40, 40);
         
         imagedestroy($im_mark);
      }   
   
	      
   imagepng($image, $name);
   imagejpeg($image2, "preview/EmptyFloorPlant_".$room.".jpg");
   imagedestroy($image);
   imagedestroy($image2);
   imagedestroy($seta);
   imagedestroy($setabi);
   imagedestroy($seta2);
   imagedestroy($setabi2);
   
}  

function getNearest($x1,$y1,$x2,$y2){
		global $dblink;
		$threeshold = 7;
		$minx = $x1 - $threeshold;
		$maxx = $x1 + $threeshold;
		$minx2 = $x2 - $threeshold;
		$maxx2 = $x2 + $threeshold;
		
		$miny = $y1 - $threeshold;
		$maxy = $y1 + $threeshold;
		$miny2 = $y2 - $threeshold;
		$maxy2 = $y2 + $threeshold;
		
		$resulta = mysqli_query($dblink,"select x1 from maps where (x1 > ".$minx." and x1 < ".$maxx.") "); 
        while($rowa = mysqli_fetch_row($resulta)){
           $xa = $rowa[0];
        }
        $resultb = mysqli_query($dblink,"select x2 from maps where (x2 > ".$minx." and x2 < ".$maxx.") "); 
        while($rowb = mysqli_fetch_row($resultb)){
           $xb = $rowb[0];
        }
        
        $resultc = mysqli_query($dblink,"select y1 from maps where (y1 > ".$miny." and y1 < ".$maxy.") "); 
        while($rowc = mysqli_fetch_row($resultc)){
           $yc = $rowc[0];
        }
        
        $resultd = mysqli_query($dblink,"select y2 from maps where (y2 > ".$miny." and y2 < ".$maxy.") "); 
        while($rowd = mysqli_fetch_row($resultd)){
           $yd = $rowd[0];
        }
        
        $resulte = mysqli_query($dblink,"select x1 from maps where (x1 > ".$minx2." and x1 < ".$maxx2.") "); 
        while($rowe = mysqli_fetch_row($resulte)){
           $xe = $rowe[0];
        }
        
        $resultf = mysqli_query($dblink,"select x2 from maps where (x2 > ".$minx2." and x2 < ".$maxx2.") "); 
        while($rowf = mysqli_fetch_row($resultf)){
           $xf = $rowf[0];
        }
        
        $resultg = mysqli_query($dblink,"select y1 from maps where (y1 > ".$miny2." and y1 < ".$maxy2.") "); 
        while($rowg = mysqli_fetch_row($resultg)){
           $yg = $rowg[0];
        }
        
        $resulth = mysqli_query($dblink,"select y2 from maps where (y2 > ".$miny2." and y2 < ".$maxy2.") "); 
        while($rowh = mysqli_fetch_row($resulth)){
           $yh = $rowh[0];
        }
		
		if($xa != "") $x1 = $xa;
        if($xb != "") $x1 = $xb;
        if($yc != "") $y1 = $yc;
        if($yd != "") $y1 = $yd;
        
        if($xe != "") $x2 = $xe;
        if($xf != "") $x2 = $xf;
        if($yg != "") $y2 = $yg;
        if($yh != "") $y2 = $yh;
        
        $out = [];
        $out[0] = $x1;
        $out[1] = $y1;
        $out[2] = $x2;
        $out[3] = $y2;
        
        return($out);
}

function menu($room,$val){ 
   $prefix = "";
   $prefix2 = "preview/";	
   if($val == "6") {
	   $prefix = "../";
	   $prefix2 = "";
   }	   
   $menu='
   <div style="position:fixed;top:0px;left:0px;background-color:#ffffff;;height:110px;width:100%;box-shadow: 0 4px 4px -2px gray;" valign="middle"><br>
      <table width="100%">
         <tr>
            <td class="prompt" width="200" height="100"><a href="';
            if($val == "6") $menu=$menu.'../';
            $menu=$menu.'../web/index.php"><img src="'.$prefix.'logobranco2.jpg" width="150" hspace="20" ></a>';
            $menu=$menu.'</td>
		    <td>&nbsp;';
		    if($val == "1")$menu=$menu.'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="coord" class="prompt"></span>&nbsp;&nbsp;&nbsp;<input id="seemap" type="checkbox" onclick="seeMap()"> <span class="prompt">See only map</span>';
		    if($val == "2")$menu=$menu.'
		    <table width="850">
				<tr>
					
					<td align="center" class="prompt"><a href="javascript:adProp(1)"><img hspace="10" style="border:0px solid #999999" src="enfermaria8.png" width="30"></a><br>Beds</td>
					<td align="center" class="prompt"><a href="javascript:adProp(2)"><img hspace="10" style="border:0px solid #999999" src="consultorio8.png" width="30"></a><br>Desk</td>
					<td align="center" class="prompt"><a href="javascript:adProp(3)"><img hspace="10" style="border:0px solid #999999" src="salaespera8.png" width="30"></a><br>Chairs</td>
					<td align="center" class="prompt"><a href="javascript:adProp(4)"><img hspace="10" style="border:0px solid #999999" src="mri8.png" width="30"></a><br>X-ray</td>
					<td align="center" class="prompt"><a href="javascript:adProp(5)"><img hspace="10" style="border:0px solid #999999" src="lab8.png" width="30"></a><br>Lab</td>
					<td align="center" class="prompt"><a href="javascript:adProp(6)"><img hspace="10" style="border:0px solid #999999" src="armazem8.png" width="30"></a><br>Storage</td>
					<td align="center" class="prompt"><a href="javascript:adProp(17)"><img hspace="10" style="border:0px solid #999999" src="operation.png" width="30"></a><br>Procedure</td>
					<!--<td align="center" class="prompt"><a href="javascript:adProp(7)"><img hspace="10" style="border:0px solid #999999" src="nurse8.png" width="30"></a><br>Nurse</td>
					<td align="center" class="prompt"><a href="javascript:adProp(8)"><img hspace="10" style="border:0px solid #999999" src="tree8.png" width="30"></a><br>Tree</td>
					<td align="center" class="prompt"><a href="javascript:adProp(9)"><img hspace="10" style="border:0px solid #999999" src="cylinder8.png" width="30"></a><br>Red t.</td>
					<td align="center" class="prompt"><a href="javascript:adProp(10)"><img hspace="10" style="border:0px solid #999999" src="cylinder8.png" width="30"></a><br>Green t.</td>
					<td align="center" class="prompt"><a href="javascript:adProp(11)"><img hspace="10" style="border:0px solid #999999" src="light8.png" width="30"></a><br>T. light</td>-->
					<td style="width:50px">&nbsp;</td>
					<td align="center" class="prompt"><a href=""><img hspace="10" id="trashcan" style="border:0px solid #999999" src="trashcan8.png" width="30"></a><br>Trash</td>
					<td align="center" class="prompt"><br>Zoom level<br><input type="range" min="5" max="16" value="10"  id="magnify" oninput="magnify()"><span id="mag">10</span></td>
					<!--<td align="center" class="prompt"><img src="legenda3.jpg" width="230" id="legenda"><br>Zoom preview</td>-->
					<td style="width:40px">&nbsp;</td>
					<td align="center" class="prompt"><br><a style="padding:10px;color:white;background-color:#939393;text-decoration: none" href="javascript:saveProp()">SAVE </a></td>
					<td style="width:40px">&nbsp;</td>
					<td class="prompt"></td>
				</tr>
				
			</table>';
			if($val == "3")$menu=$menu.'
			<table width="950">
			   <tr>
			      <td align="right" class="prompt">Close polygon</td> 
			      <td align="center" class="prompt" width="60"><a style="padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;background-color:red;color:black;text-decoration:none;font-family:Arial;font-size:12px" href="closePolygon.php?color=1&room='.$room.'"> </span></a><br><br>Red zone</td>
			      <td align="center" class="prompt" width="70"><a style="padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;background-color:green;color:black;text-decoration:none;font-family:Arial;font-size:12px" href="closePolygon.php?color=2&room='.$room.'"> </span></a><br><br>Green zone</td>
			      <td align="center" class="prompt" width="60"><a style="padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;background-color:blue;color:black;text-decoration:none;font-family:Arial;font-size:12px" href="closePolygon.php?color=3&room='.$room.'"> </span></a><br><br>Blue zone</td>
			      <td align="center" class="prompt" width="70"><a style="padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;background-color:yellow;color:black;text-decoration:none;font-family:Arial;font-size:12px" href="closePolygon.php?color=4&room='.$room.'"> </span></a><br><br>Yellow zone</td>
			      <td align="center" class="prompt" width="50"><a style="padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;background-color:black;color:black;text-decoration:none;font-family:Arial;font-size:12px" href="closePolygon.php?color=5&room='.$room.'"> </span></a><br><br>Morgue</td>
			      <td align="center" class="prompt" width="50" id="pt1"><a style="background-image:url('."'".'pt1.jpg'."'".');text-decoration:none;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;" href="closePolygon.php?color=6&room='.$room.'"> </a><br><br>texture 1</td>
			      <td align="center" class="prompt" width="50" id="pt2"><a style="background-image:url('."'".'pt2.jpg'."'".');text-decoration:none;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;" href="closePolygon.php?color=7&room='.$room.'"> </a><br><br>texture 2</td>
			      <td align="center" class="prompt" width="50" id="pt3"><a style="background-image:url('."'".'pattern3.png'."'".');text-decoration:none;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;" href="closePolygon.php?color=8&room='.$room.'"> </a><br><br>texture 3</td>
			      <td align="center" class="prompt" width="50" id="pt4"><a style="background-image:url('."'".'pattern4.jpg'."'".');text-decoration:none;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;" href="closePolygon.php?color=9&room='.$room.'"> </a><br><br>texture 4</td>
			      <td align="right"><span style="font-size:22px;font-weight:bold;font-family:Arial"> Manual Mode</span> &nbsp;&nbsp;&nbsp;&nbsp;<a href="autoFloor.php?room='.$room.'" class="prompt" style="padding:10px;color:white;background-color:#939393;text-decoration: none">Use auto mode</a></td>
			  </tr>
		    </table>
			';
			if($val =="4")$menu=$menu.'
			<table width="750">
			   <tr>
			      <td align="center" class="prompt" width="70"><a id="vm" href="javascript:changeColor(1)" style="border:3px solid black;background-color:red;text-decoration:none;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:5px;">&nbsp;&nbsp;&nbsp;</a><br><br>Red zone</td> 
			      <td align="center" class="prompt" width="70"><a id="vd" style="background-color:green;text-decoration:none;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:5px;" href="javascript:changeColor(2)">&nbsp;&nbsp;&nbsp;</a><br><br>Green zone</td> 
			      <td align="center" class="prompt" width="70"><a id="az" style="background-color:blue;text-decoration:none;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:5px;" href="javascript:changeColor(3)">&nbsp;&nbsp;&nbsp;</a><br><br>Blue zone</td> 
			      <td align="center" class="prompt" width="70"><a id="am" href="javascript:changeColor(4)" style="background-color:yellow;text-decoration:none;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:5px;">&nbsp;&nbsp;&nbsp;</a><br><br>Yellow zone</td> 
			      <td align="center" class="prompt" width="70"><a id="pr" href="javascript:changeColor(5)" style="background-color:black;text-decoration:none;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:5px;">&nbsp;&nbsp;&nbsp;</a><br><br>Morgue</td>
			      <td align="right"><span style="font-size:22px;font-weight:bold;font-family:Arial">Auto Mode</span> &nbsp;&nbsp;&nbsp;&nbsp;<a class="prompt" href="addFloor.php?room='.$room.'" style="padding:10px;color:white;background-color:#939393;text-decoration: none">Use manual mode</a></td>
			   </tr>
			</table>
			';
			if($val == "5")$menu=$menu.'
		    <table width="550">
			   <tr>
			      <td align="center" class="prompt" id="icn1" style="border:3px solid #999999"><a href="javascript:selectIcon(1)"><img hspace="10"  style="border:0px solid #999999" src="corridor.png" width="30"></a><br>Corridor</td>
			      <td align="center" class="prompt" id="icn2"><a href="javascript:selectIcon(2)"><img hspace="10"  style="border:0px solid #999999" src="corridorbi.png" width="30"></a><br>Bi directional</td>
			      <td align="center" class="prompt" id="icn3"><a href="javascript:selectIcon(3)"><img hspace="10"  style="border:0px solid #999999" src="ambulance.png" width="30"></a><br>Drop-off</td>
			      <td align="center" class="prompt" id="icn4"><a href="javascript:selectIcon(4)"><img hspace="10"  style="border:0px solid #999999" src="inred.png" width="30"></a><br>Red in</td>
			      
			      <td align="center" class="prompt" id="icn5"><a href="javascript:selectIcon(5)"><img hspace="10"  style="border:0px solid #999999" src="outred.png" width="30"></a><br>Red out</td>
			      <td align="center" class="prompt" id="icn6"><a href="javascript:selectIcon(6)"><img hspace="10"  style="border:0px solid #999999" src="ingreen.png" width="30"></a><br>Green in</td>
			      <td align="center" class="prompt" id="icn7"><a href="javascript:selectIcon(7)"><img hspace="10"  style="border:0px solid #999999" src="outgreen.png" width="30"></a><br>Green out</td>
			      <td align="center" class="prompt" id="icn8"><a href="javascript:selectIcon(8)"><img hspace="10"  style="border:0px solid #999999" src="triage.png" width="30"></a><br>Triage point</td>

			   </tr>
			</table>';
					
		    $menu = $menu.'</td>
		    <td class="prompt" align="right">
		       <table width="350">
                  <tr>
                     <td align="center" ';if($val == "1")$menu = $menu.'style="border-bottom:5px solid grey"';$menu = $menu.'><span class="promptsmall"><a href="'.$prefix.'start.php?room='.$room.'"><img src="'.$prefix.'geometry.jpg" width="30" ></a><br>GEOMETRY</span></td>
                     <td align="center" ';if($val == "2")$menu = $menu.'style="border-bottom:5px solid grey"';$menu = $menu.'><span class="promptsmall"><a href="'.$prefix.'addProp.php?room='.$room.'"><img src="'.$prefix.'props.jpg" width="30"></a><br>PROPS<br></td>
                     <td align="center" ';if($val == "3" || $val == "4")$menu = $menu.'style="border-bottom:5px solid grey"';$menu = $menu.'><span class="promptsmall"><a href="'.$prefix.'addFloor.php?room='.$room.'"><img src="'.$prefix.'floor.jpg" width="30"></a><br>FLOOR</span></td>
                     <td align="center" ';if($val == "5")$menu = $menu.'style="border-bottom:5px solid grey"';$menu = $menu.'><span class="promptsmall"><a href="'.$prefix.'path.php?room='.$room.'"><img src="'.$prefix.'path.jpg" width="30" hspace="1"></a><br>PATHS</span></td>
                     <td align="center" ';if($val == "6")$menu = $menu.'style="border-bottom:5px solid grey"';$menu = $menu.'><span class="promptsmall"><a href="'.$prefix2.'preview.php?room='.$room.'"><img src="'.$prefix.'3d2.jpg" width="30" hspace="10"></a><br>3D</span></td>
                     
                     <!--<td align="center" ';if($val == "6")$menu = $menu.'style="border-bottom:5px solid grey"';$menu = $menu.'><span class="promptsmall"><a href="'.$prefix.'path.php?room='.$room.'"><img src="'.$prefix.'exit.jpg" width="35" hspace="1"></a><br>EXIT</span></td>-->
                     <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  </tr>
               </table>
		    </td>
	     </tr>
      </table>
   </div>';
   
   return($menu);
}


?>