<?php
	
// ar5.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source
//we import deckdeckgo-drag-resize-rotate.esm.js  MIT license Open Source

$dblink =  mysqli_connect("host","user","password");
if (!$dblink) {
    die('Could not connect: ' . mysql_error());
}
mysqli_select_db($dblink,"who3");
mysqli_query($dblink,"SET NAMES 'utf8';");
mysqli_query($dblink,"SET CHARACTER SET 'utf8';");
$roomname = "5";
if(isset($_GET['roomname'])) $roomname = $_GET['roomname'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Babylon.js sample code</title>

        <!-- Babylon.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.2/dat.gui.min.js"></script>
        <script src="https://preview.babylonjs.com/ammo.js"></script>
        <script src="https://preview.babylonjs.com/cannon.js"></script>
        <script src="https://preview.babylonjs.com/Oimo.js"></script>
        <script src="https://preview.babylonjs.com/earcut.min.js"></script>
        <script src="https://preview.babylonjs.com/babylon.js"></script>
        <script src="https://preview.babylonjs.com/materialsLibrary/babylonjs.materials.min.js"></script>
        <script src="https://preview.babylonjs.com/proceduralTexturesLibrary/babylonjs.proceduralTextures.min.js"></script>
        <script src="https://preview.babylonjs.com/postProcessesLibrary/babylonjs.postProcess.min.js"></script>
        <script src="https://preview.babylonjs.com/loaders/babylonjs.loaders.js"></script>
        <script src="https://preview.babylonjs.com/serializers/babylonjs.serializers.min.js"></script>
        <script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>
        <script src="https://preview.babylonjs.com/inspector/babylon.inspector.bundle.js"></script>

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
    </head>
<body>
    <canvas id="renderCanvas"></canvas>
    <script>
        var canvas = document.getElementById("renderCanvas");

        var engine = null;
        var scene = null;
        var sceneToRender = null;
        var createDefaultEngine = function() { return new BABYLON.Engine(canvas, true, { preserveDrawingBuffer: true, stencil: true,  disableWebGL2Support: false}); };
        
       
        var createScene = async function () {


        screenWidth = window.screen.width * window.devicePixelRatio;
        screenHeight = window.screen.height * window.devicePixelRatio;
        centerScreenWidth = Math.round(screenWidth/2);
        centerScreenHeight = Math.round(screenHeight/2);

        var scene = new BABYLON.Scene(engine);
        var camera = new BABYLON.FreeCamera("camera1", new BABYLON.Vector3(0, 1, -5), scene);
        camera.setTarget(BABYLON.Vector3.Zero());
        camera.attachControl(canvas, true);
        var light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(0, 1, 0), scene);
    
        var xr = await scene.createDefaultXRExperienceAsync({
            uiOptions: {
                sessionMode: "immersive-ar",
                referenceSpaceType: "local-floor"
            },
            optionalFeatures: true
        });

        xr.pointerSelection.attach();

       
        
    
    
      
    
    
       
    /*
    var advancedTexturePanel = BABYLON.GUI.AdvancedDynamicTexture.CreateFullscreenUI("UIpanel");
    
    
    
    var rect1 = new BABYLON.GUI.Rectangle();
    rect1.width = 0.8;
    rect1.height = 0.8;
    rect1.cornerRadius = 5;
    rect1.color = "Orange";
    rect1.thickness = 3;
    rect1.background = "#333333";
    advancedTexturePanel.addControl(rect1);
    
    
    
    var imagePanel = new BABYLON.GUI.Image("but", "images/patient.jpg");
    imagePanel.width = 0.2;
    imagePanel.height = 0.4;
    imagePanel.left = "-25%";
    imagePanel.top = "-15%";
    advancedTexturePanel.addControl(imagePanel); 
    
    
    var text1 = new BABYLON.GUI.TextBlock();
    text1.text = "Injury: Tarmac\nName: Lane Charlie\nAge: 26\nGender: Male\nLeft forearm soft tissue laceration with\na suspected fracture on the olecranon/elbow";
    text1.color = "white";
    text1.fontSize = 20;
    text1.top = "-15%";
    text1.left = "40%";
    text1.textHorizontalAlignment = "left";
    advancedTexturePanel.addControl(text1);
    
    var button1Panel = BABYLON.GUI.Button.CreateSimpleButton("but1", "Operation");
    button1Panel.width = 0.2;
    button1Panel.height = 0.2;
    button1Panel.color = "black";
    button1Panel.top = "25%";
    button1Panel.fontSize = "30px";
    button1Panel.background = "Orange";
    button1Panel.left = "-25%";
    advancedTexturePanel.addControl(button1Panel);
    
    var button2Panel = BABYLON.GUI.Button.CreateSimpleButton("but1", "Triage");
    button2Panel.width = 0.2;
    button2Panel.height = 0.2;
    button2Panel.color = "black";
    button2Panel.top = "25%";
    button2Panel.fontSize = "30px";
    button2Panel.background = "Orange";
    advancedTexturePanel.addControl(button2Panel);
    
    var button3Panel = BABYLON.GUI.Button.CreateSimpleButton("but1", "Close");
    button3Panel.width = 0.2;
    button3Panel.height = 0.2;
    button3Panel.color = "black";
    button3Panel.top = "25%";
    button3Panel.fontSize = "30px";
    button3Panel.background = "Orange";
    button3Panel.left = "25%";
    advancedTexturePanel.addControl(button3Panel);
    */
    
    
    var box = BABYLON.Mesh.CreateBox("mira", 0.02, scene);
    box.position.z = 2;
    box.parent = camera;
    var material = new BABYLON.StandardMaterial("std", scene);
    material.diffuseColor = new BABYLON.Color3(1, 1, 0); 
    box.material = material;
    
    // GUI
    var advancedTexture = BABYLON.GUI.AdvancedDynamicTexture.CreateFullscreenUI("UI");
    
    
    var button1 = BABYLON.GUI.Button.CreateSimpleButton("but1", "Click Me");
    button1.width = "750px"
    button1.height = "160px";
    button1.color = "white";
    button1.cornerRadius = 20;
    button1.top = "600px";
    button1.fontSize = "60px";
    advancedTexture.addControl(button1);

    var button2 = BABYLON.GUI.Button.CreateSimpleButton("but2", "+");
    button2.width = "50px"
    button2.height = "50px";
    button2.color = "white";
    button2.cornerRadius = 100;
    button2.top = "80px";
    button2.border = "none";
    button2.fontSize = "60px";
    advancedTexture.addControl(button2);
    
    

    function gaze(meshid){
        if(meshid != 0){
           if(meshid == "dock1") rizeDock(1);
           if(meshid == "dock2") rizeDock(2);
           if(meshid == "dock3") rizeDock(3);
           if(meshid == "dock4") rizeDock(4);
           if(meshid == "dock5") rizeDock(5);
        }
    }

    function rizeDock(dockid){
        if(dockid == 1) elem = dock1;
        if(dockid == 2) elem = dock2;
        if(dockid == 3) elem = dock3;
        if(dockid == 4) elem = dock4;
        if(dockid == 5) elem = dock5;
        scene.beginAnimation(elem, 0, frameRate, true);
    }

    scene.registerBeforeRender(function () {
        var pickResult = scene.pick(centerScreenWidth,centerScreenHeight);
        if (pickResult.hit) {
            button1.textBlock.text = pickResult.pickedMesh.name;
            gaze(pickResult.pickedMesh.name);
        }else{
            button1.textBlock.text = "";
            gaze(0);
        }
    });
        const fm = xr.baseExperience.featuresManager;
        const xrTest = fm.enableFeature(BABYLON.WebXRHitTest.Name, "latest");
        const anchors = fm.enableFeature(BABYLON.WebXRAnchorSystem.Name, 'latest');
        
        
       
        
        
        
    /*    
        var materialbtn = new BABYLON.StandardMaterial("materialbtn", scene);
        materialbtn.diffuseColor = new BABYLON.Color3(1, 1, 0);
        var materialbtnbg = new BABYLON.StandardMaterial("materialbtnbg", scene);
        materialbtnbg.diffuseColor = new BABYLON.Color3(0.3, 0.3, 0.3); 
        
        let btpanel = BABYLON.MeshBuilder.CreatePlane("btpanel", {height: 2, width: 3});
        let bt1 = BABYLON.MeshBuilder.CreateBox("bt1", {height: 0.5, width: 0.5,depth:0.03});
        let bt2 = BABYLON.MeshBuilder.CreateBox("bt2", {height: 0.5, width: 0.5,depth:0.03});
        let bt3 = BABYLON.MeshBuilder.CreateBox("bt3", {height: 0.5, width: 0.5,depth:0.03});
        btpanel.billboardMode = BABYLON.AbstractMesh.BILLBOARDMODE_ALL;
        btpanel.visibility = 0;
        btpanel.material = materialbtnbg;
        bt1.material = materialbtn;
        bt2.material = materialbtn;
        bt3.material = materialbtn;
        btpanel.visibility = 0;
        bt1.visibility = 0;
        bt2.visibility = 0;
        bt3.visibility = 0;
        //bt1.billboardMode = BABYLON.AbstractMesh.BILLBOARDMODE_ALL;
        bt1.parent = btpanel;bt2.parent = btpanel;bt3.parent = btpanel;
        //bt2.billboardMode = BABYLON.AbstractMesh.BILLBOARDMODE_ALL;
        //bt3.billboardMode = BABYLON.AbstractMesh.BILLBOARDMODE_ALL;
        
        var outputplaneTexture = new BABYLON.DynamicTexture("dynamic texture", 512, scene, true);
	    btpanel.material.diffuseTexture = outputplaneTexture;
	    btpanel.material.specularColor = new BABYLON.Color3(0, 0, 0);
	    btpanel.material.emissiveColor = new BABYLON.Color3(1, 1, 1);
	    btpanel.material.backFaceCulling = false;
	    outputplaneTexture.drawText("Some Text", null, 140, "bold 80px verdana", "white");
    */    
        
       
        

        

        var matDock1 = new BABYLON.PBRMaterial("matDock1", scene);
        matDock1.albedoTexture = new BABYLON.Texture("images/camera.png");
        matDock1.albedoTexture.hasAlpha = true;
        matDock1.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
        matDock1.metallic = 0;
        
        var matDock2 = new BABYLON.PBRMaterial("matDock2", scene);
        matDock2.albedoTexture = new BABYLON.Texture("images/check.png");
        matDock2.albedoTexture.hasAlpha = true;
        matDock2.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
        matDock2.metallic = 0;
        
        var matDock3 = new BABYLON.PBRMaterial("matDock3", scene);
        matDock3.albedoTexture = new BABYLON.Texture("images/wrench.png");
        matDock3.albedoTexture.hasAlpha = true;
        matDock3.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
        matDock3.metallic = 0;
        
        var matDock4 = new BABYLON.PBRMaterial("matDock4", scene);
        matDock4.albedoTexture = new BABYLON.Texture("images/gear.png");
        matDock4.albedoTexture.hasAlpha = true;
        matDock4.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
        matDock4.metallic = 0;
        
        var matDock5 = new BABYLON.PBRMaterial("matDock3", scene);
        matDock5.albedoTexture = new BABYLON.Texture("images/battery.png");
        matDock5.albedoTexture.hasAlpha = true;
        matDock5.transparencyMode = BABYLON.PBRMaterial.MATERIAL_ALPHATEST;
        matDock5.metallic = 0;
        
        
        
        let dock1 = BABYLON.MeshBuilder.CreateBox("dock1", {height: 0.25, width: 0.25, depth: 0.01});
        dock1.setEnabled(true);
        dock1.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
        dock1.position.y = 1;
        

        let dock2 = BABYLON.MeshBuilder.CreateBox("dock2", {height: 0.25, width: 0.25, depth: 0.01});
        dock2.setEnabled(true);
        dock2.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
        dock2.position.y = 1;
        dock2.position.x = dock1.position.x + 0.3;
        
        let dock3 = BABYLON.MeshBuilder.CreateBox("dock3", {height: 0.25, width: 0.25, depth: 0.01});
        dock3.setEnabled(true);
        dock3.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
        dock3.position.y = 1;
        dock3.position.x = dock1.position.x + 0.6;
        
        let dock4 = BABYLON.MeshBuilder.CreateBox("dock4", {height: 0.25, width: 0.25, depth: 0.01});
        dock4.setEnabled(true);
        dock4.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
        dock4.position.y = 1;
        dock4.position.x = dock1.position.x + 0.9;
        
        let dock5 = BABYLON.MeshBuilder.CreateBox("dock5", {height: 0.25, width: 0.25, depth: 0.01});
        dock5.setEnabled(true);
        dock5.billboardMode = BABYLON.Mesh.BILLBOARDMODE_ALL;
        dock5.position.y = 1;
        dock5.position.x = dock1.position.x + 1.2;
        
        dock1.material = matDock1;
        dock2.material = matDock2;
        dock3.material = matDock3;
        dock4.material = matDock4;
        dock5.material = matDock5;
        
        var advancedTexturePanel = BABYLON.GUI.AdvancedDynamicTexture.CreateFullscreenUI("UIpanel");
    var panels = new BABYLON.GUI.StackPanel();
    panels.width = 1;
    panels.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_RIGHT;
    panels.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_CENTER;
    advancedTexturePanel.addControl(panels);
    
    var headerPrompt = new BABYLON.GUI.TextBlock();
    headerPrompt.text = "Please adjust plant";
    headerPrompt.height = "100px";
    headerPrompt.color = "yellow";
    headerPrompt.fontSize = 90;
    panels.addControl(headerPrompt); 

    var header = new BABYLON.GUI.TextBlock();
    header.text = "Rotation: 0 deg";
    header.height = "100px";
    header.color = "white";
    header.fontSize = 60;
    panels.addControl(header); 

    var slider = new BABYLON.GUI.Slider();
    slider.minimum = 0;
    slider.maximum = 2 * Math.PI;
    slider.value = 0;
    slider.height = "100px";
    slider.width = 0.8;
    slider.onValueChangedObservable.add(function(value) {
        header.text = "Rotation: " + (BABYLON.Tools.ToDegrees(value) | 0) + " deg";
        root.rotation.y = value;
    });
    panels.addControl(slider);
    
    var header2 = new BABYLON.GUI.TextBlock();
    header2.text = "Zoom: 1x";
    header2.height = "100px";
    header2.color = "white";
    header2.fontSize = 60;
    panels.addControl(header2);
    
    var slider2 = new BABYLON.GUI.Slider();
    slider2.minimum = 0.2;
    slider2.maximum = 2;
    slider2.value = 1;
    slider2.height = "100px";
    slider2.width = 0.8;
    slider2.onValueChangedObservable.add(function(value2) {
        header2.text = "Zoom: " + Math.round(value2 * 10)/10 + "x";
        resizeHospital(value2);
    });
    panels.addControl(slider2);
    
   
    
    var buttonSliders = BABYLON.GUI.Button.CreateSimpleButton("but1", "Save");
    buttonSliders.width = 0.8;
    buttonSliders.paddingTop = "80px";
    buttonSliders.height = "200px";
    buttonSliders.color = "white";
    buttonSliders.cornerRadius = 5;
    buttonSliders.background = "grey";
    buttonSliders.fontSize = 70;
    buttonSliders.onPointerDownObservable.add(function() {
        panels.isVisible = false;
        //box.isVisible = true;
        button1.isVisible = true;
        button2.isVisible = true;
    });
    panels.addControl(buttonSliders); 
    
    
    panels.isVisible = false;
    
    var zoom = 1;
    function resizeHospital(value2){
	    var zoomVal = zoom;
	    zoom = value2;
	    var newZoom = value2/zoomVal;
	    
	    for(var y=1;y< wallNumber;y = y + 1){
	                eval('box_' + y + '.scaling.x = value2;');
	                eval('box_' + y + '.scaling.z =  value2;');
	                eval('box_' + y + '.position.x = box_' + y + '.position.x *' + newZoom + ';' );
	                eval('box_' + y + '.position.z = box_' + y + '.position.z *' + newZoom + ';' );
	     }
	     
    }

        

        const frameRate = 10;
        const ySlideUp = new BABYLON.Animation("ySlide", "position.y", frameRate, BABYLON.Animation.ANIMATIONTYPE_FLOAT, BABYLON.Animation.ANIMATIONLOOPMODE_CONSTANT);
        const keyFrames = []; 
        keyFrames.push({frame: 0,value: 2});
        keyFrames.push({frame: frameRate,value: 2.2});
        ySlideUp.setKeys(keyFrames);
        dock1.animations.push(ySlideUp);
        dock2.animations.push(ySlideUp);
        dock3.animations.push(ySlideUp);
        dock4.animations.push(ySlideUp);
        dock5.animations.push(ySlideUp);

        const ySlideDown = new BABYLON.Animation("ySlide", "position.y", frameRate, BABYLON.Animation.ANIMATIONTYPE_FLOAT, BABYLON.Animation.ANIMATIONLOOPMODE_CONSTANT);
        const keyFrames2 = []; 
        keyFrames2.push({frame: 0,value: 2.2});
        keyFrames2.push({frame: frameRate,value: 2.0});
        ySlideDown.setKeys(keyFrames2);
        dock1.animations.push(ySlideDown);
        dock2.animations.push(ySlideDown);
        dock3.animations.push(ySlideDown);
        dock4.animations.push(ySlideDown);
        dock5.animations.push(ySlideDown);
        
        dock1.isVisible = false;
        dock2.isVisible = false;
        dock3.isVisible = false;
        dock4.isVisible = false;
        dock5.isVisible = false;
        

        const marker = BABYLON.MeshBuilder.CreateTorus('marker', { diameter: 0.12, thickness: 0.025 });
        marker.isVisible = false;
        marker.rotationQuaternion = new BABYLON.Quaternion();
        
        let hitTest;
        var endHitTest = 0;

        xrTest.onHitTestResultObservable.add((results) => {
            if (results.length) {
                if(endHitTest == 0){
                marker.isVisible = true;
                hitTest = results[0];
                hitTest.transformationMatrix.decompose(undefined, marker.rotationQuaternion, marker.position);
                }

            } else {
                marker.isVisible = false;
                hitTest=undefined;
            }
        });
        
        if (anchors) {

            anchors.onAnchorAddedObservable.add(anchor => {
                marker.isVisible = true;
                marker.setEnabled(true);
                anchor.attachedNode = marker;   
            });
            
            anchors.onAnchorRemovedObservable.add(anchor => {
                console.log('disposing', anchor);
                if (anchor) {
                    anchor.attachedNode.isVisible = false;
                    anchor.attachedNode.dispose();
                }
            });
        }
        
        //ground
        //const ground = BABYLON.MeshBuilder.CreateGround("ground", {height: 6, width: 10, subdivisions: 4});
        
        scene.onPointerDown = (evt, pickInfo) => {
            if (hitTest && anchors && xr.baseExperience.state === BABYLON.WebXRState.IN_XR) {
                anchors.addAnchorPointUsingHitTestResultAsync(hitTest);
                marker.isVisible = false;

                dock1.position.z = marker.position.z;
                dock1.position.x = marker.position.x - 0.6;
                dock1.position.y = 2;

                dock2.position.z = marker.position.z;
                dock2.position.x = marker.position.x - 0.3;
                dock2.position.y = 2;

                dock3.position.z = marker.position.z;
                dock3.position.x = marker.position.x ;
                dock3.position.y = 2;
                
                dock4.position.z = marker.position.z;
                dock4.position.x = marker.position.x + 0.3;
                dock4.position.y = 2;
                
                dock5.position.z = marker.position.z;
                dock5.position.x = marker.position.x + 0.6;
                dock5.position.y = 2;
                
                root.position.x = marker.position.x;
                root.position.z = marker.position.z;
                root.position.y = 0;
                
                //ground.position.x = b.position.x;
                //ground.position.z = b.position.z;
                
                
                //var totalX = 0;var totalZ = 0;
                for(var y=1;y< wallNumber;y = y + 1){
	                eval('box_' + y + '.position.x = box_' + y + '.position.x - box_0.position.x + marker.position.x;');
	                eval('box_' + y + '.position.z = box_' + y + '.position.z - box_0.position.z + marker.position.z;');
	                eval('box_' + y + '.position.y = 0.08;');
	                eval('box_' + y + '.isVisible = true;');
	                
	                
	                //eval('totalX = totalX + box_' + y + '.position.x;');
	                //eval('totalZ = totalZ + box_' + y + '.position.z;');
                }
                //totalX = totalX/wallNumber;totalZ = totalZ/wallNumber;
                
                //ground
                //ground.position.x = totalX;ground.position.z = totalZ;ground.position.y = 0;
/*                
                
                
                /*
                btpanel.position.x = b.position.x;
                btpanel.position.z = b.position.z;
                btpanel.position.y = b.position.y;
                btpanel.visibility = 1;
                bt1.position.x = btpanel.position.x + 0.75;
                bt1.position.y = btpanel.position.y -0.9;
                //bt1.position.z = btpanel.position.z - 0.5;
                bt2.position.x = btpanel.position.x -0.15;
                bt2.position.y = btpanel.position.y-0.9;
                //bt2.position.z = btpanel.position.z - 0.5;
                bt3.position.x = btpanel.position.x - 1.25;
                bt3.position.y = btpanel.position.y-0.9;
                //bt3.position.z = btpanel.position.z - 0.5;
                bt1.visibility = 1;bt2.visibility = 1;bt3.visibility = 1;
                */
                
                if(endHitTest == 0){
	                panels.isVisible = true;
	                dock1.isVisible = true;
                    dock2.isVisible = true;
                    dock3.isVisible = true;
                    dock4.isVisible = true;
                    dock5.isVisible = true;
	            }
                endHitTest =1;
                
               
            }
        }
        
        // ---------- create walls (from database)
        
        var root = new BABYLON.TransformNode();
        //root.parent = b;
   <?php
	   
	   $bigX = 0;
	   $bigY = 0; 
	   $smallX = 0;
	   $smallY = 0;
	   
	  $cnt = 0;	
	  $amp = 1;                 
      $result = mysqli_query($dblink,"select x1,y1,x2,y2,roomname,id from maps where roomname='5' order by id  ");
      while($row = mysqli_fetch_row($result)){
	     echo drawWall($row[0],$row[1],$row[2],$row[3],$cnt,$amp);
	     $cnt = $cnt + 1;
      }
      
      echo "var wallNumber = ".$cnt;
     
   ?>
   //--------- end create walls
   
    
    
        
   
        

        return scene;
        
        
    
    };
        
        
        
        
        window.initFunction = async function() {
                    
           var asyncEngineCreation = async function() {
                        try {
                        return createDefaultEngine();
                        } catch(e) {
                        console.log("the available createEngine function failed. Creating the default engine instead");
                        return createDefaultEngine();
            }
        }

                    window.engine = await asyncEngineCreation();
        if (!engine) throw 'engine should not be null.';
        window.scene = createScene();};
        initFunction().then(() => {scene.then(returnedScene => { sceneToRender = returnedScene; });
            
            engine.runRenderLoop(function () {
                if (sceneToRender && sceneToRender.activeCamera) {
                    sceneToRender.render();
                }
            });
        });

        // Resize
        window.addEventListener("resize", function () {
            engine.resize();
        });
    </script>
</body>
</html>
<?php
	
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
        $out = $out.'box_'.$cnt.'.parent = root;';
        $out = $out.'box_'.$cnt.'.isVisible = false;';
        return($out);	
	}  
	
?>
