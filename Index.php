<?php
	
	// databasuppkopling
	// tittar efter PDOException
	try {
		$dbh = new PDO("mysql:host=localhost;dbname=komun;charset=utf8", "root", "", array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    	));
    }
    catch(PDOException $pe) {
        echo $pe->getMessage();
    }  
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>komun</title>
	<link rel="stylesheet" type="text/css" href="style.css">		
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

</head>
<body>
	<!-- Formulär där du kan skriva in alla värden till Anslagstavlan -->
	<div class="formdiv">
		<form action="index.php" method="post">
			<label for="titel">Titel:</label>
			<input type="text" id="titel" name="titel" placeholder="Titel" required>

			<label for="ansvarig">Ansvarig:</label>
			<input type="text" id="ansvarig" name="ansvarig" placeholder="Ansvarig" required>

			<label for="organ">Organ:</label>
			<input type="text" id="organ" name="organ" placeholder="Organ" required>

			<label for="forvaringsplats">Förvaringsplats:</label>
			<input type="text" id="forvaringsplats" name="forvaringsplats" placeholder="Förvaringsplats" required>

			<label for="stub">Stub:</label>
			<textarea id="stub" name="stub" placeholder="Stub" rows="10" required></textarea>

			<label for="sammantrade">Sammanträde:</label>
			<input type="date" id="sammantrade" name="sammantrade" required>

			<label for="uppsattdatum">Uppsätt Datum:</label>
			<input type="date" id="uppsattdatum" name="uppsattdatum" required>

			<label for="pdf">Pdf:</label>
			<input type="text" id="pdf" name="pdf" placeholder="PDF" required>

			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
		<!-- Tabel för att visa vila värden som finns i databasen -->
		<table class="table">
			<tr>
				<th>Id</th>
				<th>Titel</th>
				<th>Ansvarig</th>
				<th>Organ</th>
				<th>Förvaringsplats</th>
				<th>Stub</th>
				<th>Sammanträde</th>
				<th>Uppsätt Datum</th>
				<th>Pdf</th>
			</tr>
			<?php
			//Hämtar alla värden så man kan fylla i Tabelen
			$sql = 'select * from anslagstavla';
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			//En foreach loop som går igenom databasen och skriver in alla värden i en tabel så man kan se vad som finns i databasen
			foreach ($rows as $key => $value){ ?>
			<tr>
				<td> <?php echo $value["id"] ?></td>
				<td> <?php echo $value["titel"] ?></td>
				<td> <?php echo $value["ansvarig"] ?></td>
				<td> <?php echo $value["organ"] ?></td>
				<td> <?php echo $value["forvaringsplats"] ?></td>
				<td> <?php echo $value["stub"] ?></td>
				<td> <?php echo date("Y-m-d", strtotime($value["sammantrade"])) ?></td>
				<td> <?php echo date("Y-m-d", strtotime($value["uppsattdatum"])) ?></td>
				<td> <?php echo $value["pdf"] ?></td>
			</tr>
			<?php } ?>
		</table>
	<?php 
		
		//Om vi har skickat ett värde gör det som är i if satsen
		if(isset($_POST['submit'])){
			// Filtrerar alla värden som kommer in
			$titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS);
			$ansvarig = filter_input(INPUT_POST, 'ansvarig', FILTER_SANITIZE_SPECIAL_CHARS);
			$organ = filter_input(INPUT_POST, 'organ', FILTER_SANITIZE_SPECIAL_CHARS);
			$forvaringsplats = filter_input(INPUT_POST, 'forvaringsplats', FILTER_SANITIZE_SPECIAL_CHARS);
			$stub = filter_input(INPUT_POST, 'stub', FILTER_SANITIZE_SPECIAL_CHARS);
			$sammantrade = filter_input(INPUT_POST, 'sammantrade', FILTER_SANITIZE_SPECIAL_CHARS);
			$uppsattdatum = filter_input(INPUT_POST, 'uppsattdatum', FILTER_SANITIZE_SPECIAL_CHARS);
			$pdf = filter_input(INPUT_POST, 'pdf', FILTER_SANITIZE_SPECIAL_CHARS);

			//Förbereder så att det kan skriva in alla värden i databasen
			$stmt = $dbh->prepare("INSERT INTO anslagstavla(titel, ansvarig, organ, forvaringsplats, stub, sammantrade, uppsattdatum, pdf) 
			VALUES (:titel, :ansvarig, :organ, :forvaringsplats, :stub, :sammantrade, :uppsattdatum, :pdf)");

			//Använder prepere statment för säkerhet och för att det är lättare
	    	$stmt->bindParam(':titel', $titel);
	    	$stmt->bindParam(':ansvarig', $ansvarig);
	    	$stmt->bindParam(':organ', $organ);
	    	$stmt->bindParam(':forvaringsplats', $forvaringsplats);
	    	$stmt->bindParam(':stub', $stub);
	    	$stmt->bindParam(':sammantrade', $sammantrade);
	    	$stmt->bindParam(':uppsattdatum', $uppsattdatum);
	    	$stmt->bindParam(':pdf', $pdf);
	    	$stmt->execute();

	    	Header("Location: ../Komun/index.php");
			exit();
    	}
    	/*
    	Att tänka på är att skriva namnen på variabler på engelska, eftersom jag glömde det så blev namnen kosntiga då jag var tvungen att ta bort alla å ä ö
    	Formuläret är anpassat så när skärmen blir mindre blir formuläret mindre
    	Har feltestat så att det inte går att använda javascript i någon av input rutorna
    	*/
	?>
</body>
</html>