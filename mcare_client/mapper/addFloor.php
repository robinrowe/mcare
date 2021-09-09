<?php
	
// addFloor.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
//we import deckdeckgo-drag-resize-rotate.esm.js  MIT license Open Source
	
if(!isset($_GET['room'])){
   echo "invalid id";
   exit();
}else{
   $room = clean($_GET['room']);
}
	
	
//check if plant_$room.jpg and emptyPlant_$room.jpg exist and if not create them
if(file_exists( "original_".$room.".jpg")){
   if(!file_exists( "emptyPlant_".$room.".jpg"))         copy("original_".$room.".jpg", "emptyPlant_".$room.".jpg");
   if(!file_exists( "floorPlant_".$room.".jpg"))         copy("emptyPlant_".$room.".jpg", "floorPlant_".$room.".jpg");
}else{
   echo "Main plant not found";exit();
}

include("db.php");
$out = "";
$points = 0;
$floortodelete = "0";
$result = mysqli_query($dblink,"select x1,y1,id,floorId from floor where room='".$room."'");
while($row = mysqli_fetch_row($result)){
   $x1 = $row[0];
   $y1 = $row[1];
   $id = $row[2];
   $floorId = $row[3];
   $showx1 = substr("0000".$x1,-4);
   $showy1 = substr("0000".$y1,-4);
       
   if($floorId != $floortodelete){
      $floortodelete = $floorId;
      if($floorId != "") $out = $out."<br><span class='prompt'><a href='deleteAllPolygon.php?room=".$room."&id=".$floorId."'>Delete all room ".$floorId."</a><br><br>";
   }
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview(".$x1.",".$y1.")' style='font-size:12px'>".$showx1." : ".$showy1.'  (Room '.$floorId.')</span>&nbsp;<a class="prompt" href="deletePointFloor.php?id='.$id.'">Delete</a>&nbsp;&nbsp;&nbsp;<br>';
   $points = $points + 1;
}
     
?>

<html>
	<head>
	   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>	
	   <script type="module" src="https://unpkg.com/@deckdeckgo/drag-resize-rotate@latest/dist/deckdeckgo-drag-resize-rotate/deckdeckgo-drag-resize-rotate.esm.js"></script>
	   <style>
	      #crosshair-h{
             width:100%;
             height:1px;
             margin-top:-1px;
          }
          .prompt{
	         font-size:12px;
	         font-family: Arial;   
          }
          .promptsmall{
	         font-size:10px;
	         font-family: Arial;   
          }
          #crosshair-v{
             height:100%;
             width:1px;
             margin-left:-1px;
          }
          .hair{    
             position:fixed;
             background-color:rgba(255,0,0,1);
             #box-shadow:0 0 5px rgb(100,100,100);
          }
          .blinking{
             animation:blinkingText 0.5s infinite;
          }
          @keyframes blinkingText{
             0%{     opacity: 1;    }
             100%{   opacity: 0;    }
          }	 
          .marker{
	          
          } 
          .cur{
	          cursor:pointer;
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
		   function redraw(){
			   var out = "";
			   var mapa = document.getElementById('mapa');
			   var elDistanceToTop = window.pageYOffset + mapa.getBoundingClientRect().top;
			   var elDistanceToLeft = window.pageXOffset + mapa.getBoundingClientRect().left;
			   console.log(elDistanceToLeft + ":" + elDistanceToTop);
			   for (var i = 0; i < coordx.length; i++) {
				  //console.log(coordx[i] + ":" + coordy[i]);
                  //out = out + "<br>" + parseInt(coordx[i]) + ":" + parseInt(coordy[i]);
                  
                  adcElemento(parseInt(coordx[i] + elDistanceToLeft - 3),parseInt(coordy[i] + elDistanceToTop - 3));
               }
               
               document.getElementById('pontos').innerHTML = out;
           }
           
           function ajaxSend(query){
	           var xhttp;
               xhttp = new XMLHttpRequest();
               xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                     document.getElementById('mapa').src = "floorPlant_<?php echo $room;?>.jpg?" + Math.random();
                     //limpa todas as divs
                     cleandivs();
                     redrawValues();
                  }
               };
               xhttp.open("GET",query, true);
               xhttp.send();  
           }
           
           function redrawValues(){  
	          var xhttp;
               xhttp = new XMLHttpRequest();
               xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                     document.getElementById('pontos').innerHTML = this.responseText;
                  }
               };
               xhttp.open("GET","redrawValuesFloor.php?room=<?php echo $room;?>", true);
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
           function preview(x1,y1){ 
	           var mapa = document.getElementById('mapa');
			   var elDistanceToTop = window.pageYOffset + mapa.getBoundingClientRect().top;
			   var elDistanceToLeft = window.pageXOffset + mapa.getBoundingClientRect().left;
	           document.getElementById('preview1').style.left = (x1 + elDistanceToLeft - 3) + "px"; 
	           document.getElementById('preview1').style.top = (y1 + elDistanceToTop - 3) + "px";
	           document.getElementById('preview1').style.display = "block";
	           
           }
           
           
           var multiplier = 10;
                      
           function magnify(){
	           multiplier = document.getElementById('magnify').value;
	           document.getElementById('mag').innerHTML = document.getElementById('magnify').value;
	           document.getElementById('legenda').style.width = multiplier*23;
	       }
	       
	       function saveProp(){
	           var divsToSave = document.getElementsByClassName("prop");
               for (var i = divsToSave.length-1; i >= 0; i--) {
                   //console.log("x:" + divsToSave[i].style.left + ",y:" + divsToSave.style.top);
                   
                   var rect = divsToSave[i].getBoundingClientRect();
                   //console.log(rect.top, rect.right, rect.bottom, rect.left);
                   
                   var elDistanceToTop = window.pageYOffset + divsToSave[i].firstElementChild.getBoundingClientRect().top;
			       var elDistanceToLeft = window.pageXOffset + divsToSave[i].firstElementChild.getBoundingClientRect().left;
                   
                   var el = divsToSave[i];
                   var st = window.getComputedStyle(el, null);
                   var tr = st.getPropertyValue("-webkit-transform") || st.getPropertyValue("-moz-transform") || st.getPropertyValue("-ms-transform") || st.getPropertyValue("-o-transform") || st.getPropertyValue("transform") || "fail...";
                   var values = tr.split('(')[1];
                   values = values.split(')')[0];
                   values = values.split(',');
                   var a = values[0];
                   var b = values[1];
                   var c = values[2];
                   var d = values[3];
                   var scale = Math.sqrt(a*a + b*b);
                   var sin = b/scale;
                   var angle = Math.round(Math.asin(sin) * (180/Math.PI));
                   var xmedium = rect.left;
                   var ymedium = rect.top;
                   console.log('Angulo: ' + angle + " x:" + elDistanceToLeft + " y:" + elDistanceToTop);
               }
           }
	    </script>  
	</head>
	<body style="background-color: #DDDDDD">
		<?php echo menu($room,3);?>
		<div id="crosshair-h" style="display:none" class="hair"></div>
        <div id="crosshair-v" style="display:none" class="hair"></div>
		<!--<div id="coord"></div>-->
		<div id="preview1" style="display:none;z-index:99999999;position:absolute" class="blinking"><img src="bola.png"></div>
		<div id="preview2" style="display:none;z-index:99999999;position:absolute" class="blinking"><img src="bola.png"></div>
		<br><br><br><br><br><br><br><br>
		<img onmouseenter="show()" onmouseleave="hide()" class="imagem" id="mapa" src="floorPlant_<?php echo $room;?>.jpg?<?php echo rand();?>">
		<div style="position:fixed;top:120px;right:0px">
		<br><br>
		<div id="pontos" style=";height:600px;overflow:auto"><?php echo $out;?></div></span></div>
		 <script>
	        var coordx = [];
	        var coordy = [];
            $(document).ready(function() {
	            
               $('img').mousemove(function(e) {
                  var offset = $(this).offset();
                  var X = (e.pageX - offset.left);
                  var Y = (e.pageY - offset.top);
                  $('#coord').text('X: ' + X + ', Y: ' + Y);
                });
                
                $('img').click(function(e) {
                  var offset = $(this).offset();
                  var X = (e.pageX - offset.left);
                  var Y = (e.pageY - offset.top);
                  coordx.push(X);
                  coordy.push(Y);
                      x1 = X;
	                  y1 = Y;
	                  contador = contador + 1;
                      var dst = "saveDotFloor.php?x1=" + parseInt(x1) + "&y1=" + parseInt(y1) + "&room=<?php echo $room;?>";
	                  ajaxSend(dst);
	                  contador = 0;
                  redraw();
                });
        
                $(function(){
                   var cH = $('#crosshair-h'),
                   cV = $('#crosshair-v');

                   $(document).on('mousemove',function(e){
	                   var scroll = $(window).scrollTop();
                      cH.css('top',e.pageY-scroll);
                      cV.css('left',e.pageX);
                   });
                });
            });
        </script>
	</body>
</html>