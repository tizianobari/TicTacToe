<!DOCTYPE HTML>
<?php include 'TicTacToe.php' ?>
<html>
	<head>
		<title> Pagina web </title>
		<style>
			.informazioni
			{
				width: 170px;
				text-align: center;
			}
			.buttons
			{
				width: 70px;
				height: 70px;
			}
		</style>
	</head>
	<body>
		<table border="1" align="center">
			<form action="pagina.php" method="post">
				<tr>
					<td class="informazioni"> <br>Turno : <input type="number" style="width:25px;" name="turno" value="<?php echo $turno?>" readonly> </td>				
					<td> 
						<input type="submit" name="altoSinistra" class="buttons" value="<?php echo $matrix[0][0] ?>" <?php echo $winner ? "disabled" : ($matrix[0][0] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="altoSinistraHidden" value="<?php echo $matrix[0][0] ?>">
					</td>
					<td>
						<input type="submit" name="altoCentro" class="buttons" value="<?php echo $matrix[0][1] ?>" <?php echo $winner ? "disabled" : ($matrix[0][1] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="altoCentroHidden" value="<?php echo $matrix[0][1] ?>">
					</td>
					<td>
						<input type="submit" name="altoDestra" class="buttons" value="<?php echo $matrix[0][2] ?>"<?php echo $winner ? "disabled" : ($matrix[0][2] != "" ? "disabled" : "") ?>> 
						<input type="hidden" name="altoDestraHidden" value="<?php echo $matrix[0][2] ?>">
					</td>
				</tr>
				<tr>
					<td class="informazioni"> <br> <?php echo $winner ? "<br>" : ( $turno%2==0 ? " Giocatore 1 - X" : "Giocatore 2 - O"); ?> </td>
					<td>
						<input type="submit" name="centroSinistra" class="buttons" value="<?php echo $matrix[1][0] ?>" <?php echo $winner ? "disabled" : ($matrix[1][0] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="centroSinistraHidden" value="<?php echo $matrix[1][0] ?>">
					</td>
					<td>
						<input type="submit" name="centroCentro" class="buttons" value="<?php echo $matrix[1][1] ?>" <?php echo $winner ? "disabled" : ($matrix[1][1] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="centroCentroHidden" value="<?php echo $matrix[1][1] ?>">
					</td>
					<td>
						<input type="submit" name="centroDestra" class="buttons" value="<?php echo $matrix[1][2] ?>" <?php echo $winner ? "disabled" : ($matrix[1][2] != "" ? "disabled" : "") ?>> 
						<input type="hidden" name="centroDestraHidden" value="<?php echo $matrix[1][2] ?>"> <br>
					</td>
				</tr>
				<tr>
					<td class="informazioni"> 		
						<?php
							// Se la partita è finita scrivo il vincitore della partita
							echo $winner ? ( $turno%2 == 0 ? "Vincitore <b>GIOCATORE 2</b><br>" : "Vincitore <b>GIOCATORE 1</b><br>" ) : "<br>";
						?>
						<a href="pagina.php"> Nuova partita </a>
					</td>
					<td>
						<input type="submit" name="bassoSinistra" class="buttons" value="<?php echo $matrix[2][0] ?>" <?php echo $winner ? "disabled" : ($matrix[2][0] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="bassoSinistraHidden" value="<?php echo $matrix[2][0] ?>">
					</td>
					<td>
						<input type="submit" name="bassoCentro" class="buttons" value="<?php echo $matrix[2][1] ?>" <?php echo $winner ? "disabled" : ($matrix[2][1] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="bassoCentroHidden" value="<?php echo $matrix[2][1] ?>">
					</td>
					<td>
						<input type="submit" name="bassoDestra" class="buttons" value="<?php echo $matrix[2][2] ?>" <?php echo $winner ? "disabled" : ($matrix[2][2] != "" ? "disabled" : "") ?>>
						<input type="hidden" name="bassoDestraHidden" value="<?php echo $matrix[2][2] ?>">	<br>
					</td>
				</tr>
			</form>
		</table>
	</body>
</html>
