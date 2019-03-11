<?php
session_start();
$json_file = file_get_contents("settings.json");
$parsed_json = json_decode($json_file, true);

$projects_file = file_get_contents("projects.json");
$projects = json_decode($projects_file, true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    Red Team Infrastructure Manager
  </title>
  <link href="assets/css/poppins.css" rel="stylesheet" />
  <link href="assets/css/fontawesome.css" rel="stylesheet">
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar">
      <?php
        require_once 'includes/nav.php';
      ?>
    </div>
    <div class="main-panel">
      <?php require_once 'includes/nav-top.php'; ?>
      <div class="content">
        <?php
        if (isset($_GET["view"])) {
          $v = $_GET["view"];
          switch ($v) {
            case "ssh":
              ?><iframe src="includes/ssh.php?id=<?php echo $_GET["id"]; ?><?php if (isset($_GET["ip"])) {
                echo "&ip=".$_GET["ip"];
              } ?>" frameborder=0 scrolling="no" width="100%" height="100%" style="height:85vh;"></iframe><?php
              break;
            case "settings":
              require_once 'includes/settings.php';
              break;
            case "details":
              require_once 'includes/details.php';
              break;
            case "cc":
              require_once 'includes/cc.php';
              break;
            default:
              require_once 'includes/404.php';
              break;
          }
        } else {
          require_once 'includes/dashboard.php';
        }
        require_once 'includes/footer.php';
         ?>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/black-dashboard.js?v=1.0.0"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>
</body>

</html>