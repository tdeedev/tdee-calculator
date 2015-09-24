<?php
// http://09d74dtymtu2108og7-ruktq4b.hop.clickbank.net/?tid=TDEE2A
// http://www.mb103.com/lnk.asp?o=6710&c=74903&a=40025&s2=tdee

// $ip = $_SERVER['REMOTE_ADDR'];
$age = htmlspecialchars($_GET['a']);

header("Location: http://09d74dtymtu2108og7-ruktq4b.hop.clickbank.net/?tid=TDEE{$age}");