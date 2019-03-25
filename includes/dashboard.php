<?php
$vmsstored = $controller->getVMs();
  if (isset($_GET["action"])&&isset($_GET["vm"])) {
    $activeVM = $vmsstored[$_GET["vm"]];
    $action = $_GET['action'];
    $vm = str_replace(" ", "\ ", $activeVM->getPath());
    if (isset($_GET["snapshot"])) {
      echo $activeVM->revertToSnapshot($controller, htmlentities($_GET["snapshot"]));
    }
    if ($action == "start") {
      $activeVM->startVM($controller);
    } elseif ($action == "stop") {
      $activeVM->stopVM($controller);
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
            echo $controller->getActiveTitle();
            ?></h2>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <?php
            foreach ($controller->getActiveVMs() as $key => $vm) {
                echo $vm->getScreenshot($controller, $key);
                ?>
                <div class="card" style="width: 18rem;float:left; margin-left:15px;">
                  <img src="../assets/img/<?php echo $key; ?>.png" class="card-img-top" alt="Image of the vm">
                  <div class="card-body">
                <?php
                echo '<h5 class="card-title">'.$vm->getName().'</h5><p class="card-text">'.$vm->getDescription().'</p>';
                $vm->setIP(shell_exec("vmrun getGuestIPAddress '".$vm->getPath()."'"));
                echo $vm->getIP();
                $firstsnapshot = $vm->getSnapshots($controller)[1];
                $lastsnapshot = $vm->getSnapshots($controller)[sizeof($vm->getSnapshots($controller))-1];
                echo '<p class="card-text"><a href="/?vm='.$key.'&action=snapshot&snapshot=1">Reset to '.$firstsnapshot.'</a></p>';
                echo '<p class="card-text"><a href="/?vm='.$key.'&action=snapshot&snapshot='.(sizeof($vm->getSnapshots($controller))-1).'">Reset to '.$lastsnapshot.'</a></p>';
                ?>
                <p class="card-text"><a href="//<?php echo $vm->getIP()."/?user=".urlencode($vm->getRootUser())."&password=".urlencode(hash("sha256",$vm->getRootPass())); ?>">Open webconsole</a></p>
                <a href="/?view=details&id=<?php echo $key; ?>" class="btn btn-primary">Details</a>
                <a href="/?action=stop&vm=<?php echo $key;?>" class="btn btn-secondary">Turn off</a>

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
          foreach ($vmsstored as $key => $value) {
            $vm = $vmsstored[$key];
            ?>
            <div class="card" style="width: 18rem;float:left; margin-left:15px;">
              <img src="../assets/img/<?php echo $key; ?>.png" class="card-img-top" alt="Image of the vm">
              <div class="card-body">
                <h5 class="card-title"><?php
                  echo $vm->getName();
                ?></h5>
                <p class="card-text"><?php echo $vm->getDescription(); ?></p>
                <small><?php
                  echo "(".$vm->getPath().")";
                ?></small><p>
                <?php
                  if ((!in_array($vm->getPath()."\n",$controller->getActiveVMs())) AND (!in_array($vm->getPath(),$controller->getActiveVMs()))) {
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
