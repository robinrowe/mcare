<?php
	
// editPlant.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source

$id = "";
$local = "";
if(isset($_GET['id'])) $id = clean($_GET['id']);
if(isset($_GET['local'])) $local = clean($_GET['local']);

$name_p = "";
$x_p = "";
$y_p = "";
$rot_p = "";
$lvl_p = "";

$result_p = mysqli_query($dblink,"select name,x,y,rot,lvl from plants where id='".$id."'");
while($row_p = mysqli_fetch_row($result_p)){
   $name_p = $row_p[0];
   $x_p = $row_p[1];
   $y_p = $row_p[2];
   $rot_p = $row_p[3];
   $lvl_p = $row_p[4];
}

$result_l = mysqli_query($dblink,"select name from locals where id='".$local."'");
while($row_l = mysqli_fetch_row($result_l)){
   $localName = $row_l[0];
}

?>
<div class="container">
   <div class="row">
      <div class="col s12">
         <div class="card " style="background-color:<?php echo $cardcolor;?>">
            <div class="card-content black-text">
               <span class="card-title <?php echo $titlecolor;?>">Building detail<?php if($id !="") echo " for ".$localName;?></span>
                  <div class="row">
                     <form class="col s12" action="saveDivision.php" method="post">
                        <div class="row">
                           <div class="input-field col s12">
                              <i class="material-icons prefix <?php echo $icongrey;?>">domain</i>
                              <input  id="name" name="name" value="<?php echo $name_p;?>" type="text" class="validate">
                              <label for="name">Name</label>
                           </div>
                           <div class="input-field col s3">
                              <i class="material-icons prefix <?php echo $icongrey;?>">location_city</i>
                              <input  id="lvl" name="lvl" value="<?php echo $lvl_p;?>" type="text" class="validate">
                              <label for="lvl">Floor</label>
                                <input type="hidden" name="local" value="<?php echo $local;?>">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                           </div>
                         </div>
                         <div class="row">
                            &nbsp;&nbsp;&nbsp;<button class="btn waves-effect waves-light botoes" type="submit" name="action">Save division<i class="material-icons right">send</i></button>
                         </div>
                     </form>
                  </div>
              </div>
          </div>
       </div>
   </div>
</div>