<?php
if ((isset($_GET["id"])) AND ($parsed_json[$_GET["id"]] != "")) {
  $id = $_GET["id"];
} else {
  require_once '404.php';
  die();
}

  $location = $parsed_json[$id]['vmx'];
  if (isset($_POST["snapshot"])) {
    echo shell_exec("vmrun revertToSnapshot '".$location."' '".$_POST["snapshot"]."'");
  }
  if (isset($_POST["status"])) {
    echo shell_exec("vmrun ".$_POST["status"]." '".$location."'");
  }
  $vms = shell_exec("vmrun list");
  $vmaray = preg_split('/$\R?^/m', $vms);
  $status = "offline";
  foreach ($vmaray as $key => $value) {
    if (($value == $parsed_json[$id]["vmx"]) OR ($value == $parsed_json[$id]["vmx"]."\n")) {
      $status = "running";
    }
  }
?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="title">Details of <?php echo $parsed_json[$id]["name"] ?></h5>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                <h6><?php echo $parsed_json[$id]["name"] ?> - <?php echo $status; ?></h6>
                <p><?php echo $parsed_json[$id]["description"] ?></p>
                <?php if ($status == "running"): ?>
                  <?php if (isset($parsed_json[$id]["rootpass"])) {
                    shell_exec('vmrun -T ws -gu "'.$parsed_json[$id]["rootuser"].'" -gp "'.$parsed_json[$id]["rootpass"].'" captureScreen "'.$parsed_json[$id]["vmx"].'" "assets/img/'.$id.'.png"');
                  } ?>
                    <h6>Restore a snapshot</h6>
                    <form class="" method="post">
                      <div class="form-group">
                      <select class="" name="snapshot" class="form-control">
                        <?php
                          $snapshots = shell_exec("vmrun listSnapshots \"$location\"");
                          $snapshots = preg_split('/$\R?^/m', $snapshots);
                          foreach ($snapshots as $key => $value) {
                            ?>
                              <option value="<?php echo trim($value,"\n"); ?>"><?php echo $value; ?></option>
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
                    ?><input type="submit" name="status" value="stop" class="btn btn-primary"><?php
                  } else {
                    ?><input type="submit" name="status" value="start" class="btn btn-primary"><?php
                  }
                  ?>
                </form>
            </div>
            <div class="col-md-6">
              <img src="../assets/img/<?php echo $id; ?>.png" class="card-img-top" alt="Image of the vm">
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
