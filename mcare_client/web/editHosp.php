<?php
	
// editHosp.php
// Created by Miguel Ribeiro 2021-08-25
// MIT Open Source


$name = "";$city = "";$country = "";$lat = "";$lon = "";$gmaps = "";$id = "";
if(isset($_GET['id'])){ 
   $id = clean($_GET['id']);
   $result = mysqli_query($dblink,"select name,country,city,latitude,longitude,gmaps from locals where id='".$id."'");
   while($row = mysqli_fetch_row($result)){
      $name = $row[0];
      $country = $row[1];
      $city = $row[2];
      $lat = $row[3];
      $lon = $row[4];
      $gmaps = $row[5];
   }
}



?>
<div class="container">
   <div class="row">
      <div class="col s12">
         <div class="card " style="background-color:<?php echo $cardcolor;?>">
            <div class="card-content black-text">
               <span class="card-title <?php echo $titlecolor;?>">Hospital detail</span>
                  <div class="row">
                     <form class="col s12" action="saveLocal.php" method="post">
                        <div class="row">
                           <div class="input-field col s8">
                              <i class="material-icons prefix <?php echo $icongrey;?>">local_hospital</i>
                              <input  id="name" name="name" value="<?php echo $name;?>" type="text" class="validate">
                              <label for="name">Name</label>
                           </div>
                           <div class="input-field col s4">
                               <select name="localCountry" id="localCountry">
                                  <option value="" disabled selected>Choose your option</option>
                                  <?php
                                  $resultc = mysqli_query($dblink,"select name from countries order by name");
                                  while($rowc = mysqli_fetch_row($resultc)){
                                     echo "<option ";
                                     if($country == $rowc[0]) echo " selected ";
                                     echo "value='".$rowc[0]."'>".$rowc[0]."</option>";
                                  }
                                  ?>
                               </select>
                               <label>Country</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s6">
                              <i class="material-icons prefix <?php echo $icongrey;?>">location_city</i>
                              <input  id="city" name="city" value="<?php echo $city;?>" type="text" class="validate">
                              <label for="city">City</label>
                           </div>
                           <div class="input-field col s3">
                              <i class="material-icons prefix <?php echo $icongrey;?>">location_on</i>
                              <input  id="latitude" name="latitude" value="<?php echo $lat;?>" type="text" class="validate">
                              <label for="latitude">Latitude</label>    
                           </div>
                           <div class="input-field col s3">
                              <i class="material-icons prefix <?php echo $icongrey;?>">location_on</i>
                              <input  id="longitude" name="longitude" value="<?php echo $lon;?>" type="text" class="validate">
                              <label for="longitude">Longitude</label> 
                              <input type="hidden" name="idLocal" value="<?php echo $id;?>">
                           </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                               <i class="material-icons prefix <?php echo $icongrey;?>">location_searching</i>
                               <input  id="gmaps" name="gmaps" value="<?php echo $gmaps;?>" type="text" class="validate">
                               <label for="gmaps">Google Maps</label>    
                            </div>
                            <div class="col s12">
                                <?php
                                   if($lat != "" && $lon !="" && $gmaps !=""){ 
                                       echo'<iframe id="map" src="'.$gmaps.'" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
                                   }
                                ?>
                                <br><br>
                                <button class="btn waves-effect waves-light botoes" type="submit" name="action">Save local<i class="material-icons right">send</i></button>
                            </div>
                        </div>
                     </form>
                  </div>
                  <span class="card-title <?php echo $titlecolor;?>">Buildings on this local <?php if($id != "") {echo'<a class="tooltipped" href="index.php?p=4&local='.$id.'" data-position="bottom" data-tooltip="Add new record"><i class="material-icons '.$iconcolor.'">add_box</i></a>';}?></span>
                  <div class="row">
                     <div class="col s12">
                         <table class="grey-text" >
                            <thead>
                               <tr>
                                  <th></th>
                                  <th class="<?php echo $tableheadertext;?>">Name</th>
                                  <th class="<?php echo $tableheadertext;?>">Level</th>
                                  <th class="<?php echo $tableheadertext;?>"></th>
                               </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            $result_p = mysqli_query($dblink,"select id,name,x,y,rot,lvl from plants where local = '".$id."'");
                            while($row_p = mysqli_fetch_row($result_p)){
                               $id_p = $row_p[0];
                               $name_p = $row_p[1];
                               $xcoord_p = $row_p[2];
                               $ycoord_p = $row_p[3];
                               $rotation_p = $row_p[4];
                               $level_p = $row_p[5];
                                $cnt = $cnt + 1;
                               echo "<tr><td><a class='tooltipped' href='index.php?p=4&local=".$id."&id=".$id_p."' data-position='bottom' data-tooltip='Edit record'><i class='material-icons ".$iconwhite."'>edit</i></a>&nbsp;<a class='tooltipped' href='../mapper/start.php?room=".$id_p."' data-position='bottom' data-tooltip='Manage map'><i class='material-icons ".$iconwhite."'>photo_library</i></a></td><td>".$name_p."</td><!--<td>".$xcoord_p."</td><td>".$ycoord_p."</td><td>".$rotation_p."</td>--><td>".$level_p."</td><td><a class='tooltipped' href='deletePlant.php?id=".$id_p."' data-position='bottom' data-tooltip='Delete record'><i class='material-icons ".$iconwhite."'>delete</i></a></td></tr>";
                            }
                            if($cnt == 0) echo "<tr><td colspan='6'>There are no divisions created for this local</td></tr>";
            
                            ?>
                            </tbody>
                        </table>
                     </div>
                  </div>
              </div>
          </div>
       </div>
   </div>
</div>