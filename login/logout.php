<?php
session_start();
$_SESSION['login'] = "";
header('location: ../index.php');