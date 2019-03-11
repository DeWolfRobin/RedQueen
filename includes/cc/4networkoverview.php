<?php
$ip = trim(shell_exec("vmrun getGuestIPAddress '".$parsed_json[1]["vmx"]."'"),"\n");
$catfile = "";
if (isset($_GET["file"])) {
  $catfile = file_get_contents("http://".$ip."/?cmd=cat%20".urlencode($_GET["file"]).urlencode(" | awk '{print $2}'| uniq | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4"));
  $catfile = preg_split('/$\R?^/m', $catfile);
}
?>

<form class="" method="get">
  <input type="hidden" name="view" value="cc">
  <input type="hidden" name="sub" value="network-overview">
  <select class="" name="file">
    <?php
      $files = file_get_contents("http://".$ip."/?cmd=ls%20/home/user/$name/*.log");
      $files = preg_split('/$\R?^/m', $files);
      foreach ($files as $file) {
        ?>
        <option value="<?php echo trim($file,"\n"); ?>"><?php echo $file; ?></option>
        <?php
      }
    ?>
  </select>
  <input type="submit" class="btn btn-fill btn-primary" value="Open">
</form>
<div class="row">
<?php
foreach ($catfile as $i) {
  $OS= file_get_contents("http://".$ip."/?cmd=cat%20/home/user/$name/$i".urlencode(" | awk '/Running/ {print $2}'"));
  $ports = file_get_contents("http://".$ip."/?cmd=cat%20/home/user/$name/$i".urlencode(" | awk '/\/t/'"));
  $ports = preg_split('/$\R?^/m', $ports);
?>
  <div class="col-md-4">
    <h6><?php echo $i; ?></h6>
    <img width="100px" src='/assets/img/<?php if (trim($OS,"\n") == "Linux") {
        echo "linux";
      }else {
        echo "question";
      } ?>.png'>
      <?php
      foreach ($ports as $port) {
        if ($port !== "") {
        echo "<pre style='white-space:pre-wrap;'>".$port."</pre>";
        }
      }
      ?>
  </div>

<?php
}
?>
</div>
