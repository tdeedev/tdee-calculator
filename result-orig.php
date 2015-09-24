<?php

require_once('./includes/functions.php');
$isValid = array();
$isValid['system'] = $isValid['gender'] = $isValid['age'] = $isValid['weight'] = $isValid['height'] = $isValid['activity'] = '';


if(isset($_GET['f']) && $_GET['f'] == 1 ) {

	require_once('./includes/validate.php');
	//require_once('./includes/functions.php');
	
	$system      = $_GET['s'];

	// Check the form submits to see if they are valid or expected types
	// isValid array items will contain 1 for true or blank for false
	$isValid['system']   = isSystemValid($_GET['s']);
	$isValid['gender']   = isGenderValid($_GET['g']);
	$isValid['age']      = is_numeric($_GET['age']);
	$isValid['activity'] = isActivityValid($_GET['act']);
	
	if($system == 'imperial'){
	  $isValid['weight']   = is_numeric($_GET['lbs']);
	  $isValid['height']   = isHeightValid($_GET['in']);
	} else {
		$isValid['weight']   = is_numeric($_GET['kg']);
	  $isValid['height']   = is_numeric($_GET['cm']);
	}
	
	//foreach($isValid as $name => $value){
	//	echo $name . ': ' . $value . '<br>';
	//} die;


	// If any values are false, it will fail this test and set errors to true
	// If any items returned false, they will be blank and will not be === 1
	if(count(array_unique($isValid)) === 1){
		$errors = false;
	} else {
		header("Location: /?error=true");
	}
	
	

	if(!$errors){
	
		require_once('./includes/Mobile_Detect.php');
		$detect = new Mobile_Detect;
 
		// Any mobile device (phones or tablets).
		if ( $detect->isMobile() ) {
 			$platform = 'mobile';
		} else {
			$platform = 'desktop';
		}
	
		// these variables don't change from imperial to metric, so set them here
		
		$gender      = $_GET['g'];
		$age         = $_GET['age'];
		$activity    = $_GET['act'];
		
		if($system == 'imperial'){
			$lbs = $_GET['lbs'];
			$kg  = $lbs * 0.453592; // convert lbs to kg
			$in  = $_GET['in'];
			$cm = $in * 2.54;
		}
		
		if($system == 'metric'){
			$kg = $_GET['kg'];
			$lbs = $kg * 2.20462; // convert kg back to lbs
			$cm = $_GET['cm'];
			$in = $_GET['cm'] * 0.393701;
		}
		
		$in_to_ft = array(55 => "4 feet 7 inches", 56 => "4 feet 8 inches", 57 => "4 feet 9 inches", 58 => "4 feet 10 inches", 59 => "4 feet 11 inches", 60 => "5 feet 0 inches", 61 => "5 feet 1 inch", 62 => "5 feet 2 inches", 63 => "5 feet 3 inches", 64 => "5 feet 4 inches", 65 => "5 feet 5 inches", 66 => "5 feet 6 inches", 67 => "5 feet 7 inches", 68 => "5 feet 8 inches", 69 => "5 feet 9 inches", 70 => "5 feet 10 inches", 71 => "5 feet 11 inches", 71 => "5 feet 11 inches", 72 => "6 feet 0 inches", 73 => "6 feet 1 inch", 74 => "6 feet 2 inches", 75 => "6 feet 3 inches", 76 => "6 feet 4 inches", 77 => "6 feet 5 inches", 78 => "6 feet 6 inches", 79 => "6 feet 7 inches", 80 => "6 feet 8 inches", 81 => "6 feet 9 inches", 82 => "6 feet 10 inches", 83 => "6 feet 11 inches", 84 => "7 feet 0 inches");
		
		$act_to_english = array('1.2' => 'being <strong>Sedentary</strong>', '1.375' => 'doing <strong>Light Exercise</strong>', '1.55' => 'doing <strong>Moderate Exercise</strong>', '1.725' => '<strong>Heavy Exercise</strong>', '1.9' => "working out like an <strong>Athlete</strong>");
		
		// Do BMI Calculation
		$bmi = BMI($kg, $cm);
		$bmiround = round($bmi);
		
		$country = @$_SERVER['GEOIP_COUNTRY_CODE'];
		$state = @$_SERVER['GEOIP_REGION'];
		
		//if($country == 'US'){
		//	$conn = new mysqli('localhost', 'tdeeuser', 'vD8pPNRyxRpEABnfay7kxF', 'tdee_bmi_stats');
		//	$stmt = $conn->prepare("INSERT INTO statistics (gender, age, weightlbs, heightin, bmi, country, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		//	$stmt->bind_param("siiiiss", $gender, $age, $lbs, $in, $bmiround, $country, $state);
		//	$stmt->execute();
		//	$stmt->close();
		//	$conn->close();
		//}

	} else { $error = true; }

} else {
	header("Location: /?error=true");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TDEE Result</title>
	<meta name="description" content="Your TDEE results">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="icon" href="/favicon.ico">
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->
	<style>
	.hide{display:none;}
	@media (max-width: 568px) {
		h3.h3{
			font-size:20px;
		}
		img#eatstopeatimg{display:block;}
	}
	</style>
</head>
<body>


<?php include_once('./includes/navbar.php'); ?>


<div class="container">

	<div class="result">
		
		<div class="clearfix">
			<div class="pull-left"><h1 class="h2">YOUR STATS</h1></div>
			<div class="questions hidden-xs"><small><em>Questions or comments?</em> Email me at <a href="#">rob@tdeecalculator.net</a></small></div>
		</div>
		
		<p class="stats">You are a <strong><?php echo $age; ?></strong> year old <strong><?php echo $gender; ?></strong> who is <strong><?php if($system == 'imperial') { echo $in_to_ft[$in]; } else { echo $cm . ' cm'; } ?></strong> tall and weighs <strong><?php if($system == 'imperial') { echo $lbs . ' lbs'; } else { echo $kg . ' kg';} ?></strong> while <?php echo $act_to_english[$activity]; ?>.</p>
		
		<hr class="style2">

		<p class="h3" style="margin-top:0;margin-bottom:8px;text-indent:1%;font-size:21px;"><small>Your</small> TDEE <small>to Maintain Weight</small></p>
		
		<?php
			// AVAILABLE VARIABLES
			// $system (either equal to imperial or metric)
			// $gender
			// $age
			// $activity 
			// $lbs
			// $kg
			// $in
			// $cm
		?>
		
		<div class="row">

			<div class="col-sm-4" style="padding-top:10px;">
			
				
				<?php
				// function Mifflin($system, $gender, $kg, $cm, $age, $activity = 1)
				$cals_per_day = Mifflin($system, $gender, $kg, $cm, $age, $activity);
				?>
				
				<div id="cal-best-estimate">
					<div style="padding-top:25px;"><span class="h2"><?php echo Pretty($cals_per_day); ?></span><br> <span class="cals">calories per day</span></div>
					<hr>
					<div><span class="h2"><?php echo Pretty($cals_per_day * 7); ?></span><br> <span class="cals">calories per week</span></div>
				</div>
			
			</div>
			
			<div class="col-sm-8">

				<p>Based on your stats, the best estimate for your maintenance calories is <strong><?php echo Pretty($cals_per_day); ?></strong> calories per day based on the Mifflin St-Jeor formula (which I believe to be the most accurate).</p>
				<table class="table table-condensed">
					<tr>
					<td>Basal Metabolic Rate</td>
					<td><?php echo Pretty(Mifflin($system, $gender, $kg, $cm, $age, 1)); ?> calories/day</td>
					</tr>
					<tr<?php if($activity == 1.2){ echo ' class="success"';} ?>>
					<td>Sedentary</td>
					<td><?php echo Pretty(Mifflin($system, $gender, $kg, $cm, $age, 1.2)); ?> calories/day</td>
					</tr>
					<tr<?php if($activity == 1.375){ echo ' class="success"';} ?>>
					<td>Light Exercise</td>
					<td><?php echo Pretty(Mifflin($system, $gender, $kg, $cm, $age, 1.375)); ?> calories/day</td>
					</tr>
					<tr<?php if($activity == 1.55){ echo ' class="success"';} ?>>
					<td>Moderate Exercise</td>
					<td><?php echo Pretty(Mifflin($system, $gender, $kg, $cm, $age, 1.55)); ?> calories/day</td>
					</tr>
					<tr<?php if($activity == 1.725){ echo ' class="success"';} ?>>
					<td>Heavy Exercise</td>
					<td><?php echo Pretty(Mifflin($system, $gender, $kg, $cm, $age, 1.725)); ?> calories/day</td>
					</tr>
					<tr<?php if($activity == 1.9){ echo ' class="success"';} ?>>
					<td>Athlete</td>
					<td><?php echo Pretty(Mifflin($system, $gender, $kg, $cm, $age, 1.9)); ?> calories/day</td>
					</tr>
	
				</table>
			</div>

		</div>
		
		
	<div class="row">
		
		<div class="col-sm-6">
			<h2 class="h3">Ideal Body Weight</h2>
			<p>Your ideal body weight is estimated to be <?php echo Pretty(IBW_Devine($gender, $in, $system)); ?> <?php if($system == 'imperial'){ echo 'lbs';} else { echo 'kg'; } ?> based on the B.J. Devine Formula (1974), which I believe to be the most accurate. The formulas are based on your height, so if you have more muscle than the average person then the estimation will seem low. </p>
			
			
			<div class="well2">
			<table class="clean-unstyled">
			<tr>
			<td class="text-right">G.J. Hamwi Formula (1964):</td>
			<td class="bold"><?php echo Pretty(IBW_Hamwi($gender, $in, $system)); ?> <?php if($system == 'imperial'){ echo 'lbs';} else { echo 'kg'; } ?></td>
			</tr>
			
			<tr>
			<td class="text-right">B.J. Devine Formula (1974):</td>
			<td class="bold"><?php echo Pretty(IBW_Devine($gender, $in, $system)); ?> <?php if($system == 'imperial'){ echo 'lbs';} else { echo 'kg'; } ?></td>
			</tr>
			
			<tr>
			<td class="text-right">J.D. Robinson Formula (1983):</td>
			<td class="bold"><?php echo Pretty(IBW_Robinson($gender, $in, $system)); ?> <?php if($system == 'imperial'){ echo 'lbs';} else { echo 'kg'; } ?></td>
			</tr>
			
			<tr>
			<td class="text-right">D.R. Miller Formula (1983):</td>
			<td class="bold"><?php echo Pretty(IBW_Miller($gender, $in, $system)); ?> <?php if($system == 'imperial'){ echo 'lbs';} else { echo 'kg'; } ?></td>
			</tr>
			</table>
			</div>
			
		</div>
		
		<div class="col-sm-6">
			<h2 class="h3">Your BMI: <?php echo Pretty($bmi, 1); ?></h2>
			<p>Your <strong>BMI</strong> is <strong><?php echo Pretty($bmi, 1); ?></strong>, which means you are classified as <strong><?php echo BMI_Classification($bmi); ?></strong>. 
			<?php if($gender == 'male'){
				$link = "http://www.amazon.com/gp/product/0982522738/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=0982522738&linkCode=as2&tag=tdeecalc-20&linkId=QB642YMGBM4PXNPP";
			} else {
				$link = "http://www.amazon.com/gp/product/1628600543/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=1628600543&linkCode=as2&tag=tdeecalc-20&linkId=2J5KS2UG7MRWCQOX";
			} ?>
			Based on your BMI and body-type, I recommend <a target="_blank" href="<?php echo $link; ?>">this book on Amazon</a> (opens in new window).

			</p>

			
			<table class="table table-condensed">
				  	<tbody>
				  	<tr<?php if($bmi < 18.5){ echo ' class="success"';} ?>>
				  		<td>18.5 or less</td>
				  		<td>Underweight</td>
				  	</tr>
				  	<tr<?php if($bmi >= 18.5 && $bmi < 25){ echo ' class="success"';} ?>>
				  		<td>18.5 &ndash; 24.99</td>
				  		<td>Normal Weight</td>
				  	</tr>
				  	<tr<?php if($bmi >= 25 && $bmi < 30){ echo ' class="success"';} ?>>
				  		<td>25 &ndash; 29.99</td>
				  		<td>Overweight</td>
				  	</tr>
				  	<tr<?php if($bmi >= 30){ echo ' class="success"';} ?>>
				  		<td>30+</td>
				  		<td>Obese</td>
				  	</tr>
				  	</tbody>
				  </table>
		</div>
	
	</div> <!-- end row -->
	
	<div class="row">
		<div class="col-sm-12">
		
			<a onclick="clicky.goal( '3468', null, 1 ); clicky.pause( 500 );" rel="nofollow" href="downloads/The_DIRTY_DOZEN_20.pdf">
			<img src="images/The_DIRTY_DOZEN.jpg" alt=""<?php if($platform == 'desktop'){echo ' class="pull-left"';} ?>>
			</a>
			
			<h3 class="h3" style="margin-top:0;">THE DIRTY DOZEN: The 12 Most Obsessive Compulsive Eating Habits and How to Break Them</h3>
		
			<p>If you have problems sticking to diets and all the "rules" of healthy eating, then read this report by Brad Pilon called "THE DIRTY DOZEN: The 12 Most Obsessive Compulsive Eating Habits and How to Break Them".</p>
		
			<h4 class="h4"><a onclick="clicky.goal( '3468', null, 1 ); clicky.pause( 500 );" rel="nofollow" href="downloads/The_DIRTY_DOZEN_20.pdf"><i class="fa fa-file-pdf-o"></i> Download Now (1.7 MB)</a></h4>
		
		</div> <!-- end col-sm-12 -->
	</div>
		


</div> <!-- end .result -->

</div> <!-- end .container -->




		
<?php include_once('./includes/footer.php'); ?>




</body>
</html>