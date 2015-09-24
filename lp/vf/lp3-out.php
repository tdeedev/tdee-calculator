<?php
  
  // ------------------------------------------------------------------- 
  //
  // Tracking202 PHP Redirection, created on Fri Aug, 2015
  //
  // This PHP code is to be used for the following landing page.
  // http://tdeecalculator.net/lp/vf/lp3.php
  //                       
  // -------------------------------------------------------------------
  
  if (isset($_COOKIE['tracking202outbound'])) {
	$tracking202outbound = $_COOKIE['tracking202outbound'];     
  } else {
	$tracking202outbound = 'http://www.trk.tdeecalculator.net/tracking202/redirect/lp.php?lpip=143&pci='.$_COOKIE['tracking202pci'];
  }
  
  header('location: '.$tracking202outbound);
  
?>