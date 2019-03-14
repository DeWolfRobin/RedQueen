<?php
$vms = $controller->getVMs();
$projects = $controller->getProjects();
if (isset($_GET["remove"])) {
  unset($vms[$_GET["remove"]]);
}
if (isset($_GET["remove-project"])) {
  unset($projects[$_GET["remove-project"]]);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET["add"])) {
    $add = $_GET["add"];
    for ($i=0; $i < $add; $i++) {
      $vms[sizeof($vms)] = new VM();
    }
  }
  if (isset($_GET["add-project"])) {
    $addp = $_GET["add-project"];
    for ($i=0; $i < $addp; $i++) {
      $projects[sizeof($projects)] = new Project();
    }
  }
  if (isset($_POST["projects"])) {
      foreach ($_POST as $key => $value) {
        $keyar = explode("-",$key);
        $nr = $keyar[1];
        $jkey = $keyar[0];
        if ($nr !== null) {
          if ($jkey == "active" && $value == "on") {
            $controller->setActiveProject($projects[$nr]);
          } else {
            $projects[$nr]->setFromPost("active", false);
          }
          $projects[$nr]->setFromPost($jkey, $value);
        }
      }
  } else {
    foreach ($_POST as $key => $value) {
      $keyar = explode("-",$key);
      $nr = $keyar[1];
      $jkey = $keyar[0];
        if ($jkey == "local" && $value == "on") {
          $vms[$nr]->setFromPost("local", true);
        } else {
          $vms[$nr]->setFromPost("local", false);
        }
      $vms[$nr]->setFromPost($jkey,$value);
    }
  }
}
$controller->setProjects(...$projects);
$controller->setVMs(...$vms);
//save
file_put_contents('settings.conf', serialize($controller));
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
          <form action="/?view=settings" method="post">
          <?php
            foreach ($projects as $key => $project) {
              ?>
              <div class="project">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Name</label>
                    <input class="form-control" type="text" name="name-<?php echo $key; ?>" value="<?php echo $project->getName(); ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <a href="/?view=settings&remove-project=<?php echo $key; ?>" class="tim-icons icon-trash-simple" style="float:right;"></a>
                      <label>Stealth</label>
                    <input class="form-control" type="number" name="stealth-<?php echo $key; ?>" value="<?php echo $project->getStealth(); ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="active-<?php echo $key; ?>">Active?</label>
                    <input class="check" type="checkbox" onclick="CheckClicked(this)" name="active-<?php echo $key; ?>" <?php if ($project->isActive()) {
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
          <input name="projects" type="submit" class="btn btn-fill btn-primary" value="Save"/>
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
          <form method="post" class="form" action="/?view=settings">
<?php
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
          <label for="path-<?php echo $c;?>">*.vmx location</label>
          <input name="path-<?php echo $c;?>" type="text" class="form-control" placeholder="/Path/To/*.vmx" value="<?php echo $value->getPath(); ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="ip-<?php echo $c;?>">Ip address</label>
          <input name="ip-<?php echo $c;?>" type="text" class="form-control" placeholder="0.0.0.0" value="<?php echo $value->getIP(); ?>">
        </div>
      </div>
      <div class="col-md-3">
        <label for="local-<?php echo $c; ?>">Local?</label>
        <input class="check" type="checkbox" name="local-<?php echo $c; ?>" <?php if ($value->isLocal()) {
          echo "checked";
        } ?>/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr class="divider">
      </div>
    </div>
  </div>
    <?php
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
