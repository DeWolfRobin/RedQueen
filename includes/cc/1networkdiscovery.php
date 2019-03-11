<pre><?php
$ip = trim(shell_exec("vmrun getGuestIPAddress '".$parsed_json[1]["vmx"]."'"),"\n");
if (isset($_POST["network-discovery"])) {
  //check which one is the kali first!!!
  shell_exec("$basecommand \"echo '".$_POST["range"]."'>temp.conf\"");
  shell_exec("$basecommand \"mkdir /home/user/$name\"");
  $logname = str_replace(" ","_",$_POST["log"]);
  echo shell_exec("$basecommand \"nmap -n -sS -iL temp.conf -oG - | awk '/Up$/{print $2}' | uniq | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4 > /home/user/$name/$logname.log\"");
  $ips = file_get_contents("http://".$ip."/?cmd=cat%20/home/user/$name/$logname.log".urlencode("| awk '/Up$/{print $2}' | uniq | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4"));
  $ips = preg_split('/$\R?^/m', $ips);
  foreach ($ips as $i) {
    shell_exec("$basecommand \"nmap -O -sV $i > /home/user/$name/$i\"");
  }
}
?>
</pre>
    <form class="" action="" method="post">
    <div class="row">
      <div class="col-md-6">
        <h6 id="network-discovery">Network discovery</h6>
          <div class="form-group">
          <label for="range">Ip range</label>
          <textarea class="form-control" name="range" rows="4" cols="80"></textarea>
          </div>
          <input required type="submit" class="btn btn-fill btn-primary" name="network-discovery" value="Start">
      </div>
      <div class="col-md-6">
        <div class="form-group">
        <label for="log">Log name</label>
        <input required type="text" class="form-control" name="log" placeholder="file">
        </div>
      </div>
    </div>
    </form>
