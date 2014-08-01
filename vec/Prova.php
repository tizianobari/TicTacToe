<?php 
	session_start();
	
	// Verifica che sia presente una sessione attiva
	if ( isset($_SESSION['username']) )
	{
		include 'paginaBootstrap.php';
	}
	else
{
		// Altrimenti pagina del login
		include 'Login.php';
		/*
		// Verifico che ci siano i parametri nella queryString
		// username, password
		if ( isset($_POST['username']) && isset($_POST['password']) )
		{
			$found = false;
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
					if ( $_POST['username'] == $strings[0] && $_POST['password'] == $strings[1] )
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
				include 'paginaBootstrap.php';
			}
			// Altrimenti login
			else
			{
				include 'Login.php';
			}
		}
		*/
	}
?>