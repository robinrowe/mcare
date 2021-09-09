<!-- 
hospList.php
Created by Miguel Ribeiro 2021-08-25
MIT Open Source 
-->
<div class="container">
   <div class="row">
      <div class="col s12">
         <div class="card " style="background-color:<?php echo $cardcolor;?>">
            <div class="card-content white-text">
               <span class="card-title <?php echo $titlecolor;?>">Hospitals list <a class="tooltipped" href="index.php?p=3" data-position="bottom" data-tooltip="Add new record"><i class='material-icons <?php echo $iconcolor;?>'>add_box</i></a></span>
            </div>
            <table class="<?php echo $tabletext;?>" style="width:95%;margin-left:20px">
               <thead>
                  <tr>
                     <th></th>
                     <th class="<?php echo $tableheadertext;?>">Name</th>
                     <th class="<?php echo $tableheadertext;?>">Country</th>
                     <th class="<?php echo $tableheadertext;?>">City</th>
                     <th class="<?php echo $tableheadertext;?>">Lat</th>
                     <th class="<?php echo $tableheadertext;?>">Lon</th>
                     <th class="<?php echo $tableheadertext;?>"></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $result = mysqli_query($dblink,"select id,name,country,city,latitude,longitude from locals");
                  while($row = mysqli_fetch_row($result)){
                     $id = $row[0];
                     $name = $row[1];
                     $country = $row[2];
                     $city = $row[3];
                     $lat = $row[4];
                     $lon = $row[5];
                     echo "<tr><td><a class='tooltipped' href='index.php?p=3&id=".$id."' data-position='bottom' data-tooltip='Edit record'><i class='material-icons ".$iconwhite."'>edit</i></a></td><td>".$name."</td><td>".$country."</td><td>".$city."</td><td>".$lat."</td><td>".$lon."</td><td><a class='tooltipped' href='deleteLocal.php?id=".$id."' data-position='bottom' data-tooltip='Delete record'><i class='material-icons ".$iconwhite."'>delete</i></a></td></tr>";
                  }
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>