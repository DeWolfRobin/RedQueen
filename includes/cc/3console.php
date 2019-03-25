<div class="row">
  <div class="col-md-12">
<pre><?php
if (isset($_GET["cmd"])) {
  echo $kali->exec($controller,$_GET["cmd"]);
}
?>
<pre>

<form class="" method="get">
  <div class="form-group">
  <input class="form-control" id="cmd" type="text" name="cmd" value="" autofocus>
  <input type="hidden" name="view" value="cc">
  <input type="hidden" name="sub" value="console">
</div>
</form>
</div>
</div>
