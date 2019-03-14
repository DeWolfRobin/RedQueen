<?php
if ((isset($_GET["id"])) AND ($controller->getVMs()[$_GET["id"]] !== null)) {
  $id = $_GET["id"];
} else {
  require_once '404.php';
  die();
}

$status = "offline";
$vm = $controller->getVMs()[$id];
  if (isset($_POST["snapshot"])) {
    echo $vm->revertToSnapshot($controller, $_POST["snapshot"]);
  }
  if (isset($_POST["start"])) {
    echo $vm->startVM($controller);
  }
  if (isset($_POST["stop"])) {
    echo $vm->stopVM($controller);
  }
  // $vms = shell_exec("vmrun list");
  // $vmaray = preg_split('/$\R?^/m', $vms);
  foreach ($controller->getActiveVMs() as $key => $VM) {
    if ($VM == $vm) {
      $status = "running";
    }
  }
?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="title">Details of <?php echo $vm->getName() ?></h5>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                <h6><?php echo $vm->getName() ?> - <?php echo $status; ?></h6>
                <p><?php echo $vm->getDescription() ?></p>
                <?php if ($status == "running"): ?>
                  <?php echo $vm->getScreenshot($controller, $id);?>
                    <h6>Restore a snapshot</h6>
                    <form class="" method="post">
                      <div class="form-group">
                      <select class="" name="snapshot" class="form-control">
                        <?php
                          foreach ($vm->getSnapshots($controller) as $key => $value) {
                            ?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php
                          }
                        ?>
                      </select>
                    </div>
                    <input class="btn btn-fill btn-primary" type="submit" value="Restore">
                    </form>
                <?php endif; ?>
                <form class="" action="" method="post">
                  <?php
                  if ($status == "running") {
                    ?><input type="submit" name="stop" value="stop" class="btn btn-primary"><?php
                  } else {
                    ?><input type="submit" name="start" value="start" class="btn btn-primary"><?php
                  }
                  ?>
                </form>
            </div>
            <div class="col-md-6">
              <img src="../assets/img/<?php echo htmlentities($id); ?>.png" class="card-img-top" alt="Image of the vm">
            </div>
          </div>
          <div class="row">

      </div>
      </div>
      <div class="card-footer">
        <!-- <button type="submit" class="btn btn-fill btn-primary" onclick="document.forms[0].submit();">Save</button> -->
      </div>
    </div>
  </div>
</div>
