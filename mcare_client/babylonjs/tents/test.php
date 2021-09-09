<?php
	
// test.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

$dblink =  mysqli_connect("host","user","password");
if (!$dblink) {
    die('Could not connect: ' . mysql_error());
}
mysqli_select_db($dblink,"who");
mysqli_query($dblink,"SET NAMES 'utf8';");
mysqli_query($dblink,"SET CHARACTER SET 'utf8';");


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Babylon Test</title>

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
        </style>

        <script src="https://cdn.babylonjs.com/babylon.js"></script>
        <script src="https://cdn.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>
        <script src="https://code.jquery.com/pep/0.4.3/pep.js"></script>
    </head>

   <body>
   <canvas id="renderCanvas" touch-action="none"></canvas>
   <script type = "text/javascript">
         var canvas = document.getElementById("renderCanvas");
         var engine = new BABYLON.Engine(canvas, true);
         
//-----------------------------------------------------


const createScene = () => {
    const scene = new BABYLON.Scene(engine);

    const camera = new BABYLON.ArcRotateCamera("Camera", 3 * Math.PI / 4, Math.PI / 4, 4, BABYLON.Vector3.Zero(), scene);
    camera.attachControl(canvas, true);
    
    
    var light = new BABYLON.DirectionalLight("dir01", new BABYLON.Vector3(-1, -2, -1), scene);
	light.position = new BABYLON.Vector3(20, 40, 20);
	light.intensity = 0.6;

    //var light2 = new BABYLON.SpotLight("spot02", new BABYLON.Vector3(30, 40, 20),new BABYLON.Vector3(-1, -2, -1), 1.1, 16, scene);
	//light2.intensity = 0.4;

    var light3 = new BABYLON.HemisphericLight("hemiLight", new BABYLON.Vector3(-1, 1, 0), scene);
	//light3.diffuse = new BABYLON.Color3(1, 1, 1);
	//light3.specular = new BABYLON.Color3(0, 1, 0);
	//light3.groundColor = new BABYLON.Color3(1, 1, 1);
	
    // Shadows
    var shadowGenerator = new BABYLON.ShadowGenerator(1024, light);
    
    
    //sky
    // Skybox
    var skybox = BABYLON.Mesh.CreateBox("skyBox", 800.0, scene);
    var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
    skyboxMaterial.backFaceCulling = false;
    skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("textures/skybox", scene);
    skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
    skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
    skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
    skybox.material = skyboxMaterial;
    
    
    
    

   // ---------- php
   <?php
	   
	 $cnt = 0;	
	 $amp = 1;                 
     $result = mysqli_query($dblink,"select x1,y1,x2,y2,roomname,id from maps where roomname='7' order by id  ");
     while($row = mysqli_fetch_row($result)){
	     echo drawWall($row[0],$row[1],$row[2],$row[3],$cnt,$amp);
	     $cnt = $cnt + 1;
     }
     
     echo drawTent(50,50,$door1,150,50,$door2,150,100,$door3,50,100,$door4,10,1);
     echo drawTent(50,150,$door1,150,150,$door2,150,200,$door3,50,200,$door4,20,1);
     echo drawTent(50,250,$door1,150,250,$door2,150,300,$door3,50,300,$door4,30,1);
     
     echo drawTent(200,250,$door1,300,250,$door2,300,300,$door3,200,300,$door4,40,1);
     echo drawTent(200,150,$door1,300,150,$door2,300,200,$door3,200,200,$door4,50,1);
     
     //grande
     echo drawTent(350,200,$door1,550,200,$door2,550,250,$door3,350,250,$door4,60,1);
     
     echo drawWall(0,0,600,0,70,1);
     echo drawWall(600,0,600,600,100,1);
     echo drawWall(600,600,0,600,80,1);
     echo drawWall(0,600,0,0,90,1);
     
     echo drawBed(1.3,-0.6,100);
     echo drawBed(1,-0.6,110);
     echo drawBed(0.7,-0.6,120);
     
   ?>
	
	 
    //--------- end php
    
    
    //prop
    var mesh1 = BABYLON.MeshBuilder.CreateBox("box", {height: 0.20, width: 0.10, depth: 0.0000001});
    mesh1.position.y = 0.10;
    mesh1.position.x = 1.8;
    mesh1.position.z = -0.5;
    //mesh1.rotation.y  =  BABYLON.Angle.FromDegrees(180).radians();
    var mat3 = new BABYLON.PBRMaterial("mat3", scene);
    mat3.albedoTexture = new BABYLON.Texture("doutor.png");
    mat3.albedoTexture.hasAlpha = true;
    mat3.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
    mat3.metallic = 0;
    mesh1.material = mat3;
    mesh1.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
    
    
    var mesh2 = BABYLON.MeshBuilder.CreateBox("box", {height: 0.20, width: 0.10, depth: 0.0000001});
    mesh2.position.y = 0.10;
    mesh2.position.x = 2;
    mesh2.position.z = -0.7;
    mesh2.material = mat3;
    mesh2.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
    
    var mesh3 = BABYLON.MeshBuilder.CreateBox("box", {height: 0.20, width: 0.10, depth: 0.0000001});
    mesh3.position.y = 0.10;
    mesh3.position.x = 3;
    mesh3.position.z = -0.5;
    mesh3.material = mat3;
    mesh3.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
    
    
    
    
   var chao = new BABYLON.PBRMaterial("chao", scene);
   chao.albedoTexture = new BABYLON.Texture("chao2.jpg");
   chao.metallic = 0;
   
   const box_g = BABYLON.MeshBuilder.CreatePlane("box", {height: 7, width: 7, sideOrientation: BABYLON.Mesh.DOUBLESIDE});
   box_g.position.y = 0;
   box_g.position.x = 3;
   box_g.position.z = -3;
   box_g.rotation.x  = BABYLON.Angle.FromDegrees(90).radians();
   box_g.material = chao;


//const ground = BABYLON.MeshBuilder.CreateGround("ground", {height: 6, width: 6, subdivisions: 4});
//ground.position.x = 3;
//ground.position.z = -3;
    

    <?php
	for($n=0;$n<$cnt;$n=$n+1){ 
	   echo'shadowGenerator.addShadowCaster(box_'.$n.');';
	}
	
	?>
    shadowGenerator.addShadowCaster(mesh1);
    
	shadowGenerator.useExponentialShadowMap = true;

	

	box_g.receiveShadows = true; 
	chao.receiveShadows = true;    
    
    
    
    
    
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
        $out = $out.'doente.albedoTexture = new BABYLON.Texture("doente.png");';
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
	    
	function drawTent($x1,$y1,$door1,$x2,$y2,$door2,$x3,$y3,$door3,$x4,$y4,$door4,$cnt,$amp){
	    $x1 = $x1/100;
		$y1 = $y1/100;
		$x2 = $x2/100;
		$y2 = $y2/100;
		$x3 = $x3/100;
		$y3 = $y3/100;
		$x4 = $x4/100;
		$y4 = $y4/100;
	    $x1 = $x1*$amp;
        $x2 = $x2*$amp;
        $x3 = $x3*$amp;
        $x4 = $x4*$amp;
        $y1 = $y1*$amp;
        $y2 = $y2*$amp;
        $y3 = $y3*$amp;
        $y4 = $y4*$amp;
        $pox1 = (($x1 + $x2)/2) - ($width/2);
        $poy1 = -(($y1 + $y2)/2) - ($height/2);
        
        $pox2 = (($x2 + $x3)/2) - ($width/2);
        $poy2 = -(($y2 + $y3)/2) - ($height/2);
        
        $pox3 = (($x3 + $x4)/2) - ($width/2);
        $poy3 = -(($y3 + $y4)/2) - ($height/2);
        
        $pox4 = (($x4 + $x1)/2) - ($width/2);
        $poy4 = -(($y4 + $y1)/2) - ($height/2);
        
        $comprimento1 = sqrt((($x2-$x1)*($x2-$x1)) + (($y2-$y1)*($y2-$y1)));
        $comprimento2 = sqrt((($x3-$x2)*($x3-$x2)) + (($y3-$y2)*($y3-$y2)));
        $comprimento3 = sqrt((($x4-$x3)*($x4-$x3)) + (($y4-$y3)*($y4-$y3)));
        $comprimento4 = sqrt((($x1-$x4)*($x1-$x4)) + (($y1-$y4)*($y1-$y4)));
        
        if($x1 == $x2){
           $rotacao1 = 90;
        }else if($y1 == $y2){
           $rotacao1 = 0;
        }else{
           $rotacao1 = atan2($x2-$x1,$y1-$y2);
           $pi = pi();
           $rotacao1 = atan2($y2 - $y1, $x2 - $x1) * 180 / $pi;
        }
        
        if($x2 == $x3){
           $rotacao2 = 90;
        }else if($y2 == $y3){
           $rotacao2 = 0;
        }else{
           $rotacao2 = atan2($x3-$x2,$y2-$y3);
           $pi = pi();
           $rotacao2 = atan2($y3 - $y2, $x3 - $x2) * 180 / $pi;
        }
        
        if($x3 == $x4){
           $rotacao3 = 90;
        }else if($y3 == $y4){
           $rotacao3 = 0;
        }else{
           $rotacao3 = atan2($x4-$x3,$y3-$y4);
           $pi = pi();
           $rotacao3 = atan2($y4 - $y3, $x4 - $x3) * 180 / $pi;
        }
        
        if($x4 == $x1){
           $rotacao4 = 90;
        }else if($y4 == $y1){
           $rotacao4 = 0;
        }else{
           $rotacao4 = atan2($x1-$x4,$y4-$y1);
           $pi = pi();
           $rotacao4 = atan2($y1 - $y4, $x1 - $x4) * 180 / $pi;
        }
        
        
        //textures
        $out = 'var sidetxt = new BABYLON.PBRMaterial("sidetxt", scene);';
        $out = $out.'sidetxt.albedoTexture = new BABYLON.Texture("ladotenda.png");';
        $out = $out.'sidetxt.metallic = 0;';
        
        $out = $out.'var sidetxtinv = new BABYLON.PBRMaterial("sidetxt", scene);';
        $out = $out.'sidetxtinv.albedoTexture = new BABYLON.Texture("ladotendainv.png");';
        $out = $out.'sidetxtinv.metallic = 0;';
        
        $out = $out.'var toptxt = new BABYLON.PBRMaterial("toptxt", scene);';
        $out = $out.'toptxt.albedoTexture = new BABYLON.Texture("tetotenda.png");';
        $out = $out.'toptxt.albedoTexture.hasAlpha = true;';
        $out = $out.'toptxt.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;';
        $out = $out.'toptxt.metallic = 0;';
        
        $out = $out.'var fronttxt = new BABYLON.PBRMaterial("fronttxt",scene);';
        $out = $out.'fronttxt.albedoTexture = new BABYLON.Texture("portatenda.png");';
        $out = $out.'fronttxt.albedoTexture.hasAlpha = true;';
        $out = $out.'fronttxt.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;';
        $out = $out.'fronttxt.metallic = 0;';
        
        $out = $out.'var fronttxtinv = new BABYLON.PBRMaterial("fronttxt",scene);';
        $out = $out.'fronttxtinv.albedoTexture = new BABYLON.Texture("portatendainv';   if(clean($_GET['door']) != "1")$out=$out."2";   $out=$out.'.png");';
        $out = $out.'fronttxtinv.albedoTexture.hasAlpha = true;';
        $out = $out.'fronttxtinv.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;';
        $out = $out.'fronttxtinv.metallic = 0;';
        
        $out = $out.'var doente = new BABYLON.PBRMaterial("doente", scene);';
        $out = $out.'doente.albedoTexture = new BABYLON.Texture("doente.png");';
        $out = $out.'doente.metallic = 0;';
        
	
	
	
        
        $out = $out.'const box_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("box", {height: 0.4, width: '.$comprimento1.', sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao1.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.175;';
        $poy1a = $poy1+0.015;
        $out = $out.'box_'.$cnt.'.position.x = '.$pox1.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy1a.';';
        $out = $out.'box_'.$cnt.'.rotation.x  = BABYLON.Angle.FromDegrees(-15).radians();';
        $out = $out.'box_'.$cnt.'.material = sidetxtinv;';
        $out = $out.'shadowGenerator.addShadowCaster(box_'.$cnt.');';
        
        
        if(clean($_GET['transparency']) != "1"){
        //roof
        $cnt = $cnt + 1;
        $out = $out.'const box_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("box", {height: '.(($comprimento2/2)+0.03).', width: '.$comprimento1.', sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao1.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.44;';
        $poy1 = $poy1 - 0.15;
        $out = $out.'box_'.$cnt.'.position.x = '.$pox1.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy1.';';
        $out = $out.'box_'.$cnt.'.rotation.x  = BABYLON.Angle.FromDegrees(-60).radians();';
        $out = $out.'box_'.$cnt.'.material = toptxt;';
        
        $cnt = $cnt + 1;
        $out = $out.'const box_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("box", {height: '.(($comprimento2/2)+0.03).', width: '.$comprimento1.', sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao1.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.44;';
        $poy3a = $poy3 + 0.13;
        $out = $out.'box_'.$cnt.'.position.x = '.$pox3.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy3a.';';
        $out = $out.'box_'.$cnt.'.rotation.x  = BABYLON.Angle.FromDegrees(60).radians();';
        $out = $out.'box_'.$cnt.'.material = toptxt;';
        }
        
        
        

        $cnt = $cnt + 1;
        $comprimento2a = $comprimento2 + 0.15;
        $out = $out.'const box_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("plane", {height: 0.54, width: '.$comprimento2a.', sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao2.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.27;';
        $out = $out.'box_'.$cnt.'.position.x = '.$pox2.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy2.';';
        $out = $out.'box_'.$cnt.'.material = fronttxtinv;';
        $out = $out.'shadowGenerator.addShadowCaster(box_'.$cnt.');';
        
        $cnt = $cnt + 1;
        $out = $out.'const box_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("box", {height: 0.4, width: '.$comprimento3.', sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao3.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.2;';
        $poy3a = $poy3 - 0.0175;
        $out = $out.'box_'.$cnt.'.position.x = '.$pox3.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy3a.';';
        $out = $out.'box_'.$cnt.'.rotation.x  = BABYLON.Angle.FromDegrees(15).radians();';
        $out = $out.'box_'.$cnt.'.material = sidetxt;';
        $out = $out.'shadowGenerator.addShadowCaster(box_'.$cnt.');';
        
        $cnt = $cnt + 1;
        $comprimento4a = $comprimento4 + 0.15;
        $out = $out.'const box_'.$cnt.' = BABYLON.MeshBuilder.CreatePlane("plane", {height: 0.54, width: '.$comprimento4a.', sideOrientation: BABYLON.Mesh.DOUBLESIDE});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao4.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.27;';
        $out = $out.'box_'.$cnt.'.position.x = '.$pox4.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy4.';';
        $out = $out.'box_'.$cnt.'.material = fronttxt;';
        //$out = $out.'shadowGenerator.addShadowCaster(box_'.$cnt.');';
        
        
        
        
        
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
        $out = 'const box_'.$cnt.' = BABYLON.MeshBuilder.CreateBox("box", {height: 0.1, width: '.$comprimento.', depth: 0.05});';
        $out = $out.'box_'.$cnt.'.rotation.y  =  BABYLON.Angle.FromDegrees('.$rotacao.').radians();';
        $out = $out.'box_'.$cnt.'.position.y = 0.05;';
        $out = $out.'box_'.$cnt.'.position.x = '.$pox.';';
        $out = $out.'box_'.$cnt.'.position.z = '.$poy.';';
        return($out);	
	}    
	        
    
                      
	 ?>