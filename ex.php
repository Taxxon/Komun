<?php
	/*
	*
	*	Allt i ett fil för php/databasmoment
	*
	*/

	//databasuppkoppling
	// check för exceptions med try catch, bör användas för resten av dokumentet
	try {
		$dbh = new PDO("mysql:host=localhost;dbname=teblog;charset=utf8", "root", "", array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    	));
    }
    catch(PDOException $pe) {
        echo $pe->getMessage();
    }  
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Posts</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<style>
		html {
			font-size: 16px;
		}
		body {
			font-size: 62.5%;
			font-family: 'Open Sans', sans-serif;
			background-color: #fafafa;
		}
		main {
			width: 80%;
			margin: 0 auto;
		}
		h1 {
			font-size: 5em;
			color: #424242;
			border-bottom: solid 4px #bdbdbd;
		}
		h2 {
			font-size: 4em;
			color: #424242;
			border-bottom: solid 2px #e0e0e0;
		}
		h3 {
			font-size: 3em;
			color: #616161;
			border-bottom: solid 1px #eeeeee;
		}
		small {
			font-size: 0.6em;
			color: #9e9e9e;
		}
		p {
			font-size: 1.8em;
			color: #212121;
		}
		form {
			width: 60%;
			margin: 0 auto;
		}
		label {
			font-size: 2.2em;
			color: #616161;
		}
		input[type=text] {
		    width: 100%;
		    padding: 12px 20px;
		    margin: 8px 0;
		    box-sizing: border-box;
		    border: 1px solid #9e9e9e;
		    font-size: 1.4em;
		}
		input[type=button], input[type=submit], input[type=reset] {
		    background-color: #424242;
		    border: none;
		    color: #fafafa;
		    padding: 16px 32px;
		    text-decoration: none;
		    margin: 4px 2px;
		    cursor: pointer;
		    width: 100%;
		    font-size: 2.2em;
		}
		textarea {
		    width: 100%;
		    height: 180px;
		    padding: 12px 20px;
		    margin: 8px 0;
		    box-sizing: border-box;
		    border: 1px solid #9e9e9e;
		    resize: none;
		    font-size: 1.4em;
		    font-family: 'Open Sans', sans-serif;
		}
		header p {
			font-size: 2.2em;
		}
		table {
		    border-collapse: collapse;
		    width: 100%;
		    font-size: 1.8em;
		    color: #212121;
		}
		td, th {
		    border: 1px solid #eeeeee;
		    text-align: left;
		    padding: 8px;
		}

		th {
			background-color: #424242;
			color: #fafafa;
		}

		tr:nth-child(even) {
		    background-color: #eeeeee;
		}
		table input[type=submit] {
			font-size: 1em;
		}
	</style>
</head>
<body>
<main>
	<header>
		<h1>DATABASEXEMPEL</h1>
		<p>Se kod i detta dokument för exempel på CRUD</p>
		<?php
			// hanterar de olika post vi skickar för admin funktion
			if (isset($_POST['delete'])) {
				echo "<p>Delete</p>";
				$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
				// använder den filterarde id variabel för att ta bort raden med prep statements
				$sql = "DELETE FROM posts 
						WHERE id = :id";
				$stmt = $dbh->prepare($sql);	
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
			}
			elseif (isset($_POST['publish'])) {
				echo "<p>Publish</p>";
				$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
				$body = filter_input(INPUT_POST, "body", FILTER_SANITIZE_SPECIAL_CHARS);
				// filterar och använder sedan SQL insert
				$sql = "INSERT into posts(title, body) 
						VALUES(:title, :body)";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':title', $title, PDO::PARAM_STR);
				$stmt->bindParam(':body', $body, PDO::PARAM_STR);
				$stmt->execute();
			}
			elseif (isset($_POST['edit'])) {
				echo "<p>Update</p>";
				$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
				$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
				$body = filter_input(INPUT_POST, "body", FILTER_SANITIZE_SPECIAL_CHARS);
				// filter, sedan update
				$sql = "UPDATE posts
						SET title = :title, body = :body
						WHERE id = :id";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->bindParam(':title', $title, PDO::PARAM_STR);
				$stmt->bindParam(':body', $body, PDO::PARAM_STR);
				$stmt->execute();
			}
		?>
	</header>
	<section id="posts">
		<h2>Blogexempel</h2>
		<?php
			// sql för att välja alla rader i posts tabellen
			$sql = "SELECT * 
					FROM posts 
					ORDER BY postdate DESC";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
			// notera att vi använder fetchall för att hämta all data i en assoc array
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// echo "<pre>" . print_r($results,1) . "</pre>"; dump för att se

			// loopa igenom resultatet och skapa html för varje post
			foreach ($results as $row) {
				echo "<h3>" . $row['title'] . "<small> 
					<time>" . $row['postdate'] . "</time></small></h3>";
				echo "<p>" . $row['body'] . "</p>";
			}
		?>
	</section>
	<section id="admin">
		<h2>Admin tools</h2>
		<table>
			<tr>
				<th>ID</th>
				<th>TITLE</th>
				<th>POSTDATE</th>
				<th> </th>
				<th> </th>
			</tr>
		<?php
		/*
			Här skapas varje rad i admin tabellen
			Notera att vi använder ett formulär som skrivs ut och avslutas vid id
			Detta för att ett formulär inte kan innehålla table taggar, då validerar
			inte dokumentet.
			För att komma runt detta så använder vi form attributet på submit knapparna
			så att vi kan hänvisa till det form som vi avser skicka med knappen´.
			Tips, inspekta detta i webbläsaren!

			Vi skickar även med ID i en input hidden så att vi vet vilken post som ska tas bort
			eller redigeras

			Alternativt kan vi lösa detta med länkar, där vi skickar parametrar med GET
		*/
			foreach ($results as $row) {
				echo "<tr>";
				echo "<td>" . $row['id'];
				echo "<form action=\"ex.php\" method=\"post\" id=\"form" . $row['id'] . "\">";
				echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
				echo "</form></td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td>" . $row['postdate'] . "</td>";
				echo "<td><input form=\"form" . $row['id'] ."\" type=\"submit\" name=\"delete\" value=\"Delete\"></td>";
				echo "<td><input form=\"form" . $row['id'] ."\" type=\"submit\" name=\"editpost\" value=\"Edit\"></td>";
				echo "</tr>";
			}
		?>
		</table>
	</section>
	<section id="publish">
		<h2>Post and edit form</h2>
		<form action="ex.php" method="post">
		<?php
			// om editpost är satt så har vi ett id och vill redigera en post
			if (isset($_POST['editpost'])) {
				$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

				$sql = "SELECT * FROM posts WHERE id = :id";
				$stmt = $dbh->prepare($sql);	
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();		

				// för att visa den post som användaren vill redigera
				// så hämtar vi först posten från databasen
				// och skriver ut den i formuläret
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				echo "<input type=\"hidden\" name=\"id\" value=\"" . $result['id'] . "\">";
				echo "<label for=\"title\">Title:</label>";
				echo "<input type=\"text\" name=\"title\" id=\"title\" value=\"" . $result['title'] . "\"><br>";
				echo "<label for=\"body\">Body:</label>";
				echo "<textarea name=\"body\" id=\"body\">" . $result['body'] . "</textarea>";
				echo "<input type=\"submit\" name=\"edit\" value=\"Edit\">";				
			}
			else {
		?>			
				<label for="title">Title:</label>
				<input type="text" name="title" id="title"><br>
				<label for="body">Body:</label>
				<textarea name="body" id="body"></textarea>
				<input type="submit" name="publish" value="Publish">
			
		<?php
			}
		?>
		</form>
	</section>
</main>
</body>
</html>

<?php
// databas export sql
// kör phpmyadmin och SQL för att skapa tabellen
/*
CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `body` text COLLATE utf8mb4_bin NOT NULL,
  `postdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;COMMIT;
*/

?>