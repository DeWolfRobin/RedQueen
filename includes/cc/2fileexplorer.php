<?php

$ip = trim(shell_exec("vmrun getGuestIPAddress '".$parsed_json[1]["vmx"]."'"),"\n");
$vmrun = "vmrun -T ws -gu ".$parsed_json[1]["rootuser"]." -gp ".$parsed_json[1]["rootpass"];
$path = "/home/user/";
if (isset($_GET["path"])) {
  $path = $_GET["path"];
}
?>
<form class="" action="" method="get">
  <input type="hidden" name="view" value="cc">
  <input type="hidden" name="sub" value="files">
  <?php if (isset($_GET["file"])): ?>
  <input type="hidden" name="file" value="<?php echo $_GET["file"] ?>">
  <?php endif; ?>
  <div class="row">
    <div class="col-md-6">
      <h6 id="network-discovery">File explorer</h6>
      <label for="path">Path</label>
      <input required type="text" class="form-control" name="path" placeholder="/root/" value="<?php echo $path; ?>">
      <div class="files">
        <ul style="list-style-type:none;">
        <?php
        if (substr(rtrim($path), -1) != "/") {
          $path.="/";
        }
          $files = file_get_contents("http://".$ip."/?cmd=ls%20-la%20".urlencode($path)."%20|%20awk%20'/^-/%20{print%20$9}'");
          $files = preg_split('/$\R?^/m', $files);
          $dirs = file_get_contents("http://".$ip."/?cmd=ls%20-la%20".urlencode($path)."%20|%20awk%20'/^d/%20{print%20$9}'");
          $dirs = preg_split('/$\R?^/m', $dirs);
          foreach ($dirs as $dir) {
            echo "<li><a href='/?view=cc&sub=files&path=".$path.$dir."'><i class='tim-icons icon-single-copy-04'></i> ".$dir."</a></li>";
          }
          foreach ($files as $file) {
              echo "<li><a href='/?view=cc&sub=files&path=".$path."&file=".$file."'><i class='tim-icons icon-paper'></i> ".$file."</a></li>";
          }
        ?>
        </ul>
      </div>
      </div>
      <div class="col-md-6">
        <pre>
<?php
if (isset($_GET["file"])) {
  echo file_get_contents("http://".$ip."/?cmd=cat%20".urlencode($path).urlencode($_GET["file"]));
}
?>
</pre>
      </div>
  </div>
</form>
