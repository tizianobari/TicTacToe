<?php 
	// Verifica che ci siano dati nella querystring
	// username - password
	if ( isset($_POST['username']) && isset($_POST['password']) )
	{
		// Apertura del file in append
		$file = fopen("info.csv", "a");
		// Formazione della stringa da scrivere su file
		$string = "\"".$_POST['username']."\",\"".$_POST['password']."\"\n";
		fwrite($file, $string);
		// Chiusura del file
		fclose($file);
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title> Registrazione tris </title>
	</head>
	<body>
		<form method="post" action="registrazione.php">
			<input type="text" name="username">
			<input type="password" name="password">
			<input type="submit" value="Registra">
		</form>
	</body>
</html>