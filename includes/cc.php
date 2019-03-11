<div class="card">
  <div class="card-header">
    <h5 class="title">Command & Control</h5>
  </div>
  <div class="card-body">
<?php
$basecommand = "vmrun -T ws -gu ".$parsed_json[1]["rootuser"]." -gp ".$parsed_json[1]["rootpass"]." runScriptInGuest '".$parsed_json[1]["vmx"]."' '/bin/bash'";
  if (isset($_GET["sub"])) {
    switch ($_GET["sub"]) {
      case 'network-discovery':
        require_once 'includes/cc/1networkdiscovery.php';
        break;
      case 'files':
        require_once 'includes/cc/2fileexplorer.php';
        break;
      case 'console':
        require_once 'includes/cc/3console.php';
        break;
      case 'network-overview':
        require_once 'includes/cc/4networkoverview.php';
        break;
      default:
        require_once 'includes/404.php';
        break;
    }
  } else {
    foreach (glob("includes/cc/*.php") as $filename) {
      require_once $filename;
    }
  }
?>
  </div>
  <div class="card-footer">
    <!-- <button type="submit" class="btn btn-fill btn-primary" onclick="document.forms[0].submit();">Save</button> -->
  </div>
</div>
