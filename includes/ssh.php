<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../assets/phpsec');
include('Net/SSH2.php');

$json_file = file_get_contents("../settings.json");
$parsed_json = json_decode($json_file, true);

$id = $_GET['id'];
if (isset($_GET['ip'])) {
  $parsed_json[$id]['ip'] = $_GET["ip"];
}
$ssh = new Net_SSH2($parsed_json[$id]["ip"]);
if (!$ssh->login($parsed_json[$id]["sshuser"], $parsed_json[$id]["sshpass"])) {
    exit('Login Failed');
}
//shell_exec("ssh ".$parsed_json[$id]["sshuser"]."@".$parsed_json[$id]["ip"]);
?><pre style="color:white;"><?php
if (isset($_POST["cmd"])) {
  echo $ssh->exec($_POST["cmd"]);
}
?>
</pre>
<form class="" action="ssh.php?id=<?php echo $_GET["id"]; ?><?php if (isset($_GET["ip"])) {
  echo "&ip=".$_GET["ip"];
} ?>" method="post">
  <input id="cmd" type="text" name="cmd" value="" autofocus>
  <input type="submit" name="" value="send">
</form>
