<!DOCTYPE html>
<?php
	
	$passType = 0;
	//check for get and cookie and assign local variable
	if (!isset($_GET["pt"])){
		if(!isset($_COOKIE["passtype"])){
			setcookie("passtype",0,time() + 86400*365);
		}
		else {
			
			$passType = $_COOKIE["passtype"];
		}
	}
	else { 
		$passType = $_GET["pt"];
		setcookie("passtype",$passType ,time() + 86400*365);
	}
	
	//define mysql connection
	$servername = "localhost";
	$username = "pwd";
	$password = "BaDA9rAarBNpPSwc";
	$dbname = "pwdgen";
	$special="!@#$%^&*(),.<>?~`;:|][}{=-+_";
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	//declaring and setting the custom password variables here
	
			if(!isset($_COOKIE["wMin"])){
				setcookie("wMin",6,time() + 86400*365);
				$wMin = 6;
			}
			else {	
				if(!isset($_GET["wMinIn"])){
				     $wMin = $_COOKIE["wMin"];
				}
				else {
				     $wMin = $_GET["wMinIn"];
					 $_COOKIE["wMin"] = $wMin;
				}
			}
			
			
			if(!isset($_COOKIE["wMax"])){
				setcookie("wMax",12,time() + 86400*365);
				$wMax = 12;
			}
			else {		
				if(!isset($_GET["wMaxIn"])){
				     $wMax = $_COOKIE["wMax"];
				}
				else {
				     $wMax = $_GET["wMaxIn"];
					 $_COOKIE["wMax"] = $wMax;
				}
			}
			
			if(!isset($_COOKIE["wCount"])){
				setcookie("wCount",2,time() + 86400*365);
				$wCount = 2;
			}
			else {		
				if(!isset($_GET["wCountIn"])){
				     $wCount = $_COOKIE["wCount"];
				}
				else {
				     $wCount = $_GET["wCountIn"];
					 $_COOKIE["wCount"] = $wCount;
				}
			}
			
			if(!isset($_COOKIE["sChar"])){
				setcookie("sChar",2,time() + 86400*365);
				$sChar = 2;
			}
			else {		
				if(!isset($_GET["sCharIn"])){
				     $sChar = $_COOKIE["sChar"];
				}
				else {
				     $sChar = $_GET["sCharIn"];
					 $_COOKIE["sChar"] = $sChar;
				}
			}
			
			if(!isset($_COOKIE["numLen"])){
				setcookie("numLen",3,time() + 86400*365);
				$numLen = 3;
			}
			else {		
				if(!isset($_GET["numLenIn"])){
				     $numLen = $_COOKIE["numLen"];
				}
				else {
				     $numLen = $_GET["numLenIn"];
					 $_COOKIE["numLen"] = $numLen;
				}
			}
	
	
	

	
	
	
	
	//define functions
	//here i need to take the words pulled from the db
	//and generate passwords based on them
	//types 1-3 are related to standard password
	//all other functions will probably relate one-to-one
	//with a passsword type
	
	function type3 ( $w1 , $w2 , $w3){
		
		$num3=rand(100,10000);
		$temp3 =  str_shuffle ("!@#$%^&*(),.<>?~`;:|][}{=-+_");
		$temp3a = array(ucfirst($w1),ucfirst($w2),ucfirst($w3),$num3,$temp3[0],$temp3[1],$temp3[2],$temp3[3]);
		shuffle($temp3a);
		$ret3="";
		
		foreach ($temp3a as &$val3) {
			$ret3 = $ret3 . $val3;
		}
		return   preg_replace('/\s+/', '',$ret3);
	}
	
	function type2 ( $w1 , $w2 ){
		$num2=rand(100,10000);
		$temp2 =  str_shuffle ("!@#$%^&*(),.<>?~`;:|][}{=-+_");
		$temp2a =array(ucfirst($w1),ucfirst($w2),$num2,$temp2[0],$temp2[1],$temp2[2]);
		shuffle($temp2a);
		$ret2="";
		foreach ($temp2a as &$val2) {
			$ret2 = $ret2 . $val2;
		}
		return   preg_replace('/\s+/', '',$ret2);
	}
	
	function type1 ( $w1 ){
		$num1=rand(100,10000);
		$temp1 =  str_shuffle ("!@#$%^&*(),.<>?~`;:|][}{=-+_");
		$temp1a = array(ucfirst($w1),$num1,$temp1[0],$temp1[1],$temp1[2]);
		shuffle($temp1a);
	
		$ret1="";
		foreach ($temp1a as &$val1) {
			$ret1 = $ret1 . $val1;
		}
		return  preg_replace('/\s+/', '', $ret1);
		
	}
	
	//this is good for windows AD, like !SmallWords123$
	
	function userpwd ( $w1 , $w2){
		
		$num=rand(100,999);
		$temp1 =  str_shuffle ("!@#$%^&*()[]{}|-+<>?");
		$ret1=$temp1[0].ucfirst($w1).ucfirst($w2).$num.$temp1[2];
		return  preg_replace('/\s+/', '', $ret1);
		
	}
	
	
	// this returns a simple password like !Password123
	
	function simple ( $w1 ) {
		
		$num=rand(100,999);
		$temp1 =  str_shuffle ("!@#$%^&*()");
		$ret1=$temp1[0].ucfirst($w1).$num;
		return  preg_replace('/\s+/', '', $ret1);
		
	}
	
	
	$final='';	
	
	
	
	//This crap is all html code that I wanted inside the php code block
	//so the formatting is balls...
	
echo '	
<html><head>
<script>    
    if(typeof window.history.pushState == \'function\') {
        window.history.pushState({}, "Hide", '.$_SERVER['PHP_SELF'].');
    }
</script>
<title>
Matt\'s Secure Password Generator
</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.collapsible {
    width: 450px;
    border: none;
    text-align: left;
    outline: none;
}

.active, .collapsible:hover {
}

.content {
    width: 450px;
    padding: 0 px;
    display: none;
    overflow: hidden;
}



</style>

    <style>
        #meter div {
            height: 20px;
            width: 20px;
            margin: 0 1px 0 0;
            padding: 0;
            float: left;
            background-color: #DDDDDD;
        }

        #meter div.rating-1, #meter div.rating-2 {
            background-color: red;
        }

        #meter div.rating-3, #meter div.rating-4 {
            background-color: orange;
        }

        #meter div.rating-5, #meter div.rating-6 {
            background-color: yellow;
        }

        #meter div.rating-7, #meter div.rating-8 {
            background-color: greenyellow;
        }

        #meter div.rating-9, #meter div.rating-10 {
            background-color: green;
        }


    </style>
	
</head><body>

Hello folks.
<br>
This here is a secure password generator. <br>
I say secure because it will never issue repeat passwords.<br>
';
	
	//here, create blocks of password types numbered sequentially
	//type 0 is random standard 
	//type 1 is a good windows AD - $SmallWords123!
	//type 2 is a simple password - !Password123
	//i can add more passwords easily now
	
	switch($passType){	
		case 0:
	
			//start of standard password generator
			//step one - grab 60 words, select one, and make a choice
			$time = date("s",time());
			$sqlword1 = "SELECT wordVal FROM words where length(wordVal) < 13 ORDER BY RAND() LIMIT 60;";
			$wordResult1 = mysqli_query($conn, $sqlword1);
			$wordCount1=0;	
			$word1="";
			$word1L=0;
			
			while ($rowD = mysqli_fetch_assoc($wordResult1)){
				$n = strlen ($rowD["wordVal"] );
				if ($wordCount1 == $time){
					$word1=$rowD["wordVal"];
					$word1L=$n;
				}
				$wordCount1++;
				
			}
			
			//make the choice and do the things
			//for a short first word
			if ($word1L <5){
				
				$sqlword2 = "SELECT wordVal FROM words ORDER BY RAND() LIMIT 60;";
				$wordResult2 = mysqli_query($conn, $sqlword2);
				$wordCount2=0;
				$word2="";
				$word2L=0;
				$n2=0;
				while ($rowD = mysqli_fetch_assoc($wordResult2)){
					$n2 = strlen ($rowD["wordVal"] );
					if ($wordCount2 == $time){
						
						$word2=$rowD["wordVal"];
						$word2L=$n2;
					}
					$wordCount2++;
					
				}
			
				//for a short second word:
				if ($word2L < 4){	
					$sqlword3 = "SELECT wordVal FROM words ORDER BY RAND() LIMIT 60;";
					$wordResult3 = mysqli_query($conn, $sqlword3);		
					$wordCount3=0;
					$n3=0;
					$word3="";
					$word3L=0;
					
					while ($rowD = mysqli_fetch_assoc($wordResult3)){
						if ($wordCount3 == $time){
							
							$word3=$rowD["wordVal"];
						}
						$wordCount3++;
						
					}
					
					$final = type3($word1,$word2,$word3);
				}
				else {
					
					$final = type2($word1,$word2);
				}
			}
			
			//for a large first word
			else if ($word1L >8){
				
				$final = type1($word1);
				$layoutType=1;
						
			}

			//for a medium sized word then
			else {
				
				$sqlword2 = "SELECT wordVal FROM words ORDER BY RAND() LIMIT 60;";
				$wordResult2 = mysqli_query($conn, $sqlword2);		
				$wordCount2=0;
				$word2="";
				
				while ($rowD = mysqli_fetch_assoc($wordResult2)){
					if ($wordCount2 == $time){
						
						$word2=$rowD["wordVal"];
					}
					$wordCount2++;
					
				}
				$final = type2($word1,$word2);
				
			}
			
		
			//end of standard password generator
			break;
		
		//this generates a standard ad password like $SmallLetter123!
		case 1:
			$sqlword1 = "SELECT wordVal FROM simple_words where length(wordVal) < 7 ORDER BY RAND() LIMIT 2;";
			$wordResult1 = mysqli_query($conn, $sqlword1);
			
			$words = array();
			
			while ($rowD = mysqli_fetch_assoc($wordResult1)){
				$words[]=$rowD['wordVal'];
				
			}
			$final = userpwd ($words[0],$words[1]);
			break;
			
			
		//this generates a simple password like !Password123
		case 2:
			$sqlword1 = "SELECT wordVal FROM words where length(wordVal) > 6 AND length(wordVal) < 13  ORDER BY RAND() LIMIT 2;";
			$wordResult1 = mysqli_query($conn, $sqlword1);
			
			$words = array();
			//echo $sqlword1;
			while ($rowD = mysqli_fetch_assoc($wordResult1)){
				$final = simple ($rowD['wordVal']);
				
			}
			
			break;
			
						
		//this generates a custom password using options on the page
		case 3:
			$sqlword1 = "SELECT wordVal FROM words where length(wordVal) >= ".$wMin." AND length(wordVal) <= ".$wMax."  ORDER BY RAND() LIMIT ".$wCount.";";
			$wordResult1 = mysqli_query($conn, $sqlword1);
			
			$words = array();
			$customPass = array();
			//echo $sqlword1;
			while ($rowD = mysqli_fetch_assoc($wordResult1)){
				$customPass[]=ucfirst($rowD['wordVal']);
				
			}
			$cusNum="0";
			/*
			$num=rand(100,999);
			$temp1 =  str_shuffle ("!@#$%^&*()[]{}|-+<>?");
			$ret1=$temp1[0].ucfirst($w1).ucfirst($w2).$num.$temp1[2];
			return  preg_replace('/\s+/', '', $ret1);
			*/
			switch($numLen){
				case 0:
					$cusNum="";
					break;
					
				case 1:
					$cusNum=rand(0,9);
					break;
					
				case 2:
					$cusNum=rand(10,99);
					break;
					
				case 3:
					$cusNum=rand(100,999);
					break;
					
				case 4:
					$cusNum=rand(1000,9999);
					break;
					
				case 5:
					$cusNum=rand(10000,99999);
					break;
					
				case 6:
					$cusNum=rand(100000,999999);
					break;
					
				case 7:
					$cusNum=rand(1000000,9999999);
					break;
					
				case 8:
					$cusNum=rand(10000000,99999999);
					break;
										
			}
			$customPass[] = $cusNum;
			
			$temp1 =  str_shuffle ("!@#$%^&*()[]{}|-+<>?");
			
			$sCharCus = array();
			
			for ($count1 = 0; $count1 < $sChar; $count1++){
				$customPass[] = $temp1[$count1];
				
				
			}
			
			shuffle($customPass);
			
			$final = implode("",$customPass);
			break;
			
	}	
	//hash the password and check the database
	$pwdhash=hash("sha512",$final);
	$sqlhash = "SELECT * FROM hashs where hashVal=\"".$pwdhash."\";";
	$hashResult = mysqli_query($conn, $sqlhash);	
		
		
	//rate the password
	//stole this from the internets
		
	function detect_any_uppercase($string) {
		//Comparison operator. Returns true if lowercase changes string
		return strtolower($string) != $string;
	}


	function detect_any_lowercase($string) {
		//true if uppercase changes string
		return strtoupper($string) != $string;
	}


	function count_numbers($string) {
		return preg_match_all('/[0-9]/', $string);
	}

	function count_symbols($string) {
		// You have to decide which symbols count
		// Regex /W is any non-letter, non-number: but this could be too broad
		// Better to list the ones that count
		// To write a regex here, you start with '', then inside that some square brackets [], then inside the square brackets is everything you want to include
		// Escape regex symbols to get their literal values - preg_quote helps facilitate that
		$regex = '/[' . preg_quote('!@£$%^&*-_+=?') . ']/';
		return preg_match_all($regex, $string);
	}


	function passwordTest_strength($passwordTest) {
		$strength = 0;
		$possible_points = 12;
		$length = strlen($passwordTest);


		if(detect_any_uppercase($passwordTest)) {
			$strength += 1;
		}

		if(detect_any_lowercase($passwordTest)) {
			$strength += 1;
		}

	//    echo count_numbers($passwordTest);
	//    echo count_symbols($passwordTest);

		// this adds points for numbers but limits the total possible to 2
		$strength += min(count_numbers($passwordTest), 2);
		// same again for symbols
		$strength += min(count_symbols($passwordTest), 2);


		if($length >= 8) {
			$strength += 2;
			$strength += min(($length - 8) * 0.5, 4);
		}


		$strength_percent = $strength / (float) $possible_points;
		$rating = floor($strength_percent * 10);
		return $rating;

	}

	$passwordTest = $final;
	$rating = passwordTest_strength($passwordTest);

		
	if(mysqli_num_rows($hashResult) == 0 || $passType == 3){
		$sqlAdd = "	INSERT INTO hashs (hashVal) VALUES (\"".$pwdhash."\");";
		mysqli_query($conn, $sqlAdd);
		//echo "<h2>". $final."</h2>";
		
		//password rating code will be used here
		
		echo '<p>
<input type="text" onClick="this.select();" style="font-size:20pt;border:none;" value="'.$final.'" id="myInput" ><p>
<button onclick="myFunction()">Copy text</button>
		<p>Your password strength is: '.$rating."<br>
		<div id=meter>
		";
		
		for($i=0; $i < 10; $i++) {
			echo "<div";
			if($rating > $i) {
				echo " class=\"rating-{$rating}\"";
			}
			echo "></div>";
		}
		
		
		//let's work on this dropdown
		
		echo '
		<p><br></div><p>
		<form action="#" method="GET">
		<select name="pt" onchange="this.form.submit()">
		<option value="0"';
		if (  $passType == 0){
			echo " selected ";
			
		}
		echo '>Standard</option>
		<option value="1"';
		if (  $passType == 1){
			echo " selected ";
			
		}
		echo '>Windows AD</option>
		
		
		<option value="2"';
		if (  $passType == 2){
			echo " selected ";
			
		}
		echo '>Simple</option>
		
				
		<option value="3"';
		if (  $passType == 3){
			echo " selected ";
			
		}
		echo '>Custom</option>
		
		</select><br><p>
		';
			if ($passType !=3){
			echo '
		
<input type="button" value="Generate Password" onClick="window.location.reload();">
<p>
		';	
			}
		
		
		if ($passType == 0){
			echo'
			</p>
			<button class="collapsible">Click here for Standard Password Rules</button>
			<div class="content">
			<p>I have a list of about 20k english words. When you go to this page, I select 60 of these words that are less than 13 characters, 
			and use the one whose index matches the current second. Then, depending on the length of this word, 
			this may or may not grab a couple more words from the list, and then it will generate a random number.
			Then, it shuffles a list of special characters and sprinkles a few of those in with the words and numbers. 
			Then, once all that is generated, it will shuffle all  these things it generated and spit them back. 
			It takes a hash of the generated password and compares it to a list of all hashes generated in the past. 
			If the newly generated password is unique,  it will print it out under here, otherwise it will try again. 
			If it generates a bad password, just refresh until you get one you like.  This site can never generate the same password twice. 
			Also, this hash is a one way encryption, so the passwords cannot be re-created from the hashes.</p>
			</div>

			';
		}
		
		if ($passType == 1){
			echo'
			
			</p>
			<button class="collapsible">Click here for password specs</button>
			<div class="content">
			<p>
			This password is always in the following format: <br>
			$Word1Word2Number$<br>
			Where each word is less than 7 characters, the number is <br>
			3 digits, and the $ represents a Special Charater.</p></div><p>
			';
		}
		
		
		if ($passType == 2){
			echo'
			This simple password is in the following format:<br>
			!Password123<p>
			Also, this draws from a simpler list of about 3k words.<p>
			';
		}
		
			
		if ($passType == 3){
			//this part loads a bunch of vars into cookies to keep url clean...
			/*
				vars needed:
					wMin
					wMax
					wCount
					sChar
					numLen
			
			
			*/
			/*
			if(!isset($_COOKIE["wMin"])){
				setcookie("wMin",6,time() + 86400*365);
				$wMin = 6;
			}
			else {	
				$wMin = $_GET["wMinIn"];
				$_COOKIE["wMin"] = $wMin;
			}
			
			
			if(!isset($_COOKIE["wMax"])){
				setcookie("wMax",12,time() + 86400*365);
				$wMax = 12;
			}
			else {	
				$wMax = $_GET["wMaxIn"];
				$_COOKIE["wMax"] = $wMax;
			}
			
			if(!isset($_COOKIE["wCount"])){
				setcookie("wCount",2,time() + 86400*365);
				$wCount = 2;
			}
			else {	
				$wCount = $_GET["wCountIn"];
				$_COOKIE["wCount"] = $wCount;
			}
			
			if(!isset($_COOKIE["sChar"])){
				setcookie("sChar",2,time() + 86400*365);
				$sChar = 2;
			}
			else {	
				$sChar = $_GET["sCharIn"];
				$_COOKIE["sChar"] = $sChar;
			}
			
			if(!isset($_COOKIE["numLen"])){
				setcookie("numLen",3,time() + 86400*365);
				$numLen = 3;
			}
			else {	
				$numLen = $_GET["numLenIn"];
				$_COOKIE["numLen"] = $numLen;
			}
			*/
			echo'
			
			Hey folks, this thing finally works.<br>
			It does refresh the password whenever you move the sliders right now,<br>
			which is not what I want, but it does function. <p>
			

			<table width="500"><tr><td width="200">
			Minimum Word Length:  </td><td width="100">  
				<input type="range" name="wMinIn" id="wMinIn"  min="3" max="10"  value="'.$wMin.'"  oninput="updateTextInput1(this.value);this.form.submit();">
				</td><td width="50">  <input type="number" name="wMin" id="wMin" min="0" max="30"  value="'.$wMin.'" disabled><br></td></tr><tr><td width="200">
			Maximum Word Length:  </td><td width="100">  
								
				<input type="range" name="wMaxIn" id="wMaxIn" min="3" max="10"  value="'.$wMax.'"  oninput="updateTextInput2(this.value);this.form.submit();">
				</td><td width="50">  <input type="number" name="wMax" id="wMax" min="0" max="30"  value="'.$wMax.'" disabled><br></td></tr><tr><td width="200">
			Number of Words:  </td><td width="100">   
				
				<input type="range" name="wCountIn" id="wCountIn" min="1" max="5" value="'.$wCount.'"  oninput="updateTextInput3(this.value);this.form.submit();">
				</td><td width="50">   <input type="number" name="wCount" id="wCount" step="1" min="0" max="30" value="'.$wCount.'" disabled><br></td></tr><tr><td width="200">
			Special Characters:  </td><td width="100">   
				
				<input type="range" name="sCharIn" id="sCharIn" min="0" max="4"  value="'.$sChar.'" oninput="updateTextInput4(this.value);this.form.submit();">
				</td><td width="50">   <input type="number" name="sChar" id="sChar" step="1"  min="0" max="30"  value="'.$sChar.'" disabled><br></td></tr><tr><td width="200">
			Number Length:  </td><td width="100">    
				
				<input type="range" name="numLenIn" id="numLenIn"  min="0" max="8" value="'.$numLen.'" oninput="updateTextInput5(this.value);this.form.submit();">
				</td><td width="50">  <input type="number" name="numLen" id="numLen" step="1" min="0" max="30" value="'.$numLen.'" disabled></td></tr><table>
				
				<input type="button" value="Generate Password" onClick="window.location.reload()">
				
			';
			//<td>Unlimited <input type="checkbox" id="noMax" name="noMax"></td>
			//echo "<br>No Max: ".$_GET["noMax"]."<br>";
			//echo "<br>Cookie Value for Min: ".$_COOKIE["wMin"]."<br>GET value for Min: ".$GET["wMinIn"]."<br>Variable wMin: ".$wMin."<p>";
			//echo "<br>Values - Testing:<br>wMin: ".$_COOKIE["wMin"]."<p>wMax:".$_COOKIE["wMax"]."<p>wCount:".$_COOKIE["wCount"]."<p>sChar:".$_COOKIE["sChar"]."<p>numLen:".$_COOKIE["numLen"]."<p>";
		}	
		
//			<div id="slider-range"></div>
//window.location.reload();
		
	}
		
	else if ($passType != 3){
		header("Refresh:0");
	}	
	else {
			echo "OH FUCK DUPLICATE PASSWORD!!!!1!!<br>";
	}
	

	echo "</form>";
	//echo "<br>test:".$_GET['sCharIn']."<br>";
	//echo "<br>test:".$_GET['pt']."<br>";
	echo "
		<p>There have been ".mysqli_num_rows(mysqli_query($conn, "select * from hashs;"))." total passwords generated thus far.<p>";

?>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>



<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}
</script>

<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}
</script>


<script>

var elX = document.getElementById("wMaxIn");
var elY = document.getElementById("wMinIn");

function limit() {
	elY.value=Math.min(Math.round(elX.value),elY.value);
	document.getElementById("wMin").value=elY.value;
}

elX.onchange=limit;
elY.onchange=limit;
</script>


<script>

function updateTextInput1(val) {
          document.getElementById('wMin').value=val; 
        }
function updateTextInput2(val) {
          document.getElementById('wMax').value=val; 
        }
function updateTextInput3(val) {
          document.getElementById('wCount').value=val; 
        }
function updateTextInput4(val) {
          document.getElementById('sChar').value=val; 
        }
function updateTextInput5(val) {
          document.getElementById('numLen').value=val; 
        }

</script>



</body></html>