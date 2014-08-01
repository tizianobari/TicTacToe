<?php //include 'controller/loginController.php'; ?>
<!DOCTYPE HTML>
<html>
	<head> 
		<title> Login tris </title>
		<script src="js/jquery-1.11.1.min.js"> </script>
		<script>			
			/*var myRequest = null;

			function CreateXmlHttpReq(handler) {
			  var xmlhttp = null;
			  xmlhttp = new XMLHttpRequest();
			  xmlhttp.onreadystatechange = handler;
			  return xmlhttp;
			}

			function myHandler() {
				if (myRequest.readyState == 4 && myRequest.status == 200) {
					obj = JSON.parse(myRequest.responseText);
					console.log(obj);
					console.log(myRequest.responseText);
					// Verifica dei dati ricevuti in json 
					// Se è presente un errore (1), scrittura del log nel paragrafo id log
					if ( obj.error == "1" )
					{
						document.getElementById("log").innerHTML = obj.log;
					}
					// Altrimenti, il login è riuscito ed è stato settata correttamente
					// la sessione, refresh della pagina
					else
					{
						// Ricarica la pagina
						document.getElementById("log").innerHTML = obj.log;
						location.reload();
					}
				}
			}

			function esempio3() {
				var username = document.getElementById("username").value;
				var password = document.getElementById("password").value;
				var post = "username="+username+"&password="+password;
				myRequest = CreateXmlHttpReq(myHandler);
				myRequest.open("POST","loginAjax.php", true);
				myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				myRequest.send(post);
			}*/
		</script>
	</head>
	<body>
		<h1> <b>Login TicTacToe</b> </h1> <br>
		<!-- <form method="post" action="index.php"> -->
			Username: <input type="text" name="username" id="username"> <br>
			Password: <input type="password" name="password" id="password"> <br>
			<!-- <input type="button" value="Login" onclick="click()"> -->
			<button id="submit"> Login </button>
		<!-- </form> -->
		<!-- <br>  echo isset($log) ? $log : ""  <br> -->
		<br>
		<p id="log">  </p>
		<a href="registrazioneView.php"> Registrazione </a>
		
		<script>
			$(document).ready(function() {
				$("input").keypress(function(event){
					if ( event.which == 13 )
					{
						$("#submit").click();
					}
				})
				$("#submit").click(function() {
					var username = $("#username").val();
					var password = $("#password").val();

					$.ajax({
					  url: "loginAjax.php",
					  data: {
						"username" : username,
						"password" : password
					  },
					  type: "POST"
					})
					.done(function( obj ) {
						console.log(obj);
						//console.log(myRequest.responseText);
						// Verifica dei dati ricevuti in json 
						// Se è presente un errore (1), scrittura del log nel paragrafo id log
						$("#log").html(obj.log);
						if ( obj.error == "0" )
						{
							location.reload();
						}
						// Altrimenti, il login è riuscito ed è stato settata correttamente
						// la sessione, refresh della pagina
					});
				})
			})
		</script>
	</body>
</html>