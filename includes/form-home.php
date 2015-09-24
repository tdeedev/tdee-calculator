<?php if($error){ ?>
	<p class="text-danger" style="position:relative;">Please fill out the form correctly</p>
<?php } ?>
	
<div id="form">

			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			
			  <?php

			  
			  if(empty($_SERVER["GEOIP_CITY_COUNTRY_CODE"])){
			   $country = 'US';
			  } else{
			   $country = @$_SERVER["GEOIP_CITY_COUNTRY_CODE"];
			  }
			  
			  ?>
			  
			  <?php if($country == 'US' || $country == 'CA' || $country == 'GB') { ?>
			  <input type="hidden" name="system" value="imperial">
			  <?php } else { ?>
			  <input type="hidden" name="system" value="metric">
			  <?php } ?>
			  
			  
			  
			  <table>
			  
			  <tr>
			  <td class="col1">Gender</td>
			  <td>
			  <label><input type="radio" name="gender" id="male" value="male" checked> Male&nbsp;</label>
			  <label><input type="radio" name="gender" id="female" value="female"> Female</label>
			  </td>
			  </tr>
			  
			  <tr>
			  <td class="col1"><label for="age">Age</label></td>
			  <td>
			  <input type="text" name="age" class="form-control" id="age" style="width:60px;" maxlength="3" value="<?php if(isset($_POST['age']) && is_numeric($_POST['age'])){ echo $_POST['age']; } ?>">
			  </td>
			  </tr>
			  
			  <?php if($country == 'US' || $country == 'CA' || $country == 'GB') { ?>
			  <tr>
			  <td class="col1"><label for="weight">Weight</label></td>
			  <td><input type="text" name="weight" class="form-control" id="weight" placeholder="lbs" style="width:60px;" maxlength="3" value="<?php if(isset($_POST['weight']) && is_numeric($_POST['weight'])){ echo $_POST['weight']; } ?>"></td>
			  </tr>
			  
			  <tr>
			  <td class="col1">Height</td>
			  <td>
			    <select name="height" class="form-control" style="width:100px;">
			    <option value="55">4ft 7in</option>
			    <option value="56">4ft 8in</option>
			    <option value="57">4ft 9in</option>
			    <option value="58">4ft 10in</option>
			    <option value="59">4ft 11in</option>
			    <option value="60">4ft 12in</option>
			    <option value="61">5ft 1in</option>
			    <option value="62">5ft 2in</option>
			    <option value="63">5ft 3in</option>
			    <option value="64">5ft 4in</option>
			    <option value="65">5ft 5in</option>
			    <option value="66">5ft 6in</option>
			    <option value="67">5ft 7in</option>
			    <option value="68">5ft 8in</option>
			    <option value="69" selected>5ft 9in</option>
			    <option value="70">5ft 10in</option>
			    <option value="71">5ft 11in</option>
			    <option value="72">6ft 0in</option>
			    <option value="73">6ft 1in</option>
			    <option value="74">6ft 2in</option>
			    <option value="75">6ft 3in</option>
			    <option value="76">6ft 4in</option>
			    <option value="77">6ft 5in</option>
			    <option value="78">6ft 6in</option>
			    <option value="79">6ft 7in</option>
			    <option value="80">6ft 8in</option>
			    <option value="81">6ft 9in</option>
			    <option value="82">6ft 10in</option>
			    <option value="83">6ft 11in</option>
			    <option value="84">7ft 0in</option>
			    </select>
			  </td>
			  </tr>

			  
			  <?php } else { ?>
			  <tr>
			  <td class="col1"><label for="weight">Weight</label></td>
			  <td><input type="text" name="weight" class="form-control" id="weight" placeholder="kg" style="width:60px;" maxlength="5"></td>
			  </tr>
			  
			  <tr>
			  <td class="col1"><label for="height">Height</label></td>
			  <td><input type="text" name="height" class="form-control" id="height" placeholder="cm" style="width:60px;" maxlength="3"></td>
			  </tr>
			  <?php } ?>
			  
			  
			  <tr>
			  <td class="col1">Activity</td>
			  <td>
			    <select name="activity" class="form-control" style="width:200px;">
			    <option value="1.2" selected>Sedentary (office job)</option>
			    <option value="1.375">Light Exercise (1-2 days/week)</option>
			    <option value="1.55">Moderate Exercise (3-5 days/week)</option>
			    <option value="1.725">Heavy Exercise (6-7 days/week)</option>
			    <option value="1.9">Athlete (2x per day) </option>
			    </select>
			  </td>
			  </tr>
			
			  <tr>
			  <td class="col1">&nbsp;</td>
			  <td><input type="submit" class="btn btn-submit btn-lg" id="submit" name="submit" value="Calculate!"></td>
			  </tr>
			  
			  </table>
			  
			</form>
		</div> <!-- end #form -->