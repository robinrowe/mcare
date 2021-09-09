<?php
	
// path.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
//we import deckdeckgo-drag-resize-rotate.esm.js  MIT license Open Source
	
if(!isset($_GET['room'])){
   echo "invalid id";
   exit();
}else{
   $room = clean($_GET['room']);
}
	
//check if plantPath$room.jpg exists and if not create it
if(file_exists( "original_".$room.".jpg")){
   if(!file_exists( "emptyPlant_".$room.".jpg"))	copy("original_".$room.".jpg", "emptyPlant_".$room.".jpg");
   if(!file_exists( "plantPath_".$room.".jpg"))     copy("emptyPlant_".$room.".jpg", "plantPath_".$room.".jpg");
	   
}else{
   echo "Main plant not found";exit();
}
	
include("db.php");
$out = "";
$points = 0;
$result = mysqli_query($dblink,"select x1,y1,x2,y2,id from path where room='".$room."'");
while($row = mysqli_fetch_row($result)){
   $x1 = $row[0];
   $y1 = $row[1];
   $id = $row[4];
   $x2 = $row[2];
   $y2 = $row[3];
   $showx1 = substr("0000".$x1,-4);
   $showy1 = substr("0000".$y1,-4);
   $showx2 = substr("0000".$x2,-4);
   $showy2 = substr("0000".$y2,-4);
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview(".$x1.",".$y1.",".$x2.",".$y2.")' style='font-size:12px'>".$showx1." : ".$showy1."  ".$showx2." : ".$showy2.'</span>&nbsp;<a class="prompt" href="deletePath.php?id='.$id.'&room='.$room.'">Delete</a>&nbsp;&nbsp;&nbsp;<br>';
   $points = $points + 1;
}
     
$out = $out."<h3>Marks</h3>";
     
//marks
$resultw = mysqli_query($dblink,"select x,y,id from pathMarks where roomname='".$room."'");
while($roww = mysqli_fetch_row($resultw)){
   $x1 = $roww[0];
   $y1 = $roww[1];
   $id = $roww[2];
   $showx1 = substr("0000".$x1,-4);
   $showy1 = substr("0000".$y1,-4);
   $out = $out."<span class='cur' onmouseout='revert()' onmouseover='preview2(".$x1.",".$y1.")' style='font-size:12px'>".$showx1." : ".$showy1.'</span>&nbsp;<a class="prompt" href="deleteMark.php?id='.$id.'&room='.$room.'">Delete</a>&nbsp;&nbsp;&nbsp;<br>';
       
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
                     document.getElementById('mapa').src = "plantPath_<?php echo $room;?>.jpg?" + Math.random();
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
                     //alert(this.responseText);
                     document.getElementById('mapa').src = "plantPath_<?php echo $room;?>.jpg?" + Math.random();
                     
                  }
               };
               xhttp.open("GET","redrawPath.php?room=<?php echo $room;?>", true);
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
	           document.getElementById('preview1').style.display = "block";
	           
	           document.getElementById('preview2').style.left = (x2 + elDistanceToLeft - 3) + "px"; 
	           document.getElementById('preview2').style.top = (y2 + elDistanceToTop - 3) + "px";
	           document.getElementById('preview2').style.display = "block";
	           
           }
           
           function preview2(x1,y1){ 
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
           
           
           var selectedIcon = 1;
           function selectIcon(v){
	           contador = 0;
	           document.getElementById('icn1').style.border = "3px solid #ffffff";
	           document.getElementById('icn2').style.border = "3px solid #ffffff";
	           document.getElementById('icn3').style.border = "3px solid #ffffff";
	           document.getElementById('icn4').style.border = "3px solid #ffffff";
	           document.getElementById('icn5').style.border = "3px solid #ffffff";
	           document.getElementById('icn6').style.border = "3px solid #ffffff";
	           document.getElementById('icn7').style.border = "3px solid #ffffff";
	           document.getElementById('icn8').style.border = "3px solid #ffffff";
	            
	           document.getElementById('icn' + v).style.border = "3px solid #999999"; 
	           selectedIcon = v;
           }
	    </script>  
	</head>
	<body style="background-color: #DDDDDD">
		
		<?php echo menu($room,5);?>
		
		<div id="crosshair-h" style="display:none" class="hair"></div>
        <div id="crosshair-v" style="display:none" class="hair"></div>
		<div id="preview1" style="display:none;z-index:99999999;position:absolute" class="blinking"><img src="bola.png"></div>
		<div id="preview2" style="display:none;z-index:99999999;position:absolute" class="blinking"><img src="bola.png"></div>
		<br><br><br><br><br><br><br><br>
		<img onmouseenter="show()" onmouseleave="hide()" class="imagem" id="mapa" src="plantPath_<?php echo $room;?>.jpg?<?php echo rand();?>">
		<div style="position:fixed;top:120px;right:0px">
			<br><br><h3>Pathways</h3>
			<div id="pontos" style=";height:600px;overflow:auto"><?php echo $out;?></div>
		</div>
			
        <script>
	        var coordx1;
	        var coordy1;
	        var coordx2;
	        var coordy2;
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
                  
                  if(contador == 1){
                     coordx2 = X;
                     coordy2 = Y;
                     var biv = 0;
                     if(selectedIcon == 2) biv = 1;
                     var white = 0;
                     var dst = "saveDotPath.php?x1=" + parseInt(coordx1) + "&y1=" + parseInt(coordy1) + "&x2=" + parseInt(coordx2) + "&y2=" + parseInt(coordy2) + "&bi=" + biv + "&room=<?php echo $room;?>&white=" + white;
                     ajaxSend(dst);
                     contador = 0;
                     coordx1 = "";
	                 coordy1 = "";
	                 coordx2 = "";
	                 coordy2 = "";
                  }else if (contador == 0){
	                 if(selectedIcon == 3 || selectedIcon == 4 || selectedIcon == 5 || selectedIcon == 6 || selectedIcon == 7  || selectedIcon == 8){
		                 var dst = "pathMark.php?x1=" + parseInt(X) + "&y1=" + parseInt(Y) + "&room=<?php echo $room;?>&type=" + selectedIcon;
                         window.location = dst;
	                 }
                     coordx1 = X;
                     coordy1 = Y;
                     contador = 1;
                     var elDistanceToTop = window.pageYOffset + mapa.getBoundingClientRect().top;
                     adcElemento(X+3,Y+elDistanceToTop-3);
                  }  
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