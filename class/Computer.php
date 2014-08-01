<?php
	class Computer extends Giocatore
	{	
		// Costruttore
		function __construct($name, $numberPlayer)
		{
			// Chiamata costruttore superclasse
			parent::__construct($name, $numberPlayer);
			//var_dump($this);
			//$this->name = "IA";
		}
		
		// Funzione che ricerca la mossa più probabile da effettuare
		// ritorna indice del vettore delle celle
		// Array 9 elementi: ogni elemento c'è l'opzione della griglia di gioco
		//   0   1   2   3   4   5   6   7   8  
		// | X |   | O |   | X |   |   |   |   |   8-O mossa teorica
		// | X |   | O |   | X |   | X |   | O |   5-O mossa vincente
		// | X |   | O |   | X | O | X |   | O |
		
		// 2° parametro: numero =  0 ricerca probabile mossa perdente
		//						   1 ricerca probabile mossa vincente	
		// 						   2 ricerca logica della mossa
		function ricercaMossaRiga($grill, $logic)
		{
			$found = false;
			// Verifica se c'è la possibilità di vittoria/perdita nelle righe
			// Righe 0-1-2 3-4-5 6-7-8
			for ($count = 0; $count < 3 && !$found ; $count++)
			{
				$computerOptions = 0;
				$opponentOptions = 0;
				for ( $pedix = 0 ; $pedix < 3 && !$found ; $pedix=$pedix+1 )
				{
					// Se non è vuota la cella, registro di chi è la mossa
					if ( $grill->matrix[$count][$pedix] != "" )
					{
						$grill->matrix[$count][$pedix] == $this->option ? $computerOptions++ : $opponentOptions++;
					}
					// Altrimenti, registrazione dell'indice della cella libera
					else
					{
						$index = $count*3 + $pedix;
						//echo "CONTROLLO RIGA: cella libera in".$index."<br>";
					}
				}
				
				// Casi favorevoli: 2 opzioni del computer (mossa vincente) /
				//				    2 opzioni dell'avversario (mossa perdente)
				// 					e che non sia piena la riga/colonna/diagonale
				
				if ( $logic === 1 && $computerOptions == 2 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;					
				}
				elseif ( $logic === 0 && $opponentOptions == 2 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
				elseif ( $logic === 2 && $computerOptions==1 && $opponentOptions != 1 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
			}
			if ( !$found )
			{
				$index = -1;
			}
			return $index;
		}
		
		function ricercaMossaColonna($grill, $logic)
		{
			$found = false;
			// Verifico se c'è possibilità di vittoria/perdita nelle colonne
			for ( $count = 0; $count < 3 && !$found ; $count++ )
			{
				$computerOptions = 0;
				$opponentOptions = 0;
				for ($pedix = $count ; $pedix < 9 && !$found ; $pedix=$pedix+3 )
				{
					// Colonne 0-3-6 1-4-7 2-5-8
					// Se non è vuota la cella, registro di chi è la mossa
					if ( $grill->matrix[$pedix/3][$pedix%3] != "" )
					{
						$grill->matrix[$pedix/3][$pedix%3] == $this->option ? $computerOptions++ : $opponentOptions++;
						
					}
					// Altrimenti, mi registro l'indice dove è libera la cella
					else 
					{
						$index = $pedix;
						//echo "CONTROLLO COLONNE: cella libera in".$index."<br>";
					}
				}
				// Casi favorevoli: 2 opzioni del computer (mossa vincente) /
				//				    2 opzioni dell'avversario (mossa perdente)
				// 					e che non sia piena la riga/colonna/diagonale
				
				if ( $logic === 1 && $computerOptions == 2 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;					
				}
				elseif ( $logic === 0 && $opponentOptions == 2 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
				elseif ( $logic === 2 && $computerOptions==1 && $opponentOptions != 1 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
				/*
				if ( ($opponentOptions == 2 || $computerOptions == 2)  &&
					 ($opponentOptions+$computerOptions != 3) 		  )
				{
					echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
				*/
			}
			if (!$found)
			{
				$index = -1;
			}
			return $index;
		}
		
		function ricercaMossaDiagonale($grill, $logic)
		{
			$found = false;
			$opponentOptions = 0;
			$computerOptions = 0;
			// Verifica se c'è la possibilità di vittoria/perdita nelle righe
			// Diagonali 0-4-8 2-4-6
			for ($count = 0; $count < 3 ; $count++)
			{
				// Diagonale 0-4-8
				// Se non è vuota la cella, registro di chi è la mossa
				if ( $grill->matrix[$count][$count] != "" )
				{
					$grill->matrix[$count][$count] == $this->option ? $computerOptions++ : $opponentOptions++;
				}
				// Altrimenti, registrazione dell'indice della cella libera
				else
				{	
					$index = $count*3 + $count;
					//echo "CONTROLLO DIAGONALE 0-4-8 cella libera in".$index."<br>";
				}
			}
			// Casi favorevoli: 2 opzioni del computer (mossa vincente) /
			//				    2 opzioni dell'avversario (mossa perdente)
			// 					e che non sia piena la riga/colonna/diagonale
			if ( $logic === 1 && $computerOptions == 2 && $opponentOptions+$computerOptions != 3 )
			{
				//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
				$found = true;					
			}
			elseif ( $logic === 0 && $opponentOptions == 2 && $opponentOptions+$computerOptions != 3 )
			{
				//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
				$found = true;
			}
			elseif ( $logic === 2 && $computerOptions==1 && $opponentOptions != 1 && $opponentOptions+$computerOptions != 3 )
			{
				//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
				$found = true;
			}
			else
			{
				$computerOptions = 0;
				$opponentOptions = 0;
				// Diagonale 2-4-6
				for ( $count=0, $pedix=2 ; $count < 3 && $pedix >= 0 ; $count++, $pedix-- )
				{
					// Se non è vuota la cella, registro di chi è la mossa
					if ( $grill->matrix[$count][$pedix] != "" )
					{
						$grill->matrix[$count][$pedix] == $this->option ? $computerOptions++ : $opponentOptions++;
					}
					// Altrimenti, registrazione dell'indice della cella libera
					else
					{
						$index = $count*3 + $pedix;
						//echo "CONTROLLO SECONDA DIAGONALE cella libera in".$index."<br>";
					}
				}
				// Casi favorevoli: 2 opzioni del computer (mossa vincente) /
				//				    2 opzioni dell'avversario (mossa perdente)
				// 					e che non sia piena la riga/colonna/diagonale
				
				if ( $logic === 1 && $computerOptions == 2 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;					
				}
				elseif ( $logic === 0 && $opponentOptions == 2 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
				elseif ( $logic === 2 && $computerOptions==1 && $opponentOptions != 1 && $opponentOptions+$computerOptions != 3 )
				{
					//echo "Trovata mossa. Mosse avv. : ".$opponentOptions. " Mosse comp. : ".$computerOptions;
					$found = true;
				}
			}
			// Se non è stata trovata la mossa
			if ( !$found ) 
			{
				$index = -1;
			}
			return $index;
		}
		
		// In base all'intero $logic
		// 0 = cerca mossa perdente
		// 1 = cerca mossa vincente
		// 2 = cerca mossa logica
		function cercaMossa($grill, $logic)
		{
			// Chiamata delle funzioni per la ricerca della mossa vincente
			// Ricerca riga
			$index = $this->ricercaMossaRiga($grill, $logic);
			if ($index == -1)
			{
				// Ricerca colonna
				$index = $this->ricercaMossaColonna($grill, $logic);
				if ( $index == -1 )
				{
					// Ricerca diagonali
					$index = $this->ricercaMossaDiagonale($grill, $logic);
				}
			}
			return $index;
		}
				
		function generaAzione($grill)
		{	
			// Verifica mossa vincente
			//echo "Cerca mossa vincente<br>";
			$index = $this->cercaMossa($grill, 1);
			// Se non è presente una mossa per vincere
			if ( $index == -1 )
			{
				//echo "Cerca mossa da ostacolare <br>";
				// Ricerca della mossa da ostacolare
				$index = $this->cercaMossa($grill, 0);
				// Se non è presente nessuna mossa vincente/perdente, mossa logica
				if ( $index == -1 )
				{
					//echo "Cerca mossa logica <br>";
					$index = $this->cercaMossa($grill, 2);
					if ( $index == -1 )
					{
						// Nessuna mossa logica, mossa casuale
						//echo "Mossa casuale <br>";
						$free = array();
						for ( $i=0 ; $i < 9 ; $i++ )
						{
							if ( $grill->matrix[$i/3][$i%3] == "" )
							{
								$free[] = $i;
							}
						}
						if (count($free) > 0)
						{
							//var_dump($free);
							$rand = rand(0, count($free)-1);
							$grill->setCasella($free[$rand]/3, $free[$rand]%3, $this);
						}
					}
					else
					{
						$grill->setCasella($index/3, $index%3, $this);
					}
					
				}
				else
				{
					$grill->setCasella($index/3, $index%3, $this);
				}
			}
			else
			{
				// Setto la casella
				$grill->setCasella($index/3, $index%3, $this);
			}
			//var_dump($index);
		}
	}
?>