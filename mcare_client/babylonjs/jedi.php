<?php
	
// jedi.php
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

        const fm = xr.baseExperience.featuresManager;
        const xrTest = fm.enableFeature(BABYLON.WebXRHitTest.Name, "latest");
        const anchors = fm.enableFeature(BABYLON.WebXRAnchorSystem.Name, 'latest');
        
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
        
        
        var wallNumber = 0;
        
        const painel = BABYLON.MeshBuilder.CreatePlane("plane", {height:2000, width: 2000});
        var materialp = new BABYLON.StandardMaterial(scene);
        materialp.alpha = 1;
        materialp.diffuseColor = new BABYLON.Color3(0, 0, 0);
        painel.material = materialp;
        painel.isVisible = false;
        painel.position.z = 10;
        
        scene.onPointerDown = (evt, pickInfo) => {
            if (hitTest && anchors && xr.baseExperience.state === BABYLON.WebXRState.IN_XR) {
                anchors.addAnchorPointUsingHitTestResultAsync(hitTest);
                marker.isVisible = false;

                root.position.x = marker.position.x;
                root.position.z = marker.position.z;
                root.position.y = 0;
                
                //var totalX = 0;var totalZ = 0;
                for(var y=1;y< wallNumber;y = y + 1){
	                eval('box_' + y + '.position.x = box_' + y + '.position.x - box_0.position.x + marker.position.x;');
	                eval('box_' + y + '.position.z = box_' + y + '.position.z - box_0.position.z + marker.position.z;');
	                eval('box_' + y + '.position.y = 0.08;');
	                eval('box_' + y + '.isVisible = true;');
	            }
                                
                if(endHitTest == 0){
	                painel.isVisible = true;
	                
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
