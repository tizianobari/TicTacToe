<?php
	$log = "";
	// Verifica che ci siano dati nella querystring
	// username - password
	if ( isset($_POST['username']) && isset($_POST['password']) )
	{
		$found = false;
		if ( file_exists("info.csv") )
		{
			// Apertura del file in append
			$file = fopen("info.csv", "r+");
		}
		else
		{
			$file = fopen("info.csv", "w+");
		}
		// Verifico che non sia già registrato un utente con lo stesso username
		// Iterazione finchè non è stato trovata corrispondenza del login nel file
		// o fino a fine file
		while (!$found && !feof($file) )
		{
			$lineRead = fgets($file);
			$strings = str_getcsv($lineRead, ",", "\"", "\n");
			// Verifica dei dati letti con quelli ricevuti
			if ( $_POST['username'] == $strings[0] )
			{
				// Settaggio del flag
				$found = true;
				//echo "trovato<br>";
			}
		}
		if (!$found)
		{
			// Formazione della stringa da scrivere su file
			$string = "\"".$_POST['username']."\",\"".md5($_POST['password'])."\"\n";
			fwrite($file, $string);
			// Chiusura del file
			fclose($file);
			$log = "Utente registrato";
		}
		else
		{
			$log = "Utente gia' registrato";
		}
	}
?>