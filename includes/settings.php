<?php
$vms = $_SESSION["commandHandler"]->getVMs();
if (isset($_GET["remove"])) {
  unset($parsed_json[$_GET["remove"]]);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST as $key => $value) {
    $keyar = explode("-",$key);
    $nr = $keyar[1];
    $jkey = $keyar[0];
    $vms[$nr][$jkey] = $value;
  }
  $_SESSION["commandHandler"]->setVMs(...$vms);
  file_put_contents('settings.conf', serialize($_SESSION["commandHandler"]));
}

 ?>
 <script>
   function CheckClicked(t){
     var checks = $('.project .check');
     for (var i = 0; i < checks.length; i++) {
       if (checks[i] !== t) {
         checks[i].checked = false;
       }
       console.log(t.checked);
     }
   }
 </script>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Edit settings</h5>
        </div>
        <div class="card-body">
          <h4>Projects</h4>
          <form action="includes/save-projects.php" method="post">
          <?php
          if (isset($_GET["add-project"])) {
            $addp = $_GET["add-project"];
            for ($i=0; $i < $addp; $i++) {
              $projects[sizeof($projects)+1] = $projects[1];
            }
          }
            foreach ($projects as $p => $value) {
              ?>
              <div class="project">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Name</label>
                    <input class="form-control" type="text" name="name-<?php echo $p; ?>" value="<?php echo $projects[$p]["name"]; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Stealth</label>
                    <input class="form-control" type="number" name="stealth-<?php echo $p; ?>" value="<?php echo $projects[$p]["stealth"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="active-<?php echo $p; ?>">Active?</label>
                    <input class="form-controll check" type="checkbox" onclick="CheckClicked(this)" name="active-<?php echo $p; ?>" <?php if ($projects[$p]["active"] == "on") {
                      echo "checked";
                    } ?>/>
                  </div>
                </div>
              </div>
              <?php
            }
          ?>
          <div class="row">
            <div class="col-md-6">
          <input type="submit" class="btn btn-fill btn-primary" value="Save"/>
        </div>
        <div class="col-md-6">
          </form>
          <form style="float:right;" class="" action="/?view=settings&add-project=<?php $addp=1;if (isset($_GET["add-project"])) {
            $addp = $_GET["add-project"] + 1;
          } ;echo $addp;?>" method="post">
            <input class="btn btn-fill btn-secondary" type="submit" value="Add project"/>
        </form>
      </div>
      </div>
        <br><hr><br>
          <h4>VMs</h4>
          <form method="post" class="form" actions="/?view=settings">
<?php
  if (isset($_GET["add"])) {
    $add = $_GET["add"];
    for ($i=0; $i < $add; $i++) {
      $parsed_json[sizeof($parsed_json)+1] = $parsed_json[1];
    }
  }
  foreach ($vms as $key => $value) {
    $c = $key;
    ?>
    <div class="vm">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="name-<?php echo $c;?>">Name</label>
          <input name="name-<?php echo $c;?>" type="text" class="form-control" placeholder="Name" value="<?php echo $value->getName(); ?>">
        </div>
      </div>
      <div class="col-md-9">
        <a href="/?view=settings&remove=<?php echo $c; ?>" class="tim-icons icon-trash-simple" style="float:right;"></a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
        <label for="description-<?php echo $c;?>">Description</label>
        <textarea class="form-control" name="description-<?php echo $c;?>" rows="4" cols="80"><?php echo $value->getDescription(); ?></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="sshuser-<?php echo $c;?>">Ssh username</label>
          <input name="sshuser-<?php echo $c;?>" type="text" class="form-control" placeholder="User" value="<?php echo  $value->getSshUser(); ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="sshpass-<?php echo $c;?>">Ssh password</label>
          <input name="sshpass-<?php echo $c;?>" type="text" class="form-control" placeholder="Password" value="<?php echo  $value->getSshPass(); ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="rootuser-<?php echo $c;?>">Root username</label>
          <input name="rootuser-<?php echo $c;?>" type="text" class="form-control" placeholder="Root" value="<?php echo  $value->getRootUser(); ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="rootpass-<?php echo $c;?>">Root password</label>
          <input name="rootpass-<?php echo $c;?>" type="text" class="form-control" placeholder="Password" value="<?php echo  $value->getRootPass(); ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="vmx-<?php echo $c;?>">*.vmx location</label>
          <input name="vmx-<?php echo $c;?>" type="text" class="form-control" placeholder="/Path/To/*.vmx" value="<?php echo $value->getPath(); ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="ip-<?php echo $c;?>">Ip address</label>
          <input name="ip-<?php echo $c;?>" type="text" class="form-control" placeholder="0.0.0.0" value="<?php echo $value->getIP(); ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr class="divider">
      </div>
    </div>
  </div>
    <?php
    $c++;
  }

?>
          </form>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-fill btn-primary" onclick="document.forms[2].submit();">Save</button>
          <form style="float:right;" class="" action="/?view=settings&add=<?php $add=1;if (isset($_GET["add"])) {
            $add = $_GET["add"] + 1;
          } ;echo $add;?>" method="post">
            <button class="btn btn-fill btn-secondary" onclick="document.forms[3].submit();">Add vm</button>
          </form>
        </div>
      </div>
    </div>
  </div>
