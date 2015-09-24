<?php

function Mifflin($system, $gender, $kg, $cm, $age, $activity = 1){

	// BMR = 10 * weight(kg) + 6.25 * height(cm) - 5 * age(y) + 5         (man)
	// BMR = 10 * weight(kg) + 6.25 * height(cm) - 5 * age(y) - 161     (woman) 

	if($gender == 'male'){
		$total = 10 * $kg + 6.25 * $cm - 5 * $age + 5;
		$total = $total * $activity;
		return (int) $total;
	}
	
	if($gender == 'female'){
		$total = (10 * $kg) + (6.25 * $cm) - (5 * $age) - 161;
		$total = $total * $activity;
		return (int) $total;
	}

}


function BMI($kg, $cm){

	$m = $cm * 0.01;
	$m = $m * $m;
	$bmi = $kg / $m;
	return $bmi;

}

function BMI_Classification($bmi){

	if($bmi < 18.5){
		return 'Underweight';
	} elseif($bmi >= 18.5 && $bmi < 25){
		return 'Normal Weight';
	} elseif($bmi >= 25 && $bmi < 30){
		return 'Overweight';
	} elseif($bmi >= 30){
		return 'Obese';
	} else {
		return 'error';
	}
			  	
				  	
}


function Pretty($num, $decimals = 0){
		return number_format($num, $decimals);
}


function IBW_Hamwi($gender, $in, $system){
	// 48.0 kg + 2.7 kg per inch over 5 feet       (man)
	// 45.5 kg + 2.2 kg per inch over 5 feet       (woman)
	
	$fivefeet = 60;
	$remainder = $in - $fivefeet;
	
	if($gender == 'male'){
		$total = 48 + (2.7 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
	
	}
	
	if($gender == 'female'){
		$total = 45.5 + (2.2 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
		
	}

}


function IBW_Devine($gender, $in, $system){
	// 50.0 + 2.3 kg per inch over 5 feet       (man)
	// 45.5 + 2.3 kg per inch over 5 feet       (woman)
	$fivefeet = 60;
	$remainder = $in - $fivefeet;
	
	if($gender == 'male'){
		$total = 50 + (2.3 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
	
	}
	
	if($gender == 'female'){
		$total = 45.5 + (2.3 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
		
	}

}



function IBW_Robinson($gender, $in, $system){
	// 52 kg + 1.9 kg per inch over 5 feet       (man)
	// 49 kg + 1.7 kg per inch over 5 feet       (woman)
	$fivefeet = 60;
	$remainder = $in - $fivefeet;
	
	if($gender == 'male'){
		$total = 52 + (1.9 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
	
	}
	
	if($gender == 'female'){
		$total = 49 + (1.7 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
		
	}

}



function IBW_Miller($gender, $in, $system){
	// 56.2 kg + 1.41 kg per inch over 5 feet       (man)
  // 53.1 kg + 1.36 kg per inch over 5 feet       (woman)
  $fivefeet = 60;
	$remainder = $in - $fivefeet;
	
	if($gender == 'male'){
		$total = 56.2 + (1.41 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
	
	}
	
	if($gender == 'female'){
		$total = 53.1 + (1.36 * $remainder);
		
		if($system == 'imperial'){
			return $total * 2.20462; // convert kg back to lbs
		} else {
			return $total;
		}
		
	}

}
