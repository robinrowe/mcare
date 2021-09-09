<?php
	
// addProp.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
	
if(!isset($_GET['room'])){
   echo "invalid id";
   exit();
}else{
   $room = clean($_GET['room']);
}
	
include("db.php");
	
$result4 = mysqli_query($dblink,"select x,y,size,type,angle from props where room='".$room."'");
while($row4 = mysqli_fetch_row($result4)){
   $x_prop[] = $row4[0];
   $y_prop[] = $row4[1];
   $size_prop[] = $row4[2];
   $type_prop[] = $row4[3];
   $angle_prop[] = $row4[4];
}
	
?>

<html>
	<head>
       <link rel='stylesheet prefetch' href='https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'>
       <link rel='stylesheet prefetch' href='http://cdn.jsdelivr.net/jquery.ui.rotatable/1.0.1/jquery.ui.rotatable.css'>

	   <style>
	      .promptsmall{
	         font-size:10px;
	         font-family: Arial;   
          }
          .prompt{
	         font-size:12px;
	         font-family: Arial;   
          }
          .blinking{
             animation:blinkingText 0.5s infinite;
          }
          @keyframes blinkingText{
             0%{     opacity: 1;    }
             100%{   opacity: 0;    }
          }	 
       </style>	 
	   <script>
		   contador = 0;
		   var x1 = 0;
		   var x2 = 0;
		   var y1 = 0;
		   var y2 = 0;
		   
		   function hide(){
			   document.getElementById('crosshair-h').style.display = "none";
			   document.getElementById('crosshair-v').style.display = "none";
		   }
		   
		   function show(){
			   document.getElementById('crosshair-h').style.display = "block";
			   document.getElementById('crosshair-v').style.display = "block";
		   }
		   
           
           function ajaxSend(query){
	           var xhttp;
               xhttp = new XMLHttpRequest();
               xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                     document.getElementById('mapa').src = "emptyPlant_<?php echo $room;?>.jpg?" + Math.random();
                     //limpa todas as divs
                     cleandivs();
                     
                  }
               };
               xhttp.open("GET",query, true);
               xhttp.send();  
           }
           
           
           
           function adcElemento(x,y) {
              var divNova = document.createElement("div");
              document.body.appendChild(divNova);
              divNova.innerHTML = "<img src='bola.png' width='3'>";
              divNova.style.position = "absolute";
              divNova.style.top = y + "px";
              divNova.style.left = x + "px";
              divNova.style.zIndex = 9999999999999;
              divNova.classList.add("marker");
           }
           function cleandivs(){
	           var divsToRemove = document.getElementsByClassName("marker");
               for (var i = divsToRemove.length-1; i >= 0; i--) {
                   divsToRemove[i].remove();
               }
           }
           function revert(){
	           document.getElementById('preview1').style.display = "none";
	           document.getElementById('preview2').style.display = "none";
           }
           function preview(x1,y1,x2,y2){ 
	           var mapa = document.getElementById('mapa');
			   var elDistanceToTop = window.pageYOffset + mapa.getBoundingClientRect().top;
			   var elDistanceToLeft = window.pageXOffset + mapa.getBoundingClientRect().left;
	           document.getElementById('preview1').style.left = (x1 + elDistanceToLeft - 3) + "px"; 
	           document.getElementById('preview1').style.top = (y1 + elDistanceToTop - 3) + "px";
	           document.getElementById('preview2').style.left = (x2 + elDistanceToLeft - 3) + "px"; 
	           document.getElementById('preview2').style.top = (y2 + elDistanceToTop - 3) + "px";
	           document.getElementById('preview1').style.display = "block";
	           document.getElementById('preview2').style.display = "block";
           }
           
           
           var multiplier = 10;
           
           function adProp(prop) {
	          if(prop == 1) {
		          var im = "enfermaria.png";
		          var size = multiplier*6;
		      }
	          if(prop == 2) {
		          var im = "consultorio2.png";
		          var size = multiplier*4;
		      }
	          if(prop == 3) {
		          var im = "salaespera.png";
		          var size = multiplier*4;
		      }
	          if(prop == 4) {
		          var im = "mri.png"; 
		          var size = multiplier*8;
		      }
	          if(prop == 5) {
		          var im = "lab.png";
		          var size = multiplier*8;
		      }
	          if(prop == 6) {
		          var im = "armazem2.png";
		          var size = multiplier*8;
		      }
	          if(prop == 7) {
		          var im = "nurse3.png";
		          var size = multiplier*2;
		      }
		      if(prop == 8) {
		          var im = "tree2.png";
		          var size = multiplier*4;
		      }
		      if(prop == 9) {
		          var im = "cylinderRed.png";
		          var size = multiplier*2;
		      }
		      if(prop == 10) {
		          var im = "cylinderGreen.png";
		          var size = multiplier*2;
		      }
		      if(prop == 11) {
		          var im = "light.png";
		          var size = multiplier*4;
		      }
		      
		      if(prop == 12) {
		          var im = "kitchen.png";
		          var size = multiplier*18;
		      }
		      
		      if(prop == 13) {
		          var im = "sofa.png";
		          var size = multiplier*10;
		      }
		      
		      if(prop == 14) {
		          var im = "dining.png";
		          var size = multiplier*10;
		      }
		      
		      if(prop == 15) {
		          var im = "pool.png";
		          var size = multiplier*22;
		      }
		      
		      if(prop == 16) {
		          var im = "toilet.png";
		          var size = multiplier*4;
		      }
		      if(prop == 17) {
		          var im = "procedure.png";
		          var size = multiplier*6;
		      }
		      
		      var trashposition = document.getElementById('trashcan');
	          var rect = trashposition.getBoundingClientRect();
              var trashleft = rect.left;
              var imageHeight = document.getElementById('mapa').height;
		       
              var newProp = document.createElement("div");
              newProp.classList.add("prop");
              newProp.style.width = size + "px";
              document.body.appendChild(newProp);
              newProp.innerHTML = '<img src="' + im + '" width="100%">';
              $('.prop').rotatable().draggable();
              newProp.style.left = trashleft + "px";
              newProp.style.top = "-" + imageHeight + "px";
              $(".prop" ).mouseup(function() {
                 checkTrash();
              });
           }
           function checkTrash(){
	           var trashposition = document.getElementById('trashcan');
	           var rect = trashposition.getBoundingClientRect();
               var trashleft = rect.left;
	           var divsToSave = document.getElementsByClassName("prop");
               for (var i = divsToSave.length-1; i >= 0; i--) {
                   var thisdiv = divsToSave[i];
                   var elDistanceToTop = window.pageYOffset + thisdiv.firstElementChild.getBoundingClientRect().top;
			       var elDistanceToLeft = window.pageXOffset + thisdiv.firstElementChild.getBoundingClientRect().left;
			       console.log(elDistanceToLeft,trashleft-50,trashleft + 50,elDistanceToTop,elDistanceToTop);
			       if(elDistanceToLeft > (trashleft-50) && elDistanceToLeft < (trashleft + 50) && elDistanceToTop > 1 && elDistanceToTop < 350){
                      thisdiv.parentNode.removeChild(thisdiv);
                   }
               }

           }
           
           function magnify(){
	           multiplier = document.getElementById('magnify').value;
	           document.getElementById('mag').innerHTML = document.getElementById('magnify').value;
	       }
	       
	       function saveProp(){
		       var angulo = [];
		       var x = [];
		       var y = [];
		       var tipo = [];
		       var tamanho = [];
	           var divsToSave = document.getElementsByClassName("prop");
               for (var i = divsToSave.length-1; i >= 0; i--) {
                   //console.log("x:" + divsToSave[i].style.left + ",y:" + divsToSave.style.top);
                   var thisdiv = divsToSave[i];
                   var rect = thisdiv.getBoundingClientRect();
                   //console.log(rect.top, rect.right, rect.bottom, rect.left);
                   var elDistanceToTop = window.pageYOffset + thisdiv.firstElementChild.getBoundingClientRect().top;
			       var elDistanceToLeft = window.pageXOffset + thisdiv.firstElementChild.getBoundingClientRect().left;
                   var resto = thisdiv.innerHTML.substring(10);
                   var fim = resto.indexOf('"');
                   var imgdesc = resto.substring(0,fim);
                   var thisChild = thisdiv.firstElementChild;
                   var ang = getRotationAngle(thisdiv);
                   
                   angulo.push(ang);
                   x.push(elDistanceToLeft);
                   y.push(elDistanceToTop);
                   tipo.push(imgdesc);
                   tamanho.push(thisdiv.firstElementChild.width);
               }
               
               var dst = "saveProp.php?x=" + x + "&y=" + y + "&size=" + tamanho + "&type=" + tipo + "&angle=" + angulo + "&room=<?php echo $room;?>";
               window.location = dst;
           }
           
           function getRotationAngle(target){
              const obj = window.getComputedStyle(target, null);
              const matrix = obj.getPropertyValue('-webkit-transform') || 
              obj.getPropertyValue('-moz-transform') ||
              obj.getPropertyValue('-ms-transform') ||
              obj.getPropertyValue('-o-transform') ||
              obj.getPropertyValue('transform');

              let angle = 0; 

              if (matrix !== 'none') {
                 const values = matrix.split('(')[1].split(')')[0].split(',');
                 const a = values[0];
                 const b = values[1];
                 angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
              } 
              return (angle < 0) ? angle +=360 : angle;
           }
	    </script>  
	</head>
	<body style="background-color: #DDDDDD">
		
		<?php
		for($n=0;$n<count($x_prop);$n=$n+1){
		   $type = $type_prop[$n];
		   $im = "";
		   if($type == "tree") $im = "tree2.png";
		   if($type == "nurse") $im = "nurse3.png";
		   if($type == "warehouse") $im = "armazem2.png";
		   if($type == "lab") $im = "lab.png";
		   if($type == "mri") $im = "mri.png";
		   if($type == "chairs") $im = "salaespera.png";
		   if($type == "desks") $im = "consultorio2.png";
		   if($type == "bed") $im = "enfermaria.png";
		   if($type == "sofa") $im = "sofa.png";
		   if($type == "toilet") $im = "toilet.png";
		   if($type == "dining") $im = "dining.png";
		   if($type == "pool") $im = "pool.png";
		   if($type == "kitchen") $im = "kitchen.png";
		   if($type == "cylinderGreen") $im = "cylinderGreen.png";
		   if($type == "cylinderRed") $im = "cylinderRed.png";
		   if($type == "light") $im = "light.png";
		   if($type == "procedure") $im = "procedure.png";
	       echo '<div id="div_'.$n.'" class="prop" style="z-index:9999999999;position:absolute;top:'.$y_prop[$n].'px;left:'.$x_prop[$n].'px;width:'.$size_prop[$n].'px"><img src="'.$im.'" width="100%"></div>';
	       $rot = $angle_prop[$n];
	       echo "<script>var div = document.getElementById('div_".$n."');div.style.webkitTransform = 'rotate(".$rot."deg)';"."div.style.mozTransform    = 'rotate(".$rot."deg)';"."div.style.msTransform     = 'rotate(".$rot."deg)';"."div.style.oTransform  = 'rotate(".$rot."deg)';"."div.style.transform = 'rotate(".$rot."deg)';</script>"; 
        }
	    echo "<script>$('.prop').rotatable().draggable();</script>";	
		?>	
		
		<div id="preview1" style="display:none;z-index:99999999;position:absolute" class="blinking"><img src="bola.png"></div>
		<div id="preview2" style="display:none;z-index:99999999;position:absolute" class="blinking"><img src="bola.png"></div>
		<br><br><br><br><br><br><br><br>
		<img  class="imagem" id="mapa" src="emptyPlant_<?php echo $room;?>.jpg?<?php echo rand();?>"><br>
		<?php echo menu($room,2);?>
       
        <script src='https://code.jquery.com/jquery-1.11.3.js'></script>
        <script src='https://code.jquery.com/ui/1.11.4/jquery-ui.js'></script>
        <script src='http://cdn.jsdelivr.net/jquery.ui.rotatable/1.0.1/jquery.ui.rotatable.min.js'></script>
        <script>
	    $(document).ready(function() {
		    $('.prop').rotatable().draggable();
		    $(".prop" ).mouseup(function() {checkTrash();});
		});
		</script>
    </body>
</html>