<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<title>Komun</title>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

	<div class="formdiv">
		<form action="Index.php" method="post">
			<label for="title">Title:</label>
			<input type="text" id="title" name="title" placeholder="Title" required>

			<label for="ansvarig">Ansvarig:</label>
			<input type="text" id="title" name="ansvarig" placeholder="Ansvarig" required>

			<label for="organ">Organ:</label>
			<input type="text" id="organ" name="organ" placeholder="Organ" required>

			<label for="förvaring">Förvaring:</label>
			<input type="text" id="förvaring" name="förvaring" placeholder="Förvaring" required>

			<label for="länk">Länk:</label>
			<input type="text" id="länk" name="länk" placeholder="Länk" required>

			<label for="stub">Stub:</label>
			<textarea required id="stub" name="stub" placeholder="Stub"></textarea>

			<label for="sammanträde">Sammanträde:</label>
			<input type="date" id="sammanträde" name="sammanträde" required>

			<label for="uppsättdatum">Uppsätt Datum:</label>
			<input type="date" id="uppsättdatum" name="uppsättdatum" required>
		</form>
	</div>

</body>

</html>