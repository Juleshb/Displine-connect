<?php
session_start();

session_unset();
session_destroy();

header("Location: pages/sign-in.html");
exit();
?>
