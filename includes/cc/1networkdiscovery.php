<pre><?php
if (isset($_POST["network-discovery"])) {
  $name = $controller->getActiveProject()->getName();
  $kali->exec($controller,"mkdir '/home/user/$name'");
  $logname = str_replace(" ","_",$_POST["log"]);
  $range = str_replace("\r\n"," ",$_POST["range"]);
  // echo $kali->exec($controller,"nmap -n -sS -oG - '".$_POST["range"]."' | awk '/Up$/{print $2}' | uniq | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4 > '/home/user/$name/$logname.log'");
  echo $kali->exec($controller,"nmap -n -sS -oG '/home/user/$name/$logname.log' ".$range." ");
  // $ips = $kali->exec($controller,"cat '/home/user/$name/$logname.log' | awk '/Up$/{print $2}' | uniq | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4");
  // $ips = preg_split('/$\R?^/m', $ips);
  // foreach ($ips as $i) {
  //   $kali->exec($controller,"nmap -O -sV $i > '/home/user/$name/$i'");
  // }
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
