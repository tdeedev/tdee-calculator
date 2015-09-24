<?php
// $gender = true;
// $age = true;
// $weight = true;
// $height = true;
// $activity = true;
// $bodyfat = true;
if(isset($_GET['error']) && $_GET['error'] == 'true'){
	$error = true;
	} else {
	$error = false;
	}

if(isset($_POST['submit'])) {

	require_once('./includes/validate.php');

	echo '<pre>';
	print_r($_POST);
	echo '</pre>';

	// Check the form submits to see if they are valid or expected types
	// isValid array items will contain 1 for true or blank for false
	$isValid = array();
	$isValid['system']   = isSystemValid($_POST['system']);
	$isValid['gender']   = isGenderValid($_POST['gender']);
	$isValid['age']      = is_numeric($_POST['age']);
	$isValid['weight']   = is_numeric($_POST['weight']);
	$isValid['height']   = is_numeric($_POST['height']);
	$isValid['activity'] = is_numeric($_POST['activity']);
	
	
	foreach($isValid as $name => $value){
		echo $name . ': ' .$value . '<br>';
	}
	



	

	if($_POST['system'] == 'imperial'){
		$system = 'imperial';
	} elseif($_POST['system'] == 'metric'){
		$system = 'metric';
	} else {
		$system = 0;
	}

	// Form will only submit if all variables have been filled out correctly
	// returning true or false doesnt seem to work right, so im returning 0 for false and 1 for true
	$gender   = $_POST['gender'] == 'male' || $_POST['gender'] == 'female' ? 1 : 0;
	$age      = !is_numeric($_POST['age']) ? 0 : 1;
	$weight   = !is_numeric($_POST['weight']) ? 0 : 1;
	$height   = $_POST['height'] == 0 || !is_numeric($_POST['height']) ? 0 : 1;
	$activity = $_POST['activity'] == 0 || !is_numeric($_POST['activity']) ? 0 : 1;
	if(isset($_POST['bodyfat'])){
	$bodyfat  = !is_numeric($_POST['bodyfat']) ? 0 : $_POST['bodyfat'];
	}
	//need to force bodyfat to be a 0 or the number itself

	if($gender && $age && $weight && $height && $activity && $system){
	
	  $gender   = $_POST['gender'];
	  $age      = $_POST['age'];
	  if($_POST['system'] == 'imperial'){
	  $kg       = $_POST['weight'] * 0.453592;
	  $cm       = $_POST['height'] * 2.54;
	  } else {
	  $kg       = $_POST['weight'];
	  $cm       = $_POST['height'];
	  }
	  $activity = $_POST['activity'];
	  //$goal     = $_POST['goal'];
	  if($_POST['bodyfat'] == 0){
	  $bodyfat  = 0;
	  } else {
	  $bodyfat  = $_POST['bodyfat'];
	  }
	  $m = $cm * 0.01;
	  $bmi = $kg / ($m * $m);

	  header("Location: result.php?gender=$gender&age=$age&kg=$kg&cm=$cm&activity=$activity&bodyfat=$bodyfat&sys=$system&bmi=$bmi");
	}	 else {
		
		$error = true;
		
	}

} else {
	// do nothing
}
?>