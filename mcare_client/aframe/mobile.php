<?php

if(!isset($_GET['room'])){
   echo "invalid id";
   exit();
}else{
   $room = $_GET['room'];
}


include("../db.php");	
$amp = 0.5;
list($width, $height) = getimagesize('EmptyFloorPlant_'.$room.'.jpg');
$width = round($width/100)-0.4;
$height = round($height/100)+0.4;
$width = $width*$amp;
$height = $height*$amp;
$semiwidth = round($width/2);
$semiheight = round($height/2)+1;
$espessura = "0.02";

	
?><html>
  <head>
    <script>
      if (window.location.protocol === 'http:') window.location.protocol = 'https:';
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>WHO</title>
      
     
    <script src="aframe-master.min.js"></script>
    <script src="https://supermedium.com/superframe/components/text-geometry/examples/build.js"></script>
  </head>
  <body>
	  <script>
		        AFRAME.registerComponent('intersect-color-change', {
  init: function () {
    var el = this.el;
    var material = el.getAttribute('material');
    var initialColor = material.color;
    var self = this;
    

    el.addEventListener('mousedown', function (evt) {
      //el.setAttribute('material', 'color', '#EF2D5E');
      //el.setAttribute('scale', {x: 1.2, y: 1.2, z: 1.2});
      el.setAttribute('scale', {x: 3, y: 3, z: 3});
      
      
    });

    el.addEventListener('mouseup', function (evt) {
      //el.setAttribute('material', 'color', self.isMouseEnter ? '#24CAFF' : initialColor);
      el.setAttribute('scale', {x: 1, y: 1, z: 1});
      
    });

    el.addEventListener('mouseenter', function () {
      //el.setAttribute('material', 'color', '#24CAFF');
      self.isMouseEnter = true;
      //el.setAttribute('scale', {x: 0.55, y: 0.55, z: 0.001});
    });

    el.addEventListener('mouseleave', function () {
      //el.setAttribute('material', 'color', initialColor);
      self.isMouseEnter = false;
      //el.setAttribute('scale', {x: 0.5, y: 0.5, z: 0.001});
    });
  }
});
	  </script>
    <a-scene renderer="antialias: true" webxr="referenceSpaceType: local" shadow="type: pcfsoft">
      
       
          <a-entity light="type: ambient; intensity: 0.8;"></a-entity>
         <a-entity light="type: directional;castShadow: true;intensity: 0.2;shadowCameraVisible: false;"position="-5 3 1.5"></a-entity>
	     
	     
	     <a-entity position="0 1.6 0" camera look-controls wasd-controls>
            <a-plane  visible="false" class="raycasted" id="terminal"  material="transparent:true; color: #ff0000; opacity: 0.8"  height="1" width="2" position="0 10 -3">
		       <a-entity visible="true" id="terminalText" text-geometry="value: Hello, World! this is a text from the message app comming from the server;size:0.03;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:white"   position="-0.7 0.3 0.1"></a-entity>
			   <a-entity visible="true" id="terminalText2" text-geometry="value: This is the second line from the text from the message app comming from the server;size:0.03;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:white"   position="-0.7 0.2 0.1"></a-entity>
			</a-plane>
	        <a-plane   visible="false" id="pannel"  material="transparent:true; color: #ffffff; opacity: 1"  height="1" width="2" position="0 0 -1">
		       <a-box visible="true" id="pannelBtn1" color="tomato" depth="0.1" height="0.1" width="0.1" position="0.1 -0.1 0"></a-box>
			   <a-box visible="true" id="pannelBtn2" color="tomato" depth="0.1" height="0.1" width="0.1" position="0.1 -0.3 0"></a-box>
			   <a-box visible="true" id="pannelBtn3" color="tomato" depth="0.1" height="0.1" width="0.1" position="-0.73 -0.1 0"></a-box>
			   <a-box visible="true" id="pannelBtn4" color="tomato" depth="0.1" height="0.1" width="0.1" position="-0.73 -0.3 0"></a-box>
			   <a-entity visible="true" id="pannelTextString1" text-geometry="value: Hello, World!  this is a text that does not fit ;size:0.06;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="-0.73 0.3 0.1"></a-entity>
	           <a-entity visible="true" id="pannelTextString2" text-geometry="value: this is second line of text;size:0.06;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="-0.73 0.19 0.1"></a-entity>
	           <a-entity visible="true" id="pannelTextString3" text-geometry="value: this is third of text;size:0.06;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="-0.73 0.08 0.1"></a-entity>
	           <a-entity visible="true" id="pannelText1" text-geometry="value: Choose option 1;size:0.03;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="-0.55 -0.1 0.1"></a-entity>
		       <a-entity visible="true" id="pannelText2" text-geometry="value: Choose option 2;size:0.03;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="-0.55 -0.3 0.1"></a-entity>
			   <a-entity visible="true" id="pannelText3" text-geometry="value: Choose option 3;size:0.03;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="0.22 -0.1 0.1"></a-entity>
			   <a-entity visible="true" id="pannelText4" text-geometry="value: Choose option 4;size:0.03;bevelEnabled:true;bevelSize:0;bevelThickness:0;height:0" material="color:black"   position="0.22 -0.3 0.1"></a-entity>
	        </a-plane>    
	        
	     </a-entity>
        
    	        
	        
	     <a-plane id="planta" shadow="receive: true;cast:true" position="0 0.01 0" material="src:EmptyFloorPlant_<?php echo $room;?>.jpg?<?php echo rand();?>"  rotation="-90 0 0" width="<?php echo $width;?>" height="<?php echo $height;?>" color="#AAAAAA"></a-plane>
	     <a-plane id="caixa" position="0 0 0" rotation="-90 0 0" width="<?php echo $width;?>" height="<?php echo $height;?>" color="#999999">
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
                         $comprimento = sqrt($comprimento)+"0.01";
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
                         echo'<a-box position="'.$pox.' '.$poy.' 0.10" width="'.$comprimento.'" height="'.$espessura.'" depth="0.2" rotation="0 0 '.$rotacao.'" color="#EEEEEE" shadow="receive: true;cast:true"></a-box>';
                      }
                      
	                 ?></a-plane>
	  
      
      
    
    
    <!-- dock -->
    <a-entity id="leftHand" laser-controls="hand: left" raycaster="objects: .raycasted"></a-entity>
         <a-entity id="rightHand" laser-controls="hand: right" raycaster="objects: .raycasted" line="color: #118A7E"></a-entity>
         <a-light position="0 0.5 1" intensity="0.35"></a-light>
         <a-box  cursor-listener material="src:images/player.png;opacity:1; transparent:true"   animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock1" depth="0.001" height="0.2" class="raycasted" width="0.2" position="-0.75 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/camera.png;opacity:1; transparent:true"   animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock2" depth="0.001" height="0.2" class="raycasted" width="0.2" position="-0.5 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/video.png;opacity:1; transparent:true"    animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock3" depth="0.001" height="0.2" class="raycasted" width="0.2" position="-0.25 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/check.png;opacity:1; transparent:true"    animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock4" depth="0.001" height="0.2" class="raycasted" width="0.2" position="0 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/gear.png;opacity:1; transparent:true"     animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock5" depth="0.001" height="0.2" class="raycasted" width="0.2" position="0.25 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/wrench.png;opacity:1; transparent:true"   animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock6" depth="0.001" height="0.2" class="raycasted" width="0.2" position="0.5 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/battery.png;opacity:1; transparent:true"  animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock7" depth="0.001" height="0.2" class="raycasted" width="0.2" position="0.75 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/trash2.png;opacity:1; transparent:true"   animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="dock8" depth="0.001" height="0.2" class="raycasted" width="0.2" position="1 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         <a-box  cursor-listener material="src:images/icon.png;opacity:1; transparent:true"     animation__mouseenter="property: object3D.position.y;  from: 1; to: 0.90; startEvents: mouseenter; dur: 500" animation__mouseleave="property: object3D.position.y;  from: 0.9; to: 1; startEvents: mouseleave; dur: 500"  id="smallTerminal" depth="0.001" height="0.2" class="raycasted" width="0.2" position="1.25 1 -5" intersect-color-change  shadow="cast: true;"></a-box>
         
	         

    <!-- end dock -->
    </a-scene>
    
    <script>
	    
	    function xxx(){
	    zoom = 0.7;
	    caixa.setAttribute('scale', zoom.toString() + ', ' + zoom.toString() + ', ' + zoom.toString());
	    planta.setAttribute('scale', zoom.toString() + ', ' + zoom.toString() + ', ' + zoom.toString());
	    caixa.object3D.position.y = -1;
	    planta.object3D.position.y = -1;
	    
	    planta.object3D.position.z = -1.5;
	    caixa.object3D.position.z  = -1.5;
	    
	    }
	     	    
	 
    </script>
    <script>
	     var el = document.getElementById('dock1');
         if(el){
            xxx();
         }
         
         var el2 = document.getElementById('smallTerminal');
         if(el2){
            el2.addEventListener("mousedown", showTerminal);
         }
	
	     function showTerminal(){
		     document.getElementById('terminal').setAttribute('visible', true);
		     document.getElementById('terminal').addEventListener("mousedown", hideTerminal);
		     document.getElementById('terminal').object3D.position.set(0, 0, -3);
	     } 
	     
	     function hideTerminal(){
		     document.getElementById('terminal').setAttribute('position', '0 0 -3');
		     document.getElementById('terminal').object3D.position.set(0, 10, -3);
		 } 
	  </script>
  </body>
</html>