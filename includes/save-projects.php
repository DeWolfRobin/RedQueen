<?php
// if (isset($_GET["remove"])) {
//   unset($parsed_json[$_GET["remove"]]);
// }
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST as $key => $value) {
    $keyar = explode("-",$key);
    $nr = $keyar[1];
    $jkey = $keyar[0];
    if ($jkey == "active" && $value == "on") {
      $_SESSION["currentproject"] = $nr;
    }
    $projects[$nr][$jkey] = $value;
  }
  echo var_dump($projects);
  $fp = fopen('../projects.json', 'w');
  fwrite($fp, json_encode($projects));
  fclose($fp);
  header("Location: /?view=settings");
}



 ?>
