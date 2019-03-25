<?php
require_once 'includes/classes/commands.php';
require_once 'includes/classes/vm.php';
require_once 'includes/classes/project.php';
session_start();

$load = file_get_contents('settings.conf');
if ($load !== null) {
  $controller = unserialize($load);
} else {
  $controller = CommandHandler::getInstance();
}

?>
