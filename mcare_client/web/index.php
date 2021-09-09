<?php
	
// index.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

include("db.php");

$p = 1;
if(isset($_GET['p'])) $p = clean($_GET['p']);


$result = mysqli_query($dblink,"select theme from settings");
while($row = mysqli_fetch_row($result)){
   $theme = $row[0];
}


?>
<!DOCTYPE html>
<html>
   <head>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
      <script src="https://unpkg.com/aframe-orbit-controls@1.2.0/dist/aframe-orbit-controls.min.js"></script> 
      <script src="https://unpkg.com/aframe-supercraft-loader@1.1.3/dist/aframe-supercraft-loader.js"></script> 
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       <script>
           
       function gotoVideo(sec){
           var vid = document.getElementById("videolidar");
           vid.currentTime = sec;
       }
       function capture(){
           var canvas = document.getElementById('canvas');
           var video = document.getElementById('video');
           canvas.width = video.videoWidth;
           canvas.height = video.videoHeight;
           canvas.getContext('2d').drawImage(video,0,0,video.videoWidth,video.videoHeight);
           var image = canvas.toDataURL();
           document.getElementById('hidden_data').value = image;
           
          
           var fd = new FormData(document.forms["form1"]);
           var xhr = new XMLHttpRequest();
           xhr.open('POST', 'saveImage.php', true);
           xhr.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                 if(xhr.responseText == "1"){
                     alert("Image submited with success");
                     location.reload();
                 }
              }
           };
           xhr.send(fd);
       }
           
       function goProcess(){
          var dst = "process.php?id=" + actualImgId;
           document.getElementById('preloader').style.display = "block";
           window.location = dst;
       }
       var actualImgId = "";
       function useImg(img,type,imgId){
           if(type == 1){
              document.getElementById('video').src = img;
              document.getElementById('link1').style.display = 'block';
              document.getElementById('video').style.display = 'block';
              document.getElementById('link2').style.display = 'none';
              document.getElementById('videoimage').style.display = 'none';
           }else{
              document.getElementById('videoimage').src = img;
              document.getElementById('link1').style.display = 'none';
              document.getElementById('video').style.display = 'none';
              document.getElementById('link2').style.display = 'block';
              document.getElementById('videoimage').style.display = 'block';
              actualImgId = imgId;
           }
       }
       </script>
       <style>
           .cinza{
               color:#D0D3D5;
               
           }
           .botoes{
               background-color:#45494B;
               color:#BCBFC1;
               font-size: 10px;
           }
           .titulo{
               font-size:18px;
               color:#BCBFC1;
           }
           
           .row .input-field input:focus {
              border-bottom: 1px solid #0072BB !important;
              box-shadow: 0 1px 0 0 #0072BB !important
           }
          
           ul.dropdown-content.select-dropdown li span {
               color: #0072BB; 
           }
           
           .botoes:hover {
              background-color: #0072BB;
               color:white;
           }
           
       </style>
       
   
    <?php
    
    if($theme == "dark"){
        $menucolor = "#333333";
        $bodycolor = "#111315";
        $cardcolor = "#3C3E45";
        $titlecolor = "white-text";
        $tableheadertext = "white-text";
        $tabletext = "grey-text";
        $iconcolor = "white-text";
        $icongrey = "grey-text";
        $iconwhite = "white-text";
        $logo = "logobranco.png";
        
        echo'<style>
            .input-field input[type=text] {color: #ffffff;}
           .input-field input[type=text]:focus {color: #ffffff;}
           .input-field label {color: #bbbbbb;}
           .input-field input:focus + label {color: #ffffff !important;}</style>';
    }else{
        echo'<style>
            .input-field input[type=text] {color: #333333;}
           .input-field input[type=text]:focus {color: #333333;}
           .input-field label {color: #bbbbbb;}
           .input-field input:focus + label {color: #333333 !important;}</style>';
        
        $menucolor = "#0072BB";
        $bodycolor = "#CCCCCC";
        $cardcolor = "#FFFFFF";
        $titlecolor = "black-text";
        $tableheadertext = "black-text";
        $tabletext = "black-text highlight";
        $iconcolor = "blue-text";
        $icongrey = "black-text";
        $iconwhite = "black-text";
        $logo = "logowho.jpg";
    }
    
    
    ?>
   </head>
   <body style="background-color:<?php echo $bodycolor;?>">
      <div id="preloader"  class="preloader-wrapper big active blue" style="position:absolute;left:50%;top:150px;z-index:9999999999;display:none">
         <div class="spinner-layer spinner-yellow-only">
            <div class="circle-clipper left">
               <div class="circle"></div>
            </div>
            <div class="gap-patch">
               <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
               <div class="circle"></div>
            </div>
         </div>
      </div>
      <nav>
         <div class="nav-wrapper " style="background-color:<?php echo $menucolor;?>">
            <a href="index.php" class="brand-logo">&nbsp;&nbsp;&nbsp;<img src="<?php echo $logo;?>" height="60"></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
               <li><a class='tooltipped'  data-tooltip='Locals' href="index.php?p=1"><i class="large material-icons white-text">local_hospital</i></a></li>
               <li><a class='tooltipped'  data-tooltip='Users' href="collapsible.html"><i class="large material-icons white-text">people</i></a></li>
               <li><a class='tooltipped'  href='changeTheme.php?theme=light' data-tooltip='Light theme' href="collapsible.html"><i class="large material-icons white-text">settings</i></a></li>
               <li><a class='tooltipped'  href='changeTheme.php?theme=dark' data-tooltip='Dark theme' href="collapsible.html"><i class="large material-icons grey-text">settings</i></a></li>
               <li><a class='tooltipped'  data-tooltip='Exit' href="mobile.html"><i class="large material-icons white-text">exit_to_app</i></a></li>
            </ul>
          </div>
      </nav>
      <ul class="sidenav" id="mobile-demo">
          <li><a href="index.php?p=1"><i class="large material-icons black-text">local_hospital</i></a></a></li>
          <li><a href="badges.html"><i class="large material-icons black-text">people</i></a></li>
          <li><a href="collapsible.html"><i class="large material-icons black-text">settings</i></a></li>
          <li><a href="mobile.html"><i class="large material-icons black-text">exit_to_app</i></a></li>
      </ul>
      <br>
       <?php
        if($p == "1"){
           include("hospList.php");
        }else if($p == "2"){
           scaleDB();
           include("varios.php");
        }else if($p == "3"){
           include("editHosp.php");
        }else if($p == "4"){
           include("editPlant.php");
        }else if($p == "5"){
           include("manage.php");
        }
       ?>

   <footer class="page-footer" style="background-color:#222222">
       <div class="container">
          <div class="row">
              <div class="col l6 s12">
                 <h5 class="white-text">Game Content Simulation</h5>
                 <p class="grey-text text-lighten-1">Automatic Plant Creation Tool</p>
              </div>
              <div class="col l4 offset-l2 s12">
                 <h5 class="white-text">Links</h5>
                 <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Manage Locals</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Manage Users</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Settings</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Logout</a></li>
                 </ul>
              </div>
           </div>
        </div>
        <div class="footer-copyright">
           <div class="container">© 2021 Who Academy<a class="grey-text text-lighten-4 right" href="#!"></a></div>
        </div>
   </footer>

        
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         var elems = document.querySelectorAll('.tooltipped');
         var instances = M.Tooltip.init(elems);
         var elems2 = document.querySelectorAll('select');
         var instances = M.FormSelect.init(elems2);
         var elems3 = document.querySelectorAll('.materialboxed');
         var instances = M.Materialbox.init(elems3);
         var elems4 = document.querySelectorAll('.tabs');
         var instance = M.Tabs.init(elems4);
      });
   </script>
</body>
</html>
