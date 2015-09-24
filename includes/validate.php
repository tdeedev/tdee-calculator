<?php

function isSystemValid($system){

	if($system === 'imperial'){
	  
	  return true;
	
	} elseif($system === 'metric'){
	  
	  return true;
	
	} else {
	
		return false;
	}	

}

function isGenderValid($gender){

	if($gender === 'male'){
	  
	  return true;
	
	} elseif($gender === 'female'){
	  
	  return true;
	
	} else {
	
		return false;
	}	

}

function isHeightValid($height){

	if($height >=55 && $height < 85){
		return true;
	} else {
		return false;
	}

}

function isActivityValid($activity){

	if($activity == '1.2' || $activity == '1.375' || $activity == '1.55' || $activity == '1.725' || $activity == '1.9'){
		return true;
	} else {
		return false;
	}

}