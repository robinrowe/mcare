<html>
	<head>
		  <meta charset="utf-8">
  
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils@0.1/control_utils.css" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="demo.css" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils@0.1/camera_utils.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils@0.1/control_utils.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils@0.1/drawing_utils.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands@0.1/hands.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r67/three.min.js"></script>
<style>
			
		</style>
	</head>
	<body>
		<span id="quadrado" style="z-index:9999999;top:100px;left:100px;position: absolute;width:100px;height:100px;background-color: red;color:yellow"></span>
		x<span id="valorx" style="z-index:9999999;top:20px;left:100px;position: absolute;color: white"></span>
		y<span id="valory" style="z-index:9999999;top:40px;left:100px;position: absolute;color: white"></span>
		z<span id="valorz" style="z-index:9999999;top:60px;left:100px;position: absolute;color: white"></span>
		dist<span id="distancia" style="z-index:9999999;top:80px;left:100px;position: absolute;color: white"></span>
		gesto<span id="gesto" style="z-index:99999999;top:100px;left:10px;position: absolute;color: white"></span>
		<div class="container">
    <video class="input_video" style="z-index: 1"></video>
    <canvas class="output_canvas" width="1280px" height="720px" style="z-index: 1"></canvas>
    <div class="loading">
      <div class="spinner"></div>
      <div class="message">
        Loading
      </div>
    </div>
        
  </div>
  <div class="control-panel" style="display:none">
  </div>
  <script>
	  
	  
	  // Our input frames will come from here.
const videoElement =
    document.getElementsByClassName('input_video')[0];
const canvasElement =
    document.getElementsByClassName('output_canvas')[0];
const controlsElement =
    document.getElementsByClassName('control-panel')[0];
const canvasCtx = canvasElement.getContext('2d');

// We'll add this to our control panel later, but we'll save it here so we can
// call tick() each time the graph runs.
const fpsControl = new FPS();

// Optimization: Turn off animated spinner after its hiding animation is done.
const spinner = document.querySelector('.loading');
spinner.ontransitionend = () => {
  spinner.style.display = 'none';
};

function onResults(results) {
  // Hide the spinner.
  document.body.classList.add('loaded');

  // Update the frame rate.
  fpsControl.tick();

  // Draw the overlays.
  canvasCtx.save();
  canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
  canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);
  if (results.multiHandLandmarks && results.multiHandedness) {
    for (let index = 0; index < results.multiHandLandmarks.length; index++) {
      const classification = results.multiHandedness[index];
      const isRightHand = classification.label === 'Right';
      const landmarks = results.multiHandLandmarks[index];
      drawConnectors(
          canvasCtx, landmarks, HAND_CONNECTIONS,
          {color: isRightHand ? '#00FF00' : '#FF0000'});
      drawLandmarks(canvasCtx, landmarks, {
        color: isRightHand ? '#00FF00' : '#FF0000',
        fillColor: isRightHand ? '#FF0000' : '#00FF00'
      });
      //indicador direito
      console.log(landmarks);
      var posicaox = Math.round(landmarks[8]['x']*1920);
      var posicaoy = Math.round(landmarks[8]['y']*619);
      var posicaoz = Math.round(landmarks[8]['z']*619);
      document.getElementById('valorx').innerHTML = posicaox;
      document.getElementById('valory').innerHTML = posicaoy
      document.getElementById('valorz').innerHTML = posicaoz;
      
      //polegar direito
      var cateto1 = ((landmarks[8]['x']*1000) - (landmarks[4]['x']*1000)) * ((landmarks[8]['x']*1000) - (landmarks[4]['x']*1000));
      var cateto2 = ((landmarks[8]['y']*1000) - (landmarks[4]['y']*1000)) * ((landmarks[8]['y']*1000) - (landmarks[4]['y']*1000));
      var distancia = Math.round(Math.sqrt(cateto1 + cateto2));
      document.getElementById('distancia').innerHTML = distancia;
      
      if(distancia < 60	){
	      document.getElementById('gesto').innerHTML = "pinch";
      }else{
	      document.getElementById('gesto').innerHTML = "";
      }
      
      posquadx = document.getElementById('quadrado').style.left;
      
      if ( (posicaox > 100)  && (posicaox  < 200)  && (posicaoy  > 100)   && (posicaoy < 200) )    {
	      document.getElementById('quadrado').innerHTML = "dentro";
      }else{
	      document.getElementById('quadrado').innerHTML = "fora";
      }
      
    }
  }
  canvasCtx.restore();
}

const hands = new Hands({locateFile: (file) => {
  return `https://cdn.jsdelivr.net/npm/@mediapipe/hands@0.1/${file}`;
}});
hands.onResults(onResults);

/**
 * Instantiate a camera. We'll feed each frame we receive into the solution.
 */
const camera = new Camera(videoElement, {
  onFrame: async () => {
    await hands.send({image: videoElement});
  },
  width: 1280,
  height: 720
});
camera.start();

// Present a control panel through which the user can manipulate the solution
// options.
new ControlPanel(controlsElement, {
      selfieMode: true,
      maxNumHands: 2,
      minDetectionConfidence: 0.5,
      minTrackingConfidence: 0.5
    })
    .add([
      new StaticText({title: 'MediaPipe Hands'}),
      fpsControl,
      new Toggle({title: 'Selfie Mode', field: 'selfieMode'}),
      new Slider(
          {title: 'Max Number of Hands', field: 'maxNumHands', range: [1, 4], step: 1}),
      new Slider({
        title: 'Min Detection Confidence',
        field: 'minDetectionConfidence',
        range: [0, 1],
        step: 0.01
      }),
      new Slider({
        title: 'Min Tracking Confidence',
        field: 'minTrackingConfidence',
        range: [0, 1],
        step: 0.01
      }),
    ])
    .on(options => {
      videoElement.classList.toggle('selfie', options.selfieMode);
      hands.setOptions(options);
    });

	  </script>
	  
	 
	</body>
</html>