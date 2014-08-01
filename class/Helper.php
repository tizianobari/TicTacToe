<?php
	class Helper
	{
		// Funzione per salvare su file la partita
		static function salvaPartitaFile($grill)
		{
			// Apertura del file
			if ( file_exists('partite.csv') )
			{
				// Apertura del file in lettura/scritura partendo dall'inizio del file
				$file = fopen('partite.csv', 'r+');
			}
			else
			{
				// Apertura/creazione del file in lettura/scrittura partendo dalla fine del file
				$file = fopen("partite.csv", "w+");
			}
			// Verifica della presenza di una partita salvata precedentemente
			$found = false;
			$numberMatch = $_POST['numberMatch'];
			// Iterazione per la ricerca di una partita salvata precedentemente
			while ( !$found && !feof($file) )
			{
				// Lettura del match (riga nel file)
				$matchRead = fgets($file);
				// Suddivisione in un array di stringhe
				$strings = str_getcsv($matchRead,",", "\"", "\n");
				// Verifica esistenza partita
				if ( isset($strings[1]) && $strings[1] == $grill->player1->name && $numberMatch == $strings[6] )
				{
					// Settaggio del flag
					$found = true;
				}
			}
			if ( $found )
			{
				// Se è presente una partita su file, la sostituisco con una riga non valida (tutti 0)
				fseek($file, -strlen($matchRead), SEEK_CUR);
				for ($i=0 ; $i < strlen($matchRead)-1; $i++)
				{
					fwrite($file, 0);
				}
				$test = "\n";
				fwrite($file, $test);
			}
			
			// Alla fine del file scrittura della partita corrente
			fseek($file, 0, SEEK_END);
			// tipoPartita, nomePlayer1, nomePlayer2, scorePlayer1, scorePlayer2, turno, griglia
			$matchWrite = "\"".$grill->challenge."\","."\"".$grill->namePlayer1."\","."\"".$grill->namePlayer2."\",".
						"\"".$grill->scorePlayer1."\","."\"".$grill->scorePlayer2."\","."\"".$grill->turno."\",".
						"\"".$numberMatch."\",";
			// Iterazione per l'inserimento nella stringa della matrice
			for ($index = 0; $index < 9 ; $index++)
			{
				//echo $matchWrite;
				$matchWrite = $matchWrite."\"".$grill->matrix[$index/3][$index%3]."\"";
				( $index != 8 ? $matchWrite = $matchWrite."," : $matchWrite= $matchWrite."\n");
			}
			//echo "<br>".$matchWrite;
			//$matchWrite = $matchWrite."\"1\"\n";
			fwrite($file, $matchWrite);
			// Chiusura del file
			fclose($file);
		}
		
		// Funzione per caricare da file la partita, ritorna la griglia salvata in caso di successo
		static function caricaPartitaFile()
		{
			// Istanza oggetto griglia
			$grill = new Griglia("");
			$numberMatch = $_POST['numberMatch'];
			// Apertura del file
			if ( file_exists('partite.csv') )
			{
				// Apertura del file in lettura/scrittura partendo dall'inizio del file
				$file = fopen('partite.csv', 'r+');
			}
			else
			{
				// Apertura/creazione del file in lettura/scrittura partendo dalla fine del file
				$file = fopen("partite.csv", "w+");
			}
			// Verifica della presenza di una partita salvata precedentemente
			$found = false;
			while ( !$found && !feof($file) )
			{
				// Lettura della partita salvata (riga nel file)
				$matchRead = fgets($file);
				// Suddivisione in un array di stringhe
				$strings = str_getcsv($matchRead ,",", "\"", "\n");
				// Verifica esistenza partita
				if ( isset($strings[1]) && $strings[1] == $grill->player1->name && $numberMatch == $strings[6] )
				{
					// Settaggio del flag
					$found = true;
					//echo "trovata partita<br>";
				}
			}
			// Se è stata trovata la partita, la carico
			if ( $found )
			{
				// tipoPartita, nomePlayer1, nomePlayer2, scorePlayer1, scorePlayer2, turno, numeroPartita, griglia
				$grill->challenge = $strings[0];
				$grill->player1->name = $strings[1];
				$grill->player2->name = $strings[2];
				$grill->player1->score = $strings[3];
				$grill->player2->score = $strings[4];
				$grill->turno = $strings[5];
				// Iterazione per caricare la griglia
				for ( $index = 0, $pedix = 7; $index < 9 ; $index++, $pedix++ )
				{	
					//echo "Mossa:".$strings[$pedix]."<br>";
					//$grill->matrix[$index/3][$index%3] = $strings[$pedix];
					if ($strings[$pedix] == "X")
					{
						//echo "Mossa giocatore<br>";
						$grill->setCasella($index/3, $index%3, $grill->player1);
					}
					elseif ($strings[$pedix] == "O")
					{
						//echo "Mossa computer<br>";
						$grill->setCasella($index/3, $index%3, $grill->player2);
					}
				}
			}
			else
			{
				// Altrimenti valore nullo
				$grill = null;
			}
			// Chiusura del file
			fclose($file);
			
			return $grill;
		}
	}
?>