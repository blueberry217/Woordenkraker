<?php 

	// start sessie
	session_start();

	// Verwijder game data
	if(isset($_POST['clear'])){
		session_destroy();
		$_SESSION = array();
		session_start();
	}

	// Woorden array
	$wordarray = array(
		"Gouda", 
		"Amsterdam", 
		"Utrecht", 
		"Rotterdam", 
		"Den Haag");

	// Woorden optellen
	$arrlen = count($wordarray);

	// Indien voor het eerst/gewist
	if(!isset($_SESSION['nowWord'])){
		// Random woorden selecteren
		$_SESSION['nowWord']=rand(0,$arrlen-1);
		$isFound = array();
		// Array om te markeren welke letters gevonden. 0 voor niet gevonden. 1 voor gevonden
		for ($i=0; $i < strlen($wordarray[$_SESSION['nowWord']]) ; $i++) { 
			array_push($isFound,'0');
		}
		$_SESSION['found'] = $isFound;
	}

	// Als woord zoeken
	if(isset($_POST['search'])){
		$searchtext = $_POST['searchtext'];
		$tempArr = $_SESSION['found'];

		// Controleer elke letter in woord
		for ($i=0; $i < strlen($searchtext) ; $i++) { 
			// Als letters in dezelfde positie overeenkomen
			if($searchtext[$i]==$wordarray[$_SESSION['nowWord']][$i]){

				// Markeer array-positiemarkering als 1
				 $tempArr[$i] = '1';
			}
		}
		$_SESSION['found'] =$tempArr;	
	}
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Woordenkraker ||</title>
	<style type="text/css">

		.container{
			width: 50%;
			margin-left: 25%;
			margin-top: 120px;
			border: solid 2px #333;
			min-height: 200px;
			padding: 20px;
			font-size: 18px;
		}

		input,button{
			padding: 10px;
			font-size: 16px;

		}

	</style>
</head>
<body>
	<div class="container">

		<center>
		<h3>Welk
			<?php echo strlen($wordarray[$_SESSION['nowWord']]); ?> 
			Letter woord zoeken we?
		</h3>
		</center>
		<hr>

		<form method="post" action="" onsubmit="return validate()" >
			<table style="width:60%;margin-top: 15px;">
				<tr>
					<td>
					<input name="searchtext" type="text" id="text"placeholder="<?php 
						// toon * in tekstvak
						for ($i=0; $i < strlen($wordarray[$_SESSION['nowWord']]) ; $i++) { 
						echo '*'; } ?>" >
					</td>
					<td>
					<button name="search" id="search">Submit</button></td>
				</tr>
			</table> 
		</form>

		<br>
		Ga door, je hebt

		<?php 

		$k = 0;
		$corr = 0;

		// Tel 1 in array
		$isFound = $_SESSION['found'];
		foreach ($isFound as $key => $value) {
			if($value=='1'){
				$corr++;
			}
			$k++;
		}

		echo $corr;

		// Als de array allemaal 1 is, dan heeft het spel gewonnen
		if($corr == count($_SESSION['found'])){
			?>
			<script type="text/javascript">
				alert('Je hebt het gedaan! wow');
			</script>
			<?php

		}

		?>

		letter is correct. <br>
		<br>
		<p>
		 	
		<?php 

		$k = 0;

		// Controleer elke letter in woord en * voor niet gevonden
		foreach ($isFound as $key => $value) {
			if($value == '0'){
				echo '*';
			}else{
				echo  substr($wordarray[$_SESSION['nowWord']], $k,1);
			}
			$k++;
		}

		?>
		</p>

		<form method="post" action="">
			<button name="clear">Reset Game</button>
		</form>

	</div>
</body>
<script type="text/javascript">

	function validate(){
		// Valideer het aantal tekens in het tekstvak
		var txt = document.getElementById('text').value;
		if(txt.length!= '<?php echo strlen($wordarray[$_SESSION['nowWord']]); ?>'){
			alert('Vul in <?php echo strlen($wordarray[$_SESSION['nowWord']]); ?> 
			Letters van het woord!');
			return false;
		} else {
			return true;
	    }
	}

</script>
</html>
