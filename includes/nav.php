<!--
  Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
-->
<?php if (isset($_GET["view"])){$v = $_GET["view"];} else {$v = "";} ?>
<?php if (isset($_GET["sub"])){$sub = $_GET["sub"];} else {$sub = "";} ?>
<div class="sidebar-wrapper">
  <ul class="nav">
    <li <?php if ($v == "" OR $v == "dashboard") {  echo 'class="active"';} ?>>
      <a href="/">
        <i class="tim-icons icon-chart-pie-36"></i>
        <p>Dashboard</p>
      </a>
    </li>
    <li <?php if ($v == "settings") {  echo 'class="active"';} ?>>
      <a href="/?view=settings">
        <i class="tim-icons icon-settings-gear-63"></i>
        <p>Settings</p>
      </a>
    </li>
    <li <?php if ($v == "cc") {  echo 'class="active"';} ?>>
      <a href="/?view=cc">
        <i class="tim-icons icon-laptop"></i>
        <p>Command & Control</p>
      </a>
      <ul style="list-style-type:none;">
        <li <?php if ($sub == "network-discovery") {  echo 'class="active"';} ?>>
          <a href="/?view=cc&sub=network-discovery">
            <i class="tim-icons icon-vector"></i>
            <p>Network discovery</p>
          </a>
        </li>
        <li <?php if ($sub == "files") {  echo 'class="active"';} ?>>
          <a href="/?view=cc&sub=files">
            <i class="tim-icons icon-single-copy-04"></i>
            <p>File explorer</p>
          </a>
        </li>
        <li <?php if ($sub == "console") {  echo 'class="active"';} ?>>
          <a href="/?view=cc&sub=console">
            <i class="tim-icons icon-double-right"></i>
            <p>Console</p>
          </a>
        </li>
        <li <?php if ($sub == "network-overview") {  echo 'class="active"';} ?>>
          <a href="/?view=cc&sub=network-overview">
            <i class="tim-icons icon-bullet-list-67"></i>
            <p>Network Overview</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>
