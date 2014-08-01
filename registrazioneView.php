<?php //include 'controller/registrazioneController.php'; ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> Registrazione tris </title>
		<script src="js/jquery-1.11.1.min.js"> </script>
	</head>
	<body>
		<h1> <b> Registrazione </b> </h1>
		<!-- <form method="post" action="registrazioneView.php"> -->
			<input type="text" name="username" id="username">
			<input type="password" name="password" id="password">
			<button id="submit"> Registra </button>
		<!-- </form> -->
		<br> <p id="log"> </p>
		<a href="index.php"> Login </a>
		<script>
			// Chiamata della callback quando è stata renderizzata la pagina
			$(document).ready(function() {
				// Quando nei campi input viene schiacciato il pulsante invio (13)
				$("input").keypress(function(event){
					if ( event.which == 13 )
					{
						// Chiamata della funzione da effettuare quando viene cliccato
						$("#submit").click();
					}
				})
				// Chiamata della callback quando viene cliccato il bottone con id "submit"
				$("#submit").click(function() {
					// Ottengo i dati della registrazione dai form dati i loro id
					var username = $("#username").val();
					var password = $("#password").val();
					$.ajax({
						url: "registrazioneAjax.php",
						data: {
							"username" : username,
							"password" : password
						},
						type: "POST"
					})
					// Chiamata della callback quando è stata ricevuta risposta
					.done(function(obj){
						console.log(obj);
						$("#log").html(obj.log);
					});
				})
			})
		</script>
	</body>
</html>