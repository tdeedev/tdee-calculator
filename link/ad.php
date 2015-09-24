<?php

// http://7a74e5sbfv062xd5savhx8r09z.hop.clickbank.net/?tid=TDEE2
// http://www.mb104.com/lnk.asp?o=7948&c=918273&a=40025&s2=tdee

// $ip = $_SERVER['REMOTE_ADDR'];
$age = htmlspecialchars($_GET['a']);

header("Location: http://7a74e5sbfv062xd5savhx8r09z.hop.clickbank.net/?tid=TDEE{$age}");