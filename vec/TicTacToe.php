<?php //session_start();
	// Gioco del tris
	// Tre bottoni(submit, e campo hidden contenente lo stato della cella) per tre righe
	// Due giocatori, 1° X / 2° O
	include 'Griglia.php';
	include 'Giocatore.php';
	include 'Computer.php';
	
	var_dump($_SESSION);
	$grill = new Griglia($_POST);
	
	//var_dump($_POST);
	
	// Verifico che ci siano parametri nella querystring oltre agli score e ai nomi dei giocatori
	if ( count($_POST) > 5 )
	{		
		$index = $grill->ricercaCella();
		if ( $index !== false )
		{
			$grill->setCasella($index/3, $index%3, $grill->giocatoreAttuale);
			
			// Passaggio al turno successivo
			//$grill->turno = $grill->turno +1 ;						
			
			// Verifica che uno dei due giocatori abbia vinto
			// 8 casi vincenti				
			if ( $grill->verificaVincita() )
			{
				// Incremento lo score del vincitore
				$grill->giocatoreAttuale->aggiungiScore();
			}
			else
			{
				// Altrimenti passaggio al turno successivo
				$grill->turno = $grill->turno +1 ;
				
				// Turno eventuale del computer
				// Verifica se c'è un giocatore controllato dal computer 
				// ottenendo il nome della classe dell'oggetto player2
				if ( get_class($grill->player2) == "Computer" )
				{
					// echo "<br>computer<br>";
					// Chiamata funzione per la mossa casuale
					$grill->player2->generaAzione($grill);
					// Finito il turno del computer verifico che la partita non sia finita
					if ($grill->verificaVincita())
					{
						// Incremento lo score del vincitore
						$grill->giocatoreAttuale->aggiungiScore();
						
					}
					else
					{
						// Altrimenti al passaggio al turno successivo
						$grill->turno = $grill->turno+1;
					}
				}
			}
		}	
		// Altrimenti mossa non valida, ripete il turno	
	}
	//var_dump($matrix);
?>