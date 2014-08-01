<?php
	class Griglia
	{
		// Dichiarazione attributi
		private $matrix;
		private $winner;
		private $turno;
		private $names;
		private $post;
		// Oggetti giocatore
		private $player1;
		private $player2;
		// Variabile settata per la sfida
		// 0- Player vs Player
		// 1- Player vs Computer
		var $challenge;
			
		public function __set($name, $value)
		{
			switch ($name)
			{
				case "winner":
					// Verifica che il valore da inserire sia un booleano
					if ( is_bool($value) )
					{
						$this->winner = $value;
					}
				break;
				
				case "turno":
					// Verifica che il valore da inserire sia un numero intero
					// e che sia maggiore uguale di 0
					//if ( is_int($value) && $value >= 0 )
					//{
						$this->turno = (int)$value;
					//}
				break;
				
				case "challenge":
					$this->challenge = (int)$value;
					break;
			}
		}
		
		public function __get($name)
		{
			switch ($name)
			{
				case "winner":
					$data = $this->winner;
					break;
				
				case "namePlayer1":
					$data = $this->player1->name;
					break;
					
				case "namePlayer2":
					$data = $this->player2->name;
					break;
				
				case "scorePlayer1":
					$data = $this->player1->score;
					break;
					
				case "scorePlayer2":
					$data = $this->player2->score;
					break;
					
				case "optionPlayer1":
					$data = $this->player1->option;
					break;
					
				case "optionPlayer2":
					$data = $this->player2->option;
					break;
					
				case "player1":
					$data = $this->player1;
					break;
					
				case "player2":
					$data = $this->player2;
					break;
					
				case "matrix":
					$data = $this->matrix;
					break;
				
				case "turno":
					$data = $this->turno;
					break;
							
				case "giocatoreAttuale":
					// Se il numero del turno è paro, è il turno del giocatore 1
					if ($this->turno%2 == 0)
					{
						$data = $this->player1;
					}
					// Altrimenti è turno del giocatore 2 
					else
					{
						$data = $this->player2;
					}
					break;
					
				case "challenge":
					$data = $this->challenge;
					break;
					
				default:
					$data = "";
				break;
			}	
			return $data;
		}
		
		function __construct($post)
		{
			//echo "costruttore";
			// Istanza del nome delle celle
			$this->names = array ( "altoSinistra", "altoCentro", "altoDestra", "centroSinistra", "centroCentro", "centroDestra", 
							 "bassoSinistra", "bassoCentro", "bassoDestra");
			//var_dump($this->names);
			
			// Inizializzazione matrice
			$this->matrix = array();
			
			$this->post = $post;
			
			// Verifica esistenza turno, altrimenti inizializzazione a 0
			//var_dump($post['turno']);
			
			isset($_POST['turno']) ? $this->turno = $_POST['turno'] : $this->turno = 0;
						
			// Iterazione per il riempimento della matrice
			for ( $i=0 ; $i < 3 ; $i++ )
			{
				for ( $j=0; $j<3; $j++)
				{
					$index = $i*3 + $j;
					// 
					$this->matrix[$i][$j] = isset($this->post[$this->names[$index]."Hidden"]) ? $this->post[$this->names[$index]."Hidden"] : "";
				}
			}
			
			// Istanza dei giocatori
			$this->player1 = new Giocatore(isset($_SESSION['username']) ? $_SESSION['username'] : "", 1);
			// Se è stato impostata una modalità di sfida
			if ( isset($_POST['sfida']) )
			{
				// Creo il giocatore umano
				if ( $_POST['sfida'] == "Player vs Player" )
				{
					//echo "partita umana";
					$this->challenge = 0;
					$this->player2 = new Giocatore(isset($_POST['nome2']) ? $_POST['nome2'] : "", 2);
				}
				// Altrimenti partita vs il computer
				else
				{
					//echo "partita computer";
					$this->challenge = 1;
					$this->player2 = new Computer(isset($_POST['nome2']) ? $_POST['nome2'] : "", 2);
				}
			}
			// Se non è impostata, automaticamente partita vs IA
			else
			{
				//echo "partita computer al";
				$this->challenge = 1;
				$this->player2 = new Computer(isset($_POST['nome2']) ? $_POST['nome2'] : "", 2);
			}
			
			//echo "Nome player1: ".$this->player1->name;
			//echo "Nome player2: ".$this->player2->name;
			
			// Lettura score precedenti
			// var_dump($_POST['score1']);
			isset($_POST['score2']) ? $this->player2->score = $_POST['score2'] : "";
			isset($_POST['score1']) ? $this->player1->score = $_POST['score1'] : "";
						
			// La partita è in corso, non c'è un vincitore
			$this->winner = false;
		}
		
		// Funzione che verifica che ci sia una riga vincente
		function verificaRigaVincente($row)
		{
			$checked = true;
			// Salvo la prima cella della riga per effettuare i confronti successivamente 
			$cell = $this->matrix[$row][0];
			// Iterazione per la verifica
			for ( $index = 1; $index < 3 && $checked ; $index++ )
			{
				// Verifico che la cella attuale sia diversa da quella salvata
				// o che la cella attuale sia vuota, così che la riga sia perdente
				if ( $this->matrix[$row][$index] != $cell || $this->matrix[$row][$index] == "")
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
		function verificaColonnaVincente($column)
		{
			$checked = true;
			// Salvo la prima cella della colonna per effettuare i confronti successivamente
			$cell = $this->matrix[0][$column];
			// Iterazione per la verifica
			for ( $index = 1; $index < 3 && $checked; $index++ )
			{
				// Se la cella corrente è diversa dalla prima oppure la cella sia vuota
				// allora non è la colonna vincente
				if ( $this->matrix[$index][$column] != $cell || $this->matrix[$index][$column] == "")
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
		function verificaDiagonaleVincente()
		{
			// Setto il flag
			$checked = true;
			
			// Salvo la prima cella in alto a sinistra per effettuare i controlli successivamente
			$cell = $this->matrix[0][0];
			
			// Iterazione per verificare la prima diagonale vincente (da sinistra verso destra)
			for ( $index = 1 ; $index < 3 ; $index++ )
			{
				// Se la cella corrente è diversa da quella precedentemente salvata
				// oppure che la cella sia vuota allora non è la diagonale vincente
				if ( $this->matrix[$index][$index] != $cell || $this->matrix[$index][$index] == "" )
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
				$cell = $this->matrix[2][0];
				// Iterazione per verificare la seconda diagonale vincente (da sinistra verso destra)
				for ( $row = 1 , $column = 1 ; $row >= 0 && $column < 3 ; $row--, $column++ )
				{
					// Se la cella corrente è diversa da quella precedentemente salvata 
					// oppure che la cella sia vuota allora non è la diagonale vincente
					if ( $this->matrix[$row][$column] != $cell || $this->matrix[$row][$column] == "" )
					{
						$checked = false;
					}
				}
			}	
			return $checked;
		}
		
		// Funzione per settare l'opzione X/O nella casella
		function setCasella($row, $column, $player)
		{
			// Verifico che la casella sia vuota
			if ( $this->matrix[$row][$column] == "" )
			{
				// Verifico che sia una opzione valida
				if ( $player->option == "X" || $player->option == "O" || $player->option == "" )
				{
					// Settaggio dell'opzione nella cella
					$this->matrix[$row][$column] = $player->option;
					//echo "Opzione messa: ";
					//echo $this->matrix[$row][$column];
				}
			}
		}
		
		// Funzione per la ricerca della chiave della cella da modificare
		function ricercaCella()
		{
			// Ricerca della cella da modificare
			foreach($this->post as $key=>$key_value)
			{
				// Ricerca della chiave 
				$index = array_search($key, $this->names);
				if ( $index !== false )
				{
					$return = $index;
				}
			}
			return $return;
		}
		
		// Ritorna booleano se qualcuno ha vinto
		function verificaVincita()
		{
			// Iterazione per la verifica di combinazioni vincenti orizzontali n 3
			$index = 0;
			while ( $index < 3 && !$this->winner)
			{
				$this->winner = $this->verificaRigaVincente($index);
				$index++;
			}
			
			// Se non è stata trovata la riga vincente passo alle altre combinazioni
			if ( !$this->winner )
			{
				//echo "sono qui";
				// Iterazione per la verifica di combinazioni vincenti verticali n 3
				$index = 0;
				while ( $index < 3 && !$this->winner )
				{
					$this->winner = $this->verificaColonnaVincente($index);
					$index++;
				}
				
				// Se non è stata ancora trovata la combinazione vincente
				if (!$this->winner)
				{
					// Verifica di combinazioni vincenti obliqui n 2
					$this->winner = $this->verificaDiagonaleVincente();
				}
			}
			return $this->winner;
		}
		
		// Funzione ritorna giocatore in base al numero del turno
		/*
		function getGiocatoreAttuale()
		{
			// Se il numero del turno è paro, è il turno del giocatore 1
			if ($this->turno%2 == 0)
			{
				$player = $this->player1;
			}
			// Altrimenti è turno del giocatore 2 
			else
			{
				$player = $this->player2;
			}
			return $player;
		}
		*/
	}
?>