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
	 .fix{
    position:fixed;
    bottom:0px;
    right:0;
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

				<p>Based on your stats, the best estimate for your maintenance calories is <strong><?php echo Pretty($cals_per_day); ?></strong> calories per day based on the Mifflin St-Jeor formula which is widely known to be the most accurate.</p>
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

		
	<?php if($gender == 'female'){ ?>
	
		<a rel="nofollow" target="_blank" class="clicky_log_outbound" href="http://trk.tdeecalculator.net/tracking202/redirect/dl.php?t202id=5157&c1=<?php echo $age; ?>yrs&c2=<?php echo number_format($bmi); ?>BMI&c3=<?php echo $platform; ?>&t202kw=placement1">
			<img src="images/mybikinibutt.gif" alt="" width="468" style="display:block;margin:-15px auto 20px;max-width:100%;">
	</a>
	
	<?php } ?>
	
	
		
	<div class="row">
		
		<div class="col-sm-6">
			<h2 class="h3">Ideal Body Weight</h2>
			<p>Your ideal body weight is <u>estimated</u> to be <?php echo Pretty(IBW_Devine($gender, $in, $system)); ?> <?php if($system == 'imperial'){ echo 'lbs';} else { echo 'kg'; } ?> based on the B.J. Devine Formula (1974), which is closest for me personally. The formulas are based on your height, so if you are bigger than the average person then the estimation will seem low. </p>
			
			
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
			<?php if($gender == 'female'){
				$link = "http://www.amazon.com/gp/product/1628600543/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=1628600543&linkCode=as2&tag=tdeecalc-20&linkId=2J5KS2UG7MRWCQOX";
			} elseif($gender == 'male' && $bmi > 30) {
				$link = "http://www.amazon.com/gp/product/1628600543/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=1628600543&linkCode=as2&tag=tdeecalc-20&linkId=2J5KS2UG7MRWCQOX";
			} else {
				$link = "http://www.amazon.com/gp/product/0982522738/ref=as_li_tl?ie=UTF8&camp=1789&creative=390957&creativeASIN=0982522738&linkCode=as2&tag=tdeecalc-20&linkId=QB642YMGBM4PXNPP";
			}
			?>
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
	
	<h2 class="h3 text-center" style="margin-top:3px;">Calorie Tracking Tools</h2>
			
			<p class="text-center">Here are the only 3 tools you need to start tracking your calories. If you enter everything you eat into MyFitnessPal, after 3 weeks you can determine your true TDEE by seeing how much weight you lost/gained!</p>
			
			<div class="row">
			
				<div class="col-sm-4">
				<h3 class="h4">Bathroom Scale</h3>
				<a href="http://amzn.to/1iGrWa7"><img class="img-responsive" src="images/bathroom-scale.jpg" alt="bathroom scale" width="" height="" /></a>
				<p><a href="http://amzn.to/1iGrWa7">$28.95 on Amazon</a></p>
				</div>
				
				<div class="col-sm-4">
				<h3 class="h4">Food Scale</h3>
				<a href="http://amzn.to/1Wbx5oP"><img class="img-responsive" src="images/food-scale.jpg" alt="Food scale" width="" height="" /></a>
				<p><a href="http://amzn.to/1Wbx5oP">$12.47 on Amazon</a></p>
				</div>
				
				<div class="col-sm-4">
				<h3 class="h4">MyFitnessPal</h3>
				<a href="https://www.myfitnesspal.com"><img class="img-responsive" src="images/myfitnesspal.jpg" alt="myfitnesspal" width="" height="" /></a>
				<p><a href="https://www.myfitnesspal.com">FREE on MyFitnesspal.com</a></p>
				</div>
			
			
			</div>

		
			<h2 class="h3 text-center">7 Simple Tips to Dramatically Improve Your Diet</h2>

			<ol>
			<li><strong>Learn to Read a Nutrition label</strong> - most people <em>look</em> at a nutrition label and <em>pretend</em> like they know what they are looking at. In reality, you do have to use your brain a little bit and do some basic calculations, but it's worth doing and becomes second nature very quickly, so don't give up. Also, some micronutrients like Potassium are <em>optional</em> fields on nutrition labels, so something as basic as a nutrition label does actually have some pitfalls.  <a href="https://www.youtube.com/watch?v=IswhmS4J5ac">Here's a decent video</a>.</li>
			
			<li><strong>Cut Out Sugar</strong> - sugar is basically the devil, that's why. You can have some ice cream or a soda once-a-week or whatever, but (for the most part) stop eating and drinking sugary snacks. This includes juices. Sugar is found in vegetables and other healthy foods too, so you'll have sugar in your diet regardless. It's amazing that Coca-Cola&reg; is one of the worlds most valuable brands, yet their product is basically poison. Diet Coke is a better choice, but it's best to just get over it and avoid it entirely. Here's a picture of somebody who read the label of a can of Coca-Cola&reg; and weighed out that much of sugar. <img class="img-responsive" src="images/sugar-cola.jpg" alt="Amount of sugar in soda" width="" height="" /></li>
			
			<li><strong>You Need to Eat More Veggies</strong> - Most people don't eat enough veggies, this is common knowledge. Since we all face the same dilemma, I have made this bag of vegetables (pictured below) the backbone of my diet. This bag also gives you 100% fiber for the day! It tastes good and it doesn't make me feel bloated and tired like so many other foods do (plus it's CHEAP). I steam a bag, mix with some olive oil and add some chicken/turkey so it's not so bland. I poop like a champion since making this the backbone of my diet. I eat the whole bag, which is only 360 calories, 18g of protein, 30g of fiber, and 60g of carbs (you deduct fiber from carbs, so it's actually only 30g of carbs). <img class="img-responsive" src="images/love-these-veggies.jpg" alt="I love this particluar brand of veggies" width="" height="" /></li>
			
			<li><strong>Cook With Olive Oil</strong> - I cook literally everything with olive oil. Mainly because I don't want the food to stick on the pan, but also because it tastes good and is one of the best sources of "healthy fats" and Omega 3's. We get plenty of Omega 6's in our diet, and the body needs a good Omega-3/Omega-6 ratio. Cooking with olive oil every day is literally the simplest way to bump up your Omega-3's.</li>
			
			<li><strong>Chicken/Turkey/Fish is Better Than Red Meat</strong> - Red meat has always been correlated with cancer and premature death in humans. While science doesn't yet quite know the truth, a study released in 2014 linked red-meat to having a particular kind of sugar which causes our immune system to have a toxic response. This news really sucks because we all love red meat. Just try to eat chicken more often than beef or steak, that's my advice. Stop getting cheeseburgers and start getting chicken burgers. <a href="http://www.telegraph.co.uk/news/health/news/11316316/Red-meat-triggers-toxic-immune-reaction-which-causes-cancer-scientists-find.html">Here's the news article on it</a>.</li>
			
			<li><strong>Bread Sucks</strong> - read the nutrition label on a loaf of bread. It is pure carbs with no redeeming qualities. You would have to eat like 20 pieces of bread to get your daily fiber, so that's not gonna work. <strong>Bread is only good if you are working out hard and want the carbs.</strong> I love bread and eat it all the time, but not everyday considering it's nutritional value is terrible. If you love sandwiches and you eat out alot, try ordering your burger without the bread and with a lettuce wrap instead (where the lettuce wrap acts like the bun). I actually think I like it better without the bread, try it next time!</li>
	
			<li><strong>Avoid Trans Fat At All Costs</strong> - If you know how to read a nutrition label, you can just look for it there, but just know that fast-food is usually where most people get their trans-fat from. Here's a short yet <a href="https://www.youtube.com/watch?v=Eo4Lrce5EiI">informational video on Youtube</a> explaining why trans fat are so bad.</li>
			</ol>
			
			<h3 class="h4">Final Thoughts</h3>
			<p>The ONLY reason losing weight can be difficult is because creating new habits is something people avoid and don't like doing. I get it, it's hard. You just have to mentally commit to cleaning up your diet, and you need to make it a habit. Like anything, you just have to <em>start</em>. You <em>totally can</em> choose foods that you actually enjoy and are nutritious at the same time. The word "diet" has a negative connotation, it sounds like it's gonna be terrible, but it's really not if your meal plan is made up of foods you <u>actually like.</u></p>
			
	
			
			



		


</div> <!-- end .result -->

</div> <!-- end .container -->




		
<?php include_once('./includes/footer.php'); ?>




</body>
</html>