<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<title>komun</title>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

	<div class="formdiv">
		<form action="Index.php" method="post">
			<label for="titel">Titel:</label>
			<input type="text" id="titel" name="titel" placeholder="Titel" required>

			<label for="ansvarig">Ansvarig:</label>
			<input type="text" id="ansvarig" name="ansvarig" placeholder="Ansvarig" required>

			<label for="organ">Organ:</label>
			<input type="text" id="organ" name="organ" placeholder="Organ" required>

			<label for="forvaringsplats">Förvaringsplats:</label>
			<input type="text" id="forvaringsplats" name="forvaringsplats" placeholder="Förvaringsplats" required>

			<label for="stub">Stub:</label>
			<textarea required id="stub" name="stub" placeholder="Stub" rows="10" required=""></textarea>

			<label for="sammantrade">Sammanträde:</label>
			<input type="date" id="sammantrade" name="sammantrade" required>

			<label for="uppsattdatum">Uppsätt Datum:</label>
			<input type="date" id="uppsattdatum" name="uppsattdatum" required>

			<label for="pdf">Pdf:</label>
			<input type="text" id="pdf" name="pdf" placeholder="PDF" required>

			<input type="submit" name="submit" value="Submit">
		</form>
	</div>

	<?php 

		$dbh = new PDO("mysql:host=localhost;dbname=komun;charset=utf8", "root", "");

		$sql = 'select * from anslagstavla';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($variable as $key => $value) {
			
		}

		if(isset($_POST['submit'])){


			$titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS);
			$ansvarig = filter_input(INPUT_POST, 'ansvarig', FILTER_SANITIZE_SPECIAL_CHARS);
			$organ = filter_input(INPUT_POST, 'organ', FILTER_SANITIZE_SPECIAL_CHARS);
			$forvaringsplats = filter_input(INPUT_POST, 'forvaringsplats', FILTER_SANITIZE_SPECIAL_CHARS);
			$stub = filter_input(INPUT_POST, 'stub', FILTER_SANITIZE_SPECIAL_CHARS);
			$sammantrade = filter_input(INPUT_POST, 'sammantrade', FILTER_SANITIZE_SPECIAL_CHARS);
			$uppsattdatum = filter_input(INPUT_POST, 'uppsattdatum', FILTER_SANITIZE_SPECIAL_CHARS);
			$pdf = filter_input(INPUT_POST, 'pdf', FILTER_SANITIZE_SPECIAL_CHARS);

			$stmt = $dbh->prepare("INSERT INTO anslagstavla(titel, ansvarig, organ, forvaringsplats, stub, sammantrade, uppsattdatum, pdf) 
					
			VALUES (:titel, :ansvarig, :organ, :forvaringsplats, :stub, :sammantrade, :uppsattdatum, :pdf)");

	    	$stmt->bindParam(':titel', $titel);
	    	$stmt->bindParam(':ansvarig', $ansvarig);
	    	$stmt->bindParam(':organ', $organ);
	    	$stmt->bindParam(':forvaringsplats', $forvaringsplats);
	    	$stmt->bindParam(':stub', $stub);
	    	$stmt->bindParam(':sammantrade', $sammantrade);
	    	$stmt->bindParam(':uppsattdatum', $uppsattdatum);
	    	$stmt->bindParam(':pdf', $pdf);
	    	$stmt->execute();


    	}



	?>

</body>

</html>