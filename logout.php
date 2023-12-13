<?php
session_start();
unset($_SESSION["user"]);
session_destroy();
unset($_COOKIE['loginId']);
unset($_COOKIE['loginPass']);
header("location:index.php");
?>