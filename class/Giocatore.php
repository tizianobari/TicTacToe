<?php
	class Giocatore
	{
		// Dichiarazione attributi
		private $name;
		private $score;
		private $numberPlayer;
		private $option;
		
		// Funzione che in base al numero del giocatore setta la X/O
		function setOption()
		{
			// Verifica se il numero del giocatore è 1
			if ( $this->numberPlayer == 1 )
			{
				$this->option = "X";
			}
			else
			{
				$this->option = "O";
			}
		}
		
		public function __set($name, $value)
		{
			//var_dump($name);
			//var_dump($value);
			switch ( $name )
			{
				case "name":
					if ( is_string($value) )
					{
						$this->name = $value;
					}
					break;
				case "score":
					//var_dump($value);
					$this->score = $value;
					break;
			}
		}
		
		public function __get($name)
		{
			//echo $name;
			switch ( $name )
			{
				case "name":
					if ( $this->name != "" )
					{
						$return = $this->name;
					}
					else
					{
						$return = "Giocatore".$this->numberPlayer;
					}
					break;
				case "score":
					$return = $this->score;
					break;
				case "option":
					$return = $this->option;
					break;
				default:
					$return = "";
					break;
			}
			return $return;
		}
		
		// Costruttore
		function __construct($name, $numberPlayer)
		{
			// Inizializzazione attributi
			$this->name = $name;
			$this->numberPlayer = $numberPlayer;
			$this->score = 0;
			// Inizializzazione dell'opzione X/O del giocatore in base al numero del giocatore
			$this->setOption();
		}
		
		// Funzione che quando chiamata aggiunge uno score
		function aggiungiScore()
		{
			$this->score++;
		}
	}
?>