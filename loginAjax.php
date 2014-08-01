<?php session_start();
	// Impostazione del content-type
	header('Content-type: application/json');
	// Verifico che ci siano i parametri nella queryString
	// username, password
	$found = false;
	
	if ( isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != "" && $_POST['password'] != "")
	{

		// Verifico che i dati siano giusti, confrontandoli nel file con i login (info.csv)
		$file = fopen("info.csv", "r");
		
		// Verifica che il file sia stato aperto correttamente
		if ( $file !== false )
		{
			// Iterazione finchè non è stato trovata corrispondenza del login nel file
			// o fino a fine file
			while (!$found && !feof($file) )
			{
				$lineRead = fgets($file);
				$strings = str_getcsv($lineRead, ",", "\"", "\n");
				// Verifica dei dati letti con quelli ricevuti
				if ( $_POST['username'] == $strings[0] && md5($_POST['password']) == $strings[1] )
				{
					// Settaggio del flag
					$found = true;
				}
			}
		}
		// Se c'è corrispondenza nel file, pagina del gioco
		if ($found)
		{
			// Setto l'username nella sessione
			$_SESSION['username'] = $_POST['username'];
			$log = "Login corretto";
		}
		else
		{
			$log = "Utente e/o password errati";
		}
	}
	else
	{
		$log = "Inserire username e/o password";
	}
	
	$json = array();
	$json["error"] = $found ? "0" : "1";
	$json["log"] = $log;
	
	echo json_encode($json);
?>