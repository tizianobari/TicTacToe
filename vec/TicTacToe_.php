<?php
	// Gioco del tris
	// Tre bottoni(submit, e campo hidden contenente lo stato della cella) per tre righe
	// Due giocatori, 1° X / 2° O
		
	// Funzione per inizializzare la matrice
	function inizializzaMatrice($get, $names)
	{
		// Array di appoggio
		$app = array();
		// Iterazione per il riempimento della matrice
		for ( $i=0 ; $i < 3 ; $i++ )
		{
			for ( $j=0; $j<3; $j++)
			{
				$index = $i*3 + $j;
				$app[$i][$j] = isset($get[$names[$index]."Hidden"]) ? $get[$names[$index]."Hidden"] : "";
			}
		}
		return $app;
	}
	
	// Funzione che verifica che ci si una riga vincente
	function verificaRigaVincente($matrix, $row)
	{
		$checked = true;
		// Salvo la prima cella della riga per effettuare i confronti successivamente 
		$cell = $matrix[$row][0];
		// Iterazione per la verifica
		for ( $index = 1; $index < 3 && $checked ; $index++ )
		{
			// Verifico che la cella attuale sia diversa da quella salvata
			// o che la cella attuale sia vuota, così che la riga sia perdente
			if ( $matrix[$row][$index] != $cell || $matrix[$row][$index] == "")
			{
				//echo "Riga perdente<br>";
				$checked = false;
			}
		}
		/*
		echo "riga " . $row . "vincente = ";
		var_dump($checked);
		echo "<br>";
		*/
		return $checked;
	}
	
	// Funzione che verifica che ci sia una colonna vincente
	function verificaColonnaVincente($matrix, $column)
	{
		$checked = true;
		// Salvo la prima cella della colonna per effettuare i confronti successivamente
		$cell = $matrix[0][$column];
		// Iterazione per la verifica
		for ( $index = 1; $index < 3 && $checked; $index++ )
		{
			// Se la cella corrente è diversa dalla prima oppure la cella sia vuota
			// allora non è la colonna vincente
			if ( $matrix[$index][$column] != $cell || $matrix[$index][$column] == "")
			{
				$checked = false;
			}
		}
		/*
		echo "colonna " . $column . "vincente = ";
		var_dump($checked);
		echo "<br>";
		*/
		return $checked;
	}
	
	// Funzione che verifica che ci sia una diagonale vincente
	function verificaDiagonaleVincente($matrix)
	{
		// Setto il flag
		$checked = true;
		
		// Salvo la prima cella in alto a sinistra per effettuare i controlli successivamente
		$cell = $matrix[0][0];
		
		// Iterazione per verificare la prima diagonale vincente (da sinistra verso destra)
		for ( $index = 1 ; $index < 3 ; $index++ )
		{
			// Se la cella corrente è diversa da quella precedentemente salvata
			// oppure che la cella sia vuota allora non è la diagonale vincente
			if ( $matrix[$index][$index] != $cell || $matrix[$index][$index] == "" )
			{
				$checked = false;
			}
		}
		
		// Se la prima diagonale non è quella vincente, cerco la seconda diagonale 
		if ( !$checked )
		{
			// Setto il flag a true
			$checked = true;
			// Salvo la prima cella in basso a sinistra, riga 2 colonna 0
			$cell = $matrix[2][0];
			// Iterazione per verificare la seconda diagonale vincente (da sinistra verso destra)
			for ( $row = 1 , $column = 1 ; $row >= 0 && $column < 3 ; $row--, $column++ )
			{
				// Se la cella corrente è diversa da quella precedentemente salvata 
				// oppure che la cella sia vuota allora non è la diagonale vincente
				if ( $matrix[$row][$column] != $cell || $matrix[$row][$column] == "" )
				{
					$checked = false;
				}
			}
		}	
		return $checked;
	}
	
	// Ritorna booleano se qualcuno ha vinto
	function verificaVincita($matrix)
	{
		// Iterazione per la verifica di combinazioni vincenti orizzontali n 3
		$index = 0;
		$found = false;
		while ( $index < 3 && !$found)
		{
			$found = verificaRigaVincente($matrix, $index);
			$index++;
		}
		
		// Se non è stata trovata la riga vincente passo alle altre combinazioni
		if ( !$found )
		{
			//echo "sono qui";
			// Iterazione per la verifica di combinazioni vincenti verticali n 3
			$index = 0;
			while ( $index < 3 && !$found )
			{
				$found = verificaColonnaVincente($matrix, $index);
				$index++;
			}
			
			// Se non è stata ancora trovata la combinazione vincente
			if (!$found)
			{
				// Verifica di combinazioni vincenti obliqui n 2
				$found = verificaDiagonaleVincente($matrix);
			}
		}
		return $found;
	}

	// names contiene il nome delle celle della griglia
	$names = array ( "altoSinistra", "altoCentro", "altoDestra", "centroSinistra", "centroCentro", "centroDestra", 
					 "bassoSinistra", "bassoCentro", "bassoDestra");
	
	// Verifica esistenza turno, altrimenti inizializzazione a 0
	isset($_POST['turno']) ? $turno = $_POST['turno'] : $turno = 0;
	
	// Inizializzazione della matrice
	$matrix = inizializzaMatrice($_POST, $names);
	
	// Inizializzazione flag di vittoria 
	$winner = false;
	
	// Verifico che ci siano parametri nella querystring
	if ( count($_POST) != 0 )
	{
		// var_dump($_POST);
		// Ricerca della cella da modificare
		foreach($_POST as $key=>$key_value)
		{
			// Ricerca della chiave 
			$index = array_search($key, $names);
			if ($index !== false)
			{
				// Verifica che non vi sia già presente un valore X / O
				//if ( $_POST[$names[$index]."Hidden"] == "" )
				//{
					// Verifica turno dell'utente
					/*
					echo "NUMERO:";
					var_dump($turno);
					*/
					// Se il numero del turno è paro, è turno del giocatore 1
					if ($turno%2 == 0)
					{
						$matrix[$index/3][$index%3] = "X";
					}
					// Altrimenti è turno del giocatore 2 
					else
					{
						$matrix[$index/3][$index%3] = "O";
					}					
					// Passaggio al turno successivo
					$turno = $turno + 1;
					// Verifica che uno dei due giocatori abbia vinto
					// 8 casi vincenti
					if ( verificaVincita($matrix) )
					{
						//echo "Vincitore al turno ".$turno;
						// Setto il flag true, perchè c'è un vincitore
						$winner = true;
					}
				//}
				// Altrimenti mossa non valida, ripete il turno
			}
		}	
	}
	//var_dump($matrix);
?>