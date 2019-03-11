<?php
  if (isset($_GET["action"])&&isset($_GET["vm"])) {
    $action = $_GET['action'];
    $vm = str_replace(" ", "\ ", $parsed_json[$_GET["vm"]]["vmx"]);
    if (isset($_GET["option"])) {
      $option = $_GET["option"];
    }else {
      $option = "";
    }
    if (isset($_GET["option"])) {
      echo shell_exec("vmrun $action $vm \"$option\"");
    } else {
      echo shell_exec("vmrun $action $vm");
    }
  }
?>
<div class="row">
  <div class="col-12">
    <div class="card card-chart">
      <div class="card-header ">
        <div class="row">
          <div class="col-sm-6 text-left">
            <h2 class="card-title"><?php
            $vms = shell_exec("vmrun list");
            $vmaray = preg_split('/$\R?^/m', $vms);
            echo $vmaray[0];
            ?></h2>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <?php
            for ($i=1; $i <= sizeof($vmaray)-1; $i++) {
                  foreach ($parsed_json as $key => $value) {
                    if (($parsed_json[$key]["vmx"]."\n" == $vmaray[$i]) OR ($parsed_json[$key]["vmx"]  == $vmaray[$i])) {
                      if (isset($parsed_json[$key]["rootpass"])) {
                        shell_exec('vmrun -T ws -gu "'.$parsed_json[$key]["rootuser"].'" -gp "'.$parsed_json[$key]["rootpass"].'" captureScreen "'.$parsed_json[$key]["vmx"].'" "assets/img/'.$key.'.png"');
                      }
                      ?>
                      <div class="card" style="width: 18rem;float:left; margin-left:15px;">
                        <img src="../assets/img/<?php echo $key; ?>.png" class="card-img-top" alt="Image of the vm">
                        <div class="card-body">
                      <?php
                      echo '<h5 class="card-title">'.$parsed_json[$key]["name"].'</h5><p class="card-text">'.$parsed_json[$key]["description"].'</p>';
                      $parsed_json[$key]['ip'] = shell_exec("vmrun getGuestIPAddress '".$parsed_json[$key]["vmx"]."'");
                      echo $parsed_json[$key]['ip'];
                      $location = $parsed_json[$key]['vmx'];
                      $snapshots = shell_exec("vmrun listSnapshots \"$location\"");
                      $snapshots = preg_split('/$\R?^/m', $snapshots);
                      echo '<p class="card-text"><a href="/?action=revertToSnapshot&vm='.$key.'&option='.$snapshots[1].'">Reset to '.$snapshots[1].'</a></p>';
                      echo '<p class="card-text"><a href="/?action=revertToSnapshot&vm='.$key.'&option='.$snapshots[sizeof($snapshots)-1].'">Reset to '.$snapshots[sizeof($snapshots)-1].'</a></p>';
                      ?>
                      <p class="card-text"><a href="/?view=ssh&id=<?php echo $key; ?>&ip=<?php echo $parsed_json[$key]['ip']; ?>">Open ssh</a></p>
                      <a href="/?view=details&id=<?php echo $key; ?>" class="btn btn-primary">Details</a>
                      <a href="/?action=stop&vm=<?php echo $key;?>" class="btn btn-secondary">Turn off</a>
                      <?php
                    }
                  }
                  ?>
                  </div>
              </div>
              <?php
            }
          ?>
      </div>
    </div>
  </div>
</div>
<div class="col-12">
  <div class="card card-chart">
    <div class="card-header ">
      <div class="row">
        <div class="col-sm-6 text-left">
          <h2 class="card-title">All machines</h2>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="chart-area">
        <?php
          foreach ($parsed_json as $key => $value) {
            ?>
            <div class="card" style="width: 18rem;float:left; margin-left:15px;">
              <img src="../assets/img/<?php echo $key; ?>.png" class="card-img-top" alt="Image of the vm">
              <div class="card-body">
                <h5 class="card-title"><?php
                  echo $parsed_json[$key]["name"];
                ?></h5>
                <p class="card-text"><?php echo $parsed_json[$key]["description"]; ?></p>
                <small><?php
                  echo "(".$parsed_json[$key]["vmx"].")";
                ?></small><p>
                <?php
                  if ((!in_array($parsed_json[$key]["vmx"]."\n",$vmaray)) AND (!in_array($parsed_json[$key]["vmx"],$vmaray))) {
                    ?><a href="/?action=start&vm=<?php echo $key;?>" class="btn btn-primary">Turn on</a><?php
                  } else {
                    ?><a href="/?action=stop&vm=<?php echo $key;?>" class="btn btn-primary">Turn off</a><?php
                  }
                ?>
                <a style="float:right;" href="/?view=details&id=<?php echo $key;?>" class="btn btn-secondary">Details</a>
              </p>
              </div>
            </div>
            <?php
          }
        ?>
    </div>
  </div>
</div>
</div>
</div>
