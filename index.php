<?php 
	session_start();
	// Verifica che sia presente una sessione attiva
	if ( isset($_SESSION['username']) )
	{
		include 'view/ticTacToeView.php';
	}
	else
	{
		// Altrimenti pagina del login
		include 'view/loginView.php';	
	}
?>
