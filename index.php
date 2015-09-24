<?php

$isValid = array();
$isValid['system'] = $isValid['gender'] = $isValid['age'] = $isValid['weight'] = $isValid['height'] = $isValid['activity'] = '';

if(isset($_GET['error']) && $_GET['error'] == 'true'){
	$error = true;
	} else {
	$error = false;
	}

if(isset($_POST['submit'])) {

	require_once('./includes/validate.php');

	// Check the form submits to see if they are valid or expected types
	// isValid array items will contain 1 for true or blank for false
	$isValid['system']   = isSystemValid($_POST['system']);
	$isValid['gender']   = isGenderValid($_POST['gender']);
	$isValid['age']      = is_numeric($_POST['age']);
	$isValid['weight']   = is_numeric($_POST['weight']);
	$isValid['height']   = is_numeric($_POST['height']);
	$isValid['activity'] = isActivityValid($_POST['activity']);
	
	// If any values are false, it will fail this test and set errors to true
	// If any items returned false, they will be blank and will not be === 1
	if(count(array_unique($isValid)) === 1){ $errors = false; } else { $errors = true; }

	if(!$errors){
	
		// these variables don't change from imperial to metric, so set them here
		$system      = $_POST['system'];
		$gender      = $_POST['gender'];
		$age         = $_POST['age'];
		$activity    = $_POST['activity'];
		
		if($system == 'imperial'){
			$lbs = $_POST['weight'];
			$in  = $_POST['height'];
			header("Location: result.php?s=imperial&g=$gender&age=$age&lbs=$lbs&in=$in&act=$activity&f=1");
		}
		
		if($system == 'metric'){
			$kg = $_POST['weight'];
			$cm = $_POST['height'];
			header("Location: result.php?s=metric&g=$gender&age=$age&kg=$kg&cm=$cm&act=$activity&f=1");
		}

	} else { $error = true; }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TDEE Calculator: Learn Your Total Daily Energy Expenditure</title>
	<meta name="description" content="Accurate TDEE Calculator that tells you your Total Daily Energy Expenditure, which is a measure of how many calories per day your body burns.">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" href="/favicon.ico">
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->
</head>
<body>


<?php include_once('./includes/navbar.php'); ?>



<div class="container">

	<div class="jumbotron">
		
		<h2 class="text-center">Learn How Many Calories You Burn Every Day</h2>
		<p class="intro text-center"><strong>Use the TDEE calculator to learn your <em>Total Daily Energy Expenditure</em></strong>, a measure of how many calories you burn per day. This calculator will also display your <abbr title="Body Mass Index">BMI</abbr>, <abbr title="Basal Metabolic Rate">BMR</abbr> &amp; many other useful statistics!</p>
		
		<hr>
		
		<div class="row">
			<div class="col-sm-6">
				<?php include_once('./includes/form-home.php'); ?>
			</div>
			
			<div class="col-sm-6">
				<img src="images/muscle1.png" alt="" class="img-responsive" id="tdee">	
			</div>
		</div> <!-- end row -->
		
		<hr>
		<p class="text-center"><small>Questions? Email me at rob@tdeecalculator.net</small></p>
	
	</div> <!-- end .jumbotron -->


	<h3>How TDEE Is Calculated</h3>
	
	<img src="images/tdee-pie-chart.png" alt="" class="pull-right" width="300">
	
	<p>Your TDEE is an estimation of how many calories you burn per day. It is calculated by first figuring out your Basal Metabolic Rate, then multiplying that value by an activity multiplier.</p>
	
	<p>Since your BMR represents how many calories your body burns when at rest, it is necessary to adjust to account for the calories you burn during the day. This is true even for those with a sedentary lifestyle. Our TDEE calculator uses every known formula and displays your score in a way that's easy to read and meaningful.</p>



</div> <!-- end .container -->





		


<?php include_once('./includes/footer.php'); ?>



</body>
</html>