<?php
	
// preview.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("../db.php");

$mobile = "0";
if(isset($_GET['mobile'])) $mobile = "1";
	
if(!isset($_GET['room'])){
   echo "invalid id";
   exit();
}else{
   $room = clean($_GET['room']);
}
	
	



$amp = 1;
if(isset($_GET['amp'])) $amp = clean($_GET['amp']);


list($width, $height) = getimagesize('EmptyFloorPlant_'.$room.'.jpg');
$width = round($width/100)-0.4;
$height = round($height/100)+0.4;

$width = $width*$amp;
$height = $height*$amp;


$semiwidth = round($width/2);
$semiheight = round($height/2)+1;
	
?><html>
  <head>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
     <script src="https://unpkg.com/aframe-orbit-controls@1.2.0/dist/aframe-orbit-controls.min.js"></script> 
     <script src="https://unpkg.com/aframe-supercraft-loader@1.1.3/dist/aframe-supercraft-loader.js"></script> 
     <style>
	      .prompt{
	         font-size:12px;
	         font-family: Arial;   
          }
          .promptsmall{
	         font-size:10px;
	         font-family: Arial;   
          }
     </style>
     <script>
	   function createProp(type,posx,posz,rotacao){
		   
		   var posx = ((posx + 20)/100)-<?php echo $semiwidth;?>;
           var posz = ((posz + 40)/100)-<?php echo $semiheight;?>;
            var sc = document.querySelector('a-scene');
		    var model = document.createElement('a-entity');
		    //cama
		    if(type == 1){
			   model.setAttribute('gltf-model', 'cama.gltf'); model.setAttribute('scale', {x: 0.2, y: 0.2, z: 0.2});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0.15;   
		    }
		    //cadeira
		    if(type == 2){
			    model.setAttribute('gltf-model', 'chair1.gltf'); model.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 });
			    var posy = 0;
			}
			//secretario
		    if(type == 3){
			   model.setAttribute('gltf-model', 'consultorio.gltf'); model.setAttribute('scale', {x: 0.001, y: 0.001, z: 0.001});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
			//mri
		    if(type == 4){
			    rotacao = rotacao + 30;
			   model.setAttribute('gltf-model', 'mri1.gltf'); model.setAttribute('scale', {x: 0.4, y: 0.4, z: 0.4});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0.35;
			}
			if(type == 5){
			   model.setAttribute('gltf-model', 'shelf.gltf'); model.setAttribute('scale', {x: 4, y: 4, z: 4});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0.35;
			}
			if(type == 6){
			   model.setAttribute('gltf-model', 'semaforo.gltf'); model.setAttribute('scale', {x: 0.01, y: 0.01, z: 0.01});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 1;
			}
			if(type == 7){
			   model.setAttribute('gltf-model', 'lab.gltf'); model.setAttribute('scale', {x: 0.5, y: 0.5, z: 0.5});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
			if(type == 8){
			   model.setAttribute('gltf-model', 'womandoctor.gltf'); model.setAttribute('scale', {x: 0.3, y: 0.3, z: 0.3});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
			if(type == 9){
			   model.setAttribute('gltf-model', 'pool.gltf'); model.setAttribute('scale', {x: 0.3, y: 0.3, z: 0.3});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
			if(type == 10){
			   model.setAttribute('gltf-model', 'kitchen.gltf'); model.setAttribute('scale', {x: 3, y: 3, z: 3});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
			if(type == 11){
			   model.setAttribute('gltf-model', 'toilet.gltf'); model.setAttribute('scale', {x: 0.006, y: 0.006, z: 0.006});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
			if(type == 12){
			   model.setAttribute('gltf-model', 'sofa.gltf'); model.setAttribute('scale', {x: 0.5, y: 0.5, z: 0.5});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0.25;
			}
			if(type == 13){
			   model.setAttribute('gltf-model', 'dining.gltf'); model.setAttribute('scale', {x: 0.0003, y: 0.0003, z: 0.0003});  model.setAttribute('rotation', { x:0,y:rotacao,z: 0 }); 
			   var posy = 0;
			}
            model.setAttribute('position', { x: posx, y:  posy, z: posz});
            
            sc.appendChild(model);
       } 
       
       function cylinder(type,posx,posz){
	       var posx = ((posx + 20)/100)-<?php echo $semiwidth;?>;
           var posz = ((posz + 40)/100)-<?php echo $semiheight;?>;
	       var sc = document.querySelector('a-scene');
	       var myBox = document.createElement('a-cylinder');
           myBox.setAttribute('position', {x: posx, y:  1, z: posz})
           if(type==1) myBox.setAttribute('color', "red");
           if(type==2) myBox.setAttribute('color', "green");
           myBox.setAttribute('scale', {x: 0.2, y: 2, z: 0.2});
           sc.appendChild(myBox);
       }
       
       function cadeira(posx,posy,rotacao){
	       var posx = ((posx + 20)/100)-<?php echo $semiwidth;?>;
           var posz = ((posy + 40)/100)-<?php echo $semiheight;?>;
           var sc = document.querySelector('a-scene');
		   var model1 = document.createElement('a-entity');model1.setAttribute('gltf-model', 'chair1.gltf'); model1.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model1.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model1.setAttribute('position', { x: posx, y:  0, z: posz});sc.appendChild(model1);
		   var model2 = document.createElement('a-entity');model2.setAttribute('gltf-model', 'chair2.gltf'); model2.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model2.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model2.setAttribute('position', { x: posx, y:  0, z: posz  + 0.2});sc.appendChild(model2);
		   var model3 = document.createElement('a-entity');model3.setAttribute('gltf-model', 'chair3.gltf'); model3.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model3.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model3.setAttribute('position', { x: posx, y:  0, z: posz  + 0.4});sc.appendChild(model3);
		   var model4 = document.createElement('a-entity');model4.setAttribute('gltf-model', 'chair4.gltf'); model4.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model4.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model4.setAttribute('position', { x: posx + 0.2, y:  0, z: posz});sc.appendChild(model4);
		   var model5 = document.createElement('a-entity');model5.setAttribute('gltf-model', 'chair4.gltf'); model5.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model5.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model5.setAttribute('position', { x: posx + 0.2, y:  0, z: posz  + 0.2});sc.appendChild(model5);
		   var model6 = document.createElement('a-entity');model6.setAttribute('gltf-model', 'chair4.gltf'); model6.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model6.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model6.setAttribute('position', { x: posx + 0.2, y:  0, z: posz  + 0.4});sc.appendChild(model6);
		   var model7 = document.createElement('a-entity');model7.setAttribute('gltf-model', 'chair4.gltf'); model7.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model7.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model7.setAttribute('position', { x: posx + 0.4, y:  0, z: posz});sc.appendChild(model7);
		   var model8 = document.createElement('a-entity');model8.setAttribute('gltf-model', 'chair4.gltf'); model8.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model8.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model8.setAttribute('position', { x: posx + 0.4, y:  0, z: posz  + 0.2});sc.appendChild(model8);
		   var model9 = document.createElement('a-entity');model9.setAttribute('gltf-model', 'chair4.gltf'); model9.setAttribute('scale', {x: 0.005, y: 0.005, z: 0.005});  model9.setAttribute('rotation', { x:0,y:rotacao,z: 0 });model9.setAttribute('position', { x: posx + 0.4, y:  0, z: posz  + 0.4});sc.appendChild(model9);
       } 
       
       function ambulancia(posx,posy,rotacao){
	       var posx = ((posx + 20)/100)-<?php echo $semiwidth;?>;
           var posz = ((posy + 40)/100)-<?php echo $semiheight;?>;
           var sc = document.querySelector('a-scene');
		   var modela = document.createElement('a-entity');modela.setAttribute('gltf-model', 'amb.gltf'); modela.setAttribute('scale', {x: 0.004, y: 0.004, z: 0.004});  modela.setAttribute('rotation', { x:0,y:rotacao,z: 0 });modela.setAttribute('position', { x: posx, y:  0, z: posz});sc.appendChild(modela);
		   
		}
		
		function ambulanciaanimada(posx,posy,rotacao){
	       var posx = ((posx + 20)/100)-<?php echo $semiwidth;?>;
           var posz = ((posy + 40)/100)-<?php echo $semiheight;?>;
           var sc = document.querySelector('a-scene');
		   var modelaa = document.createElement('a-entity');modelaa.setAttribute('id', 'modelaa');modelaa.setAttribute('gltf-model', 'amb.gltf'); modelaa.setAttribute('scale', {x: 0.004, y: 0.004, z: 0.004});  modelaa.setAttribute('rotation', { x:0,y:rotacao,z: 0 });modelaa.setAttribute('position', { x: posx, y:  0, z: posz});sc.appendChild(modelaa);
		   //alert(posx + " " + posz);
		}
		
		function tree(posx,posy,rotacao){
	       var posx = ((posx + 20)/100)-<?php echo $semiwidth;?>;
           var posz = ((posy + 40)/100)-<?php echo $semiheight;?>;
           var sc = document.querySelector('a-scene');
		   var modelt = document.createElement('a-entity');modelt.setAttribute('gltf-model', 'tree.gltf'); 
		   modelt.setAttribute('scale', {x: 0.003, y: 0.003, z: 0.003});  modelt.setAttribute('rotation', { x:0,y:rotacao,z: 0 });modelt.setAttribute('position', { x: posx, y:  0, z: posz});sc.appendChild(modelt);
		} 
		
		var direcao = "l";
		function move(){
			
			
			var xx = document.getElementById('modelaa');;
			let position = xx.getAttribute("position");
			if(position.x < -8) direcao= "r";
			if(position.x > 8) direcao= "l";
			if(direcao == "l") xx.setAttribute('rotation', { x:0,y:0,z: 0 });
			if(direcao == "r") xx.setAttribute('rotation', { x:0,y:180,z: 0 });
			if(direcao == "l")var newx = position.x - 0.05;
			if(direcao == "r")var newx = position.x + 0.05;
			xx.setAttribute("position", { x: newx, y:  0, z: 10.899});
			console.log(newx);
			setTimeout(function(){ move(); }, 100);			
		}
		
	 </script>
  </head>
  <body style="background-color: #DDDDDD">
	  
	 <?php echo menu($room,6);?>
     <br><br><br><br><br><br><br><br>
	 <a-scene embedded style="width:100%;height:700px">
     <?php if($mobile !="1") echo'<a-assets><img id="sky" src="sky2.jpg"></a-assets><a-sky src="#sky"></a-sky>'; ?>
				          
	 <a-entity light="type: ambient; intensity: 0.8;"></a-entity>
     <a-entity light="type: directional;castShadow: true;intensity: 0.4;shadowCameraVisible: false;"position="-5 3 1.5"></a-entity>
	 <a-entity camera look-controls orbit-controls="target: 0 1.6 -0.5;minDistance:0.5;maxDistance:18;initialPosition:0 9 1"></a-entity>
	 <a-plane shadow="receive: true;cast:true" position="0 0.01 0" material="src:EmptyFloorPlant_<?php echo $room;?>.jpg?<?php echo rand();?>"  rotation="-90 0 0" width="<?php echo $width;?>" height="<?php echo $height;?>" color="#AAAAAA"></a-plane>
	    <a-plane position="0 0 0" rotation="-90 0 0" width="<?php echo $width;?>" height="<?php echo $height;?>" color="#999999">
	 <?php
		                 
     $result = mysqli_query($dblink,"select x1,y1,x2,y2,roomname,id from maps where roomname='".$room."' order by id ");
     while($row = mysqli_fetch_row($result)){
        $x1 = $row[0]/100;
        $y1 = $row[1]/100;
        $x2 = $row[2]/100;
        $y2 = $row[3]/100;
        $x1 = $x1*$amp;
        $x2 = $x2*$amp;
        $y1 = $y1*$amp;
        $y2 = $y2*$amp;
        $pox = (($x1 + $x2)/2) - ($width/2);
        $poy = (($y1 + $y2)/2) - ($height/2);
        $poy = -$poy;
        $comprimento = (($x2-$x1)*($x2-$x1)) + (($y2-$y1)*($y2-$y1));
        $comprimento = sqrt($comprimento)+"0.03";
        $lado1 = $x2-$x1;
                         
        if($x1 == $x2){
           $rotacao = 90;
        }else if($y1 == $y2){
           $rotacao = 0;
        }else{
           $rotacao = atan2($x2-$x1,$y1-$y2);
           $pi = pi();
           $rotacao = -atan2($y2 - $y1, $x2 - $x1) * 180 / $pi;
        }
                         
        if($row[5] == "68") $rotacao = "50";
        if($row[5] == "123") $rotacao = "75";
        if($row[5] == "112" || $row[5] == "113"  || $row[5] == "114") $rotacao = "75";
        if($row[5] == "115" || $row[5] == "116"  || $row[5] == "117"  || $row[5] == "118"  || $row[5] == "119"  || $row[5] == "120") $rotacao = "-30";
        echo'<a-box position="'.$pox.' '.$poy.' 0.15" width="'.$comprimento.'" height="0.05" depth="0.3" rotation="0 0 '.$rotacao.'" color="#EEEEEE" shadow="receive: true;cast:true"></a-box>';
     }
                      
	 ?></a-plane>
   </a-scene>  
   <br><br>  
		            
   <script>
      <?php
	  $result = mysqli_query($dblink,"select x,y,type,angle from props where room='".$room."'");
      while($row = mysqli_fetch_row($result)){
         $x = $row[0];
         $y = $row[1];
         $type = $row[2];
         $angle = $row[3];
            if($type == "nurse") echo "createProp(8,".$x.",".$y.",".$angle.");";
            if($type == "chairs") echo "cadeira(".$x.",".$y.",".$angle.");";
            if($type == "tree") echo "tree(".$x.",".$y.",".$angle.");";
            if($type == "warehouse") echo "createProp(5,".$x.",".$y.",".$angle.");";
            if($type == "lab") echo "createProp(7,".$x.",".$y.",".$angle.");";
            if($type == "desks") echo "createProp(3,".$x.",".$y.",".$angle.");";
            if($type == "bed") echo "createProp(1,".$x.",".$y.",".$angle.");";
            if($type == "mri") echo "createProp(4,".$x.",".$y.",".$angle.");";
            if($type == "pool") echo "createProp(9,".$x.",".$y.",".$angle.");";
            if($type == "kitchen") echo "createProp(10,".$x.",".$y.",".$angle.");";
            if($type == "toilet") echo "createProp(11,".$x.",".$y.",".$angle.");";
            if($type == "sofa") echo "createProp(12,".$x.",".$y.",".$angle.");";
            if($type == "dining") echo "createProp(13,".$x.",".$y.",".$angle.");";
            if($type == "cylinderGreen") echo "cylinder(1,".$x.",".$y.");";
		    if($type == "cylinderRed") echo "cylinder(2,".$x.",".$y.");";
		    if($type == "light") echo "createProp(6,".$x.",".$y.",".$angle.");";
         }
      ?>
   </script> 
                  
</body>
</html>
<?php
	
function lengthSquare($x,$y){ 
   $xDiff = $x[0] - $y[0]; 
   $yDiff = $x[1] - $y[1]; 
   return ($xDiff * $xDiff) + ($yDiff * $yDiff);
}
      	
?>