<?php
session_start();
session_destroy();
header("Location: ../livre-or/index.php");
?>