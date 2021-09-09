<?php
	
// index.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

$dblink =  mysqli_connect("host","user","password");
if (!$dblink) {
    die('Could not connect: ' . mysql_error());
}
mysqli_select_db($dblink,"who3");
mysqli_query($dblink,"SET NAMES 'utf8';");
mysqli_query($dblink,"SET CHARACTER SET 'utf8';");
$roomname = "5";
if(isset($_GET['roomname'])) $roomname = clean($_GET['roomname']);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <title>Who AR</title>

   <style>
   html, body {
      overflow: hidden;
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
   }

   #renderCanvas {
      width: 100%;
      height: 100%;
      touch-action: none;
   }
            
   #dock-container {
      position: fixed;
      bottom: 0;
      text-align: center;
      right: 20%;
      left: 20%;
      width: 60%;
      background: rgba(10,10,10,0.2);
      border-radius: 10px 10px 0 0;
   }
   #dock-container li {
      list-style-type: none;
      display: inline-block;
      position: relative;
   }
        
   #dock-container li img {
      width: 64px;
      height: 64px;
      -webkit-box-reflect: below 2px
      -webkit-gradient(linear, left top, left bottom, from(transparent),color-stop(0.7, transparent), to(rgba(255,255,255,.5)));
      -webkit-transition: all 0.3s;
      -webkit-transform-origin: 50% 100%;
      margin-left: 30px;
      margin-right: 30px;
   }
        
   #dock-container li:hover img { 
      -webkit-transform: scale(2);
      margin: 0 2em;
      margin-left: 30px;
      margin-right: 30px;
   }
   #dock-container li:hover + li img,
   #dock-container li.prev img {
      -webkit-transform: scale(1.5);
      margin: 0 1.5em;
   }
        
   #dock-container li span {
      display: none;
      position: absolute;
      bottom: 140px;
      left: 0;
      width: 100%;
      background-color: rgba(0,0,0,0.75);
      padding: 4px 0;
      border-radius: 12px;
      font-family: Arial;
   }
   #dock-container li:hover span {
      display: block;
      color: #fff;
   }
   .points{
	  font-family: Arial;
	  font-weight: bold;
	  font-size: 30px; 
	  color:#ffffff;
	  background-color: #999999;
	  padding:5px;
	  border-radius: 10px 10px 10px 10px;
	  margin-bottom: 20px;
	  position:relative;
   }
   
  </style>
  <script src="https://cdn.babylonjs.com/babylon.js"></script>
  <script src="https://cdn.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>
  <script src="https://code.jquery.com/pep/0.4.3/pep.js"></script>
  <script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>
</head>
<body>
	   
<div id="dock-container">
 <div id="dock">
   <ul>
	   <li>
	      <span>Player Name</span>
	      <img src="images/player.png"></li>
       <li>
        <span>Video</span>
        <a href="#"><img src="images/camera.png"/></a>
      </li>
      <li>
        <span>Checklist</span>
        <a href="#"><img src="images/check.png"/></a>
      </li>
      <li>
         <span>Tools</span>
         <a href="#"><img src="images/wrench.png"/></a>
      </li>
      <li>
         <span>Settings</span>
         <a href="#"><img src="images/gear.png"/></a>
      </li>
      <li>
         <span>Battery</span>
         <a href="#"><img src="images/battery.png"/></a>
      </li>
      <li>
         <div class="points">105 Pts</div>
      </li>
   </ul>
 </div>
</div>


<canvas id="renderCanvas" touch-action="none"></canvas>
<script type = "text/javascript">
         var canvas = document.getElementById("renderCanvas");
         var engine = new BABYLON.Engine(canvas, true);
         
//movement array for tests
var arr = ["0.3,-0.3","0.3,-1.5","1.5,-1.5","1.5,-0.3","0.3,-0.3"]



const createScene = () => {
    const scene = new BABYLON.Scene(engine);
    const camera = new BABYLON.ArcRotateCamera("Camera", 3 * Math.PI / 4, Math.PI / 3, 7, BABYLON.Vector3(4,-3,1), scene);
    camera.attachControl(canvas, true);
    var light = new BABYLON.DirectionalLight("dir01", new BABYLON.Vector3(-1, -2, -1), scene);
	light.position = new BABYLON.Vector3(20, 40, 20);
	light.intensity = 0.6;
    var light3 = new BABYLON.HemisphericLight("hemiLight", new BABYLON.Vector3(-1, 1, 0), scene);
	var shadowGenerator = new BABYLON.ShadowGenerator(1024, light);
    
    
    //sky
    var skybox = BABYLON.Mesh.CreateBox("skyBox", 800.0, scene);
    var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
    skyboxMaterial.backFaceCulling = false;
    skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("textures/skybox", scene);
    skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
    skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
    skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
    skybox.material = skyboxMaterial;
    
    
    //question mark mesh
    BABYLON.SceneLoader.ImportMesh("", "./", "meshes/question.gltf", scene, function (newMeshes) {
        newMeshes[0].position.x = 4;
        newMeshes[0].position.z = -3;
        newMeshes[0].position.y = 1;
        newMeshes[0].scaling = new BABYLON.Vector3(2,2,2);
        newMeshes[0].id = 'questionMark';
        var earthAxis = new BABYLON.Vector3(0, Math.cos(23 * Math.PI/180), 0);
        var angle = 0.01;
        scene.registerBeforeRender(function() {
           newMeshes[0].rotate(earthAxis, angle, BABYLON.Space.WORLD);
        })
        newMeshes[0].setEnabled(false);
        setTimeout(
           function(){ newMeshes[0].setEnabled(true); }
        , 5000);
        
    });
    
    
    // ---------- create walls (from database)
   <?php
	   
	  $cnt = 0;	
	  $amp = 1;                 
      $result = mysqli_query($dblink,"select x1,y1,x2,y2,roomname,id from maps where roomname='".$roomname."' order by id  ");
      while($row = mysqli_fetch_row($result)){
	     echo drawWall($row[0],$row[1],$row[2],$row[3],$cnt,$amp);
	     $cnt = $cnt + 1;
      }
     
   ?>
   //--------- end create walls
    
    
    //prop - doctor
    var mesh1 = BABYLON.MeshBuilder.CreateBox("box", {height: 0.10, width: 0.05, depth: 0.0000001});
    mesh1.position.y = 0.06;
    mesh1.position.x = 0.3;
    mesh1.position.z = -0.3;
    mesh1.id = "Doctor";
    var mat3 = new BABYLON.PBRMaterial("mat3", scene);
    mat3.albedoTexture = new BABYLON.Texture("images/doutor.png");
    mat3.albedoTexture.hasAlpha = true;
    mat3.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
    mat3.metallic = 0;
    mesh1.material = mat3;
    mesh1.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
    
    
    //ground
    const ground = BABYLON.MeshBuilder.CreateGround("ground", {height: 6, width: 10, subdivisions: 4});
    ground.position.x = 4;
    ground.position.z = -3;
    
    //add shadows in every wall created from php
    <?php
	for($n=0;$n<$cnt;$n=$n+1){ 
	   echo'shadowGenerator.addShadowCaster(box_'.$n.');';
	}
	
	?>
    shadowGenerator.addShadowCaster(mesh1);
    shadowGenerator.useExponentialShadowMap = true;
    ground.receiveShadows = true;    
    
    
    //animation
    var movement = new BABYLON.Animation("movement", "position", 30, BABYLON.Animation.ANIMATIONTYPE_VECTOR3, BABYLON.Animation.ANIMATIONLOOPMODE_CONSTANT);
    
   
    function go(com,prop){ 
	  var move_keys = [];
	  for(var i=0;i<com.length;i++){
		  var inx = parseInt(i)*60;
		  var coord = com[i].split(",");
		  move_keys.push({frame: inx,value: new BABYLON.Vector3(parseInt(coord[0]), 0.06, parseInt(coord[1]))});
	  }
	  movement.setKeys(move_keys);
      scene.beginDirectAnimation(prop, [movement], 0, parseInt(60*com.length), true,1);    
    }

    
    
    //click on mesh listener (doctor and question marks)
    window.addEventListener("click", function () {
        var pickResult = scene.pick(scene.pointerX, scene.pointerY);
        if (!pickResult.hit) {
            header.textContent = "No Picked Mesh"; 
        }else{
	        if(pickResult.pickedMesh.id == "Doctor"){
		        showPannel();
	        }
	        if(pickResult.pickedMesh.id == "Object_2"){
		        showQuestion();    
		    }
        }
    });
    
    // 2D GUI (pannel, card and dock
    //icon to open/close dock
    var wrench = document.createElement("img");
    wrench.style.bottom = "50px";
    wrench.style.left = "50px";
    wrench.style.width = "60px"
    wrench.style.height = "60px"
    wrench.setAttribute = ("id", "wrench");
    wrench.style.position = "absolute";
	wrench.style.zIndex = "999999";
	wrench.src = "images/wrench.png";
	document.body.appendChild(wrench);
    
    //pannel
    var button = document.createElement("button");
    button.style.top = "615px";
    button.style.left = "55px";
    button.textContent = "Move to Operation";
    button.style.width = "215px"
    button.style.height = "100px"
    button.setAttribute = ("id", "but");
    button.style.position = "absolute";
	button.style.backgroundColor = "#ffa602";
	button.style.zIndex = "999999";
	button.style.border = "none";
	button.style.fontSize = "20px";
    document.body.appendChild(button);
    var button2 = document.createElement("button");
    button2.style.top = "615px";
    button2.style.left = "285px";
    button2.textContent = "Move to Triage";
    button2.style.width = "215px"
    button2.style.height = "100px"
    button2.setAttribute = ("id", "but2");
    button2.style.position = "absolute";
	button2.style.backgroundColor = "#ffa602";
	button2.style.zIndex = "999999";
	button2.style.border = "none";
	button2.style.fontSize = "20px";
    document.body.appendChild(button2);
    var button3 = document.createElement("button");
    button3.style.top = "615px";
    button3.style.left = "515px"
    button3.textContent = "Move to Map";
    button3.style.width = "215px"
    button3.style.height = "100px"
    button3.setAttribute = ("id", "but3");
    button3.style.position = "absolute";
	button3.style.backgroundColor = "#ffa602";
	button3.style.zIndex = "999999";
	button3.style.border = "none";
	button3.style.fontSize = "20px";
    document.body.appendChild(button3);
    var pannel = document.createElement("img");
    pannel.style.position = "absolute";
    pannel.style.top = "30px";
    pannel.style.left = "30px";
    pannel.src = "images/pannel3.jpg";
    pannel.style.width = "730px";
    pannel.style.height = "708px";
    document.body.appendChild(pannel);
    
    var hr = document.createElement("img");
    hr.style.position = "absolute";
    hr.style.top = "395px";
    hr.style.left = "285px";
    hr.src = "images/hr.gif";
    hr.style.width = "215px";
    hr.style.height = "200px";
    hr.style.zIndex = "999999";
    document.body.appendChild(hr);
 
    //questions card
    var questionCard = document.createElement("img");
    questionCard.style.position = "absolute";
    questionCard.style.top = "30px";
    questionCard.style.left = "30px";
    questionCard.src = "images/pannelCard.jpg";
    questionCard.style.width = "730px";
    questionCard.style.height = "708px";
    document.body.appendChild(questionCard);
    var buttona = document.createElement("button");
    buttona.style.top = "615px";
    buttona.style.left = "55px";
    buttona.textContent = "REPLY";
    buttona.style.width = "215px"
    buttona.style.height = "100px"
    buttona.setAttribute = ("id", "buta");
    buttona.style.position = "absolute";
	buttona.style.backgroundColor = "#ffa602";
	buttona.style.zIndex = "999999";
	buttona.style.border = "none";
	buttona.style.fontSize = "20px";
    document.body.appendChild(buttona);
    var button2a = document.createElement("button");
    button2a.style.top = "615px";
    button2a.style.left = "285px";
    button2a.textContent = "DELEGATE";
    button2a.style.width = "215px"
    button2a.style.height = "100px"
    button2a.setAttribute = ("id", "but2a");
    button2a.style.position = "absolute";
	button2a.style.backgroundColor = "#ffa602";
	button2a.style.zIndex = "999999";
	button2a.style.border = "none";
	button2a.style.fontSize = "20px";
    document.body.appendChild(button2a);
    var button3a = document.createElement("button");
    button3a.style.top = "615px";
    button3a.style.left = "515px"
    button3a.textContent = "DISCARD";
    button3a.style.width = "215px"
    button3a.style.height = "100px"
    button3a.setAttribute = ("id", "but3a");
    button3a.style.position = "absolute";
	button3a.style.backgroundColor = "#ffa602";
	button3a.style.zIndex = "999999";
	button3a.style.border = "none";
	button3a.style.fontSize = "20px";
    document.body.appendChild(button3a);
    
    //start movement when clicking on button
    button.addEventListener("click", () => {
	    pannel.style.display = "none";
	    button.style.display = "none";
	    button2.style.display = "none";
	    button3.style.display = "none";
	    hr.style.display = "none";
        go(arr,mesh1);
    }) 
    
    buttona.addEventListener("click", () => {
	    questionCard.src = "images/pannelCard2.jpg";
    })
    button2a.addEventListener("click", () => {
	    questionCard.src = "images/pannelCard3.jpg";
    })
    button3a.addEventListener("click", () => {
	    hideQuestion();
    })
    button3.addEventListener("click", () => {
	    hidePannel();
    })
    
    wrench.addEventListener("click", () => {
	    if(document.getElementById('dock-container').style.display == "none"){
		    showDock();
		}else{
			hideDock();   
		}
    })
    
    function showQuestion(){
	   questionCard.style.display = "block"; 
	   buttona.style.display = "block";
	    button2a.style.display = "block";
	    button3a.style.display = "block";   
    }
    function hideQuestion(){
	   questionCard.style.display = "none";
	   buttona.style.display = "none";
	    button2a.style.display = "none";
	    button3a.style.display = "none";   
	    //Object_2.setEnabled(true); 
    }
    function showPannel(){
	    pannel.style.display = "block";
	    button.style.display = "block";
	    button2.style.display = "block";
	    button3.style.display = "block";
	    hr.style.display = "block";
    }
    
    function hidePannel(){
	    pannel.style.display = "none";
	    button.style.display = "none";
	    button2.style.display = "none";
	    button3.style.display = "none";
	    hr.style.display = "none";
        
    }
    
    function showDock(){
	    document.getElementById('dock-container').style.display = "block";
    }
    function hideDock(){
	   document.getElementById('dock-container').style.display = "none";
    }
    
    //hide all pannels on startup
    hidePannel();
    hideQuestion();
    hideDock();
    
    
    return scene;

};;




         var scene = createScene();
         engine.runRenderLoop(function() {
            scene.render();
         });
      </script>
   </body>
</html>	



    
<?php
	
	    
	function drawBed($x,$y,$cnt){
		$out = $out.'var doente = new BABYLON.PBRMaterial("doente", scene);';
        $out = $out.'doente.albedoTexture = new BABYLON.Texture("images/doente.png");';
        $out = $out.'doente.albedoTexture.hasAlpha = true;';
        $out = $out.'doente.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;';
        $out = $out.'doente.metallic = 0;';
        $out = $out.'const doente_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("plane", {height: 0.2, width: 0.1, sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'doente_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees(0).radians();';
        $out = $out.'doente_'.$cnt.'.rotation.x  =  BABYLON.Angle.FromDegrees(90).radians();';
        $out = $out.'doente_'.$cnt.'.position.y = 0.1;';
        $out = $out.'doente_'.$cnt.'.position.x = '.$x.';';
        $out = $out.'doente_'.$cnt.'.position.z = '.$y.';';
        $out = $out.'doente_'.$cnt.'.material = doente;';
        return($out);
	}    
	    
	function drawWall($x1,$y1,$x2,$y2,$cnt,$amp){
		$x1 = $x1/100;
		$y1 = $y1/100;
		$x2 = $x2/100;
		$y2 = $y2/100;
	    $x1 = $x1*$amp;
        $x2 = $x2*$amp;
        $y1 = $y1*$amp;
        $y2 = $y2*$amp;
        $pox = (($x1 + $x2)/2) - ($width/2);
        $poy = (($y1 + $y2)/2) - ($height/2);
        $poy = -$poy;
        $comprimento = sqrt((($x2-$x1)*($x2-$x1)) + (($y2-$y1)*($y2-$y1)));
        
        if($x1 == $x2){
           $rotacao = 90;
        }else if($y1 == $y2){
           $rotacao = 0;
        }else{
           $rotacao = atan2($x2-$x1,$y1-$y2);
           $pi = pi();
           $rotacao = atan2($y2 - $y1, $x2 - $x1) * 180 / $pi;
        }
        $out = 'const box_'.$cnt.' = BABYLON.MeshBuilder.CreateBox("box", {height: 0.16, width: '.$comprimento.', depth: 0.02});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.08;';
        $out = $out.'box_'.$cnt.'.position.x = '.$pox.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy.';';
        return($out);	
	}    
	        
?>