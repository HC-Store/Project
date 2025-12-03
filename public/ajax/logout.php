<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
session_unset();
session_destroy();
header("Location: /project/public/home.php");
