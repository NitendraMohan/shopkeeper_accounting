<?php
session_start();
include('db.inc.php');
include('functions.inc.php');
unset($_SESSION['IS_LOGIN']);
redirect('login.php');
?>