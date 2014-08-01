<?php 
include 'controller/ticTacToeController.php'; ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> Tic Tac Toe </title>
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<style>
			.bottone
			{
				width:45px;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row"align="center">	
				<div class="form-group col-md-2 text-center bg-warning text-info">
					<form action="index.php" method="post">
						<input type="hidden" name="nome1" value="<?php echo $grill->namePlayer1 ?>"> 
						<input type="hidden" name="nome2" value="<?php echo $grill->namePlayer2 ?>">
						<input type="hidden" name="score1" value="<?php echo $grill->scorePlayer1 ?>">
						<input type="hidden" name="score2" value="<?php echo $grill->scorePlayer2 ?>">
						<select class="form-control" name="sfida">
							<option> Player vs Computer </option>
							<option> Player vs Player </option>
						</select>
						<input type="submit" value="Nuova partita" class="btn btn-default">
					</form>
					<a href="logout.php"> Logout </a> 
				</div>
				<form action="index.php" method="post">
					<div class="form-group col-md-2 text-center bg-warning text-info">
						<input type="hidden" name="sfida" value="<?php /* Riprendo il tipo di sfida dalla querystring */ echo isset($_POST['sfida']) ? $_POST['sfida'] : ""; ?>" >
						<input type="text" name="nome1" value="<?php echo $grill->namePlayer1;?>" <?php echo $grill->namePlayer1 != "" && $grill->namePlayer1 != "Giocatore1" ? "readonly" : "" ?> > : 
						<input type="number" name="score1" value="<?php echo $grill->scorePlayer1 ?>" class="form-control" readonly>
						<br>
						<input type="text" name="nome2" value="<?php echo $grill->namePlayer2;?>" <?php echo $grill->namePlayer2 != "" && $grill->namePlayer2 != "Giocatore2" ? "readonly" : "" ?> > :  
						<input type="number" name="score2" value="<?php echo $grill->scorePlayer2?>" class="form-control" readonly>
						<br>
					</div>
					<div class="form-group col-md-2 text-center bg-warning text-info">
						Turno : <input type="number" name="turno" value="<?php echo $grill->turno?>" class="form-control" readonly>
						<br> <?php echo $grill->winner || $grill->turno == 9 ? "" : ( $grill->turno%2==0 ? $grill->namePlayer1."-".$grill->optionPlayer1 : $grill->namePlayer2."-".$grill->optionPlayer2); ?>
						<?php
							// Se la partita è finita scrivo il vincitore della partita
							echo $grill->winner ? "Vincitore: <b>".$grill->giocatoreAttuale->name ."</b>" : ( $grill->turno >= 9 ? "<b> Parita' </b> " : "");
						?>
						<br> <a href="index.php"> Nuova sfida</a>
					</div>
					<div class="col-md-4 col-md-offset-1">
						<div class="bg-warning">
							<div class="row">
								<div class="col-md-offset-2 col-md-2"> 
									<input type="hidden" name="altoSinistraHidden" value="<?php echo $grill->matrix[0][0] ?>">
									<input type="submit" name="altoSinistra" class="<?php echo $grill->matrix[0][0] == "" ? "btn btn-default bottone" : ( $grill->matrix[0][0] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[0][0] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[0][0] != "" ? "disabled" : "") ?>>
								</div>
								<div class="col-md-2"> 
									<input type="submit" name="altoCentro" class="<?php echo $grill->matrix[0][1] == "" ? "btn btn-default bottone" : ( $grill->matrix[0][1] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[0][1] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[0][1] != "" ? "disabled" : "") ?>>
									<input type="hidden" name="altoCentroHidden" value="<?php echo $grill->matrix[0][1] ?>">
								</div>
								<div class="col-md-2">
									<input type="submit" name="altoDestra" class="<?php echo $grill->matrix[0][2] == "" ? "btn btn-default bottone" : ( $grill->matrix[0][2] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[0][2] ?>"<?php echo $grill->winner ? "disabled" : ($grill->matrix[0][2] != "" ? "disabled" : "") ?>> 
									<input type="hidden" name="altoDestraHidden" value="<?php echo $grill->matrix[0][2] ?>">
								</div>
							</div>
							<div class="row" align="center">
								<div class="col-md-offset-2 col-md-2">
									<input type="submit" name="centroSinistra" class="<?php echo $grill->matrix[1][0] == "" ? "btn btn-default bottone" : ( $grill->matrix[1][0] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[1][0] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[1][0] != "" ? "disabled" : "") ?>>
									<input type="hidden" name="centroSinistraHidden" value="<?php echo $grill->matrix[1][0] ?>">
								</div>
								<div class="col-md-2">
									<input type="submit" name="centroCentro" class="<?php echo $grill->matrix[1][1] == "" ? "btn btn-default bottone" : ( $grill->matrix[1][1] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[1][1] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[1][1] != "" ? "disabled" : "") ?>>
									<input type="hidden" name="centroCentroHidden" value="<?php echo $grill->matrix[1][1] ?>">
								</div>
								<div class="col-md-2">
									<input type="submit" name="centroDestra" class="<?php echo $grill->matrix[1][2] == "" ? "btn btn-default bottone" : ( $grill->matrix[1][2] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[1][2] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[1][2] != "" ? "disabled" : "") ?>> 
									<input type="hidden" name="centroDestraHidden" value="<?php echo $grill->matrix[1][2] ?>">
								</div>
							</div>
							<div class="row" align="center">
								<div class="col-md-offset-2 col-md-2"> 
									<input type="submit" name="bassoSinistra" class="<?php echo $grill->matrix[2][0] == "" ? "btn btn-default bottone" : ( $grill->matrix[2][0] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[2][0] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[2][0] != "" ? "disabled" : "") ?>>
									<input type="hidden" name="bassoSinistraHidden" value="<?php echo $grill->matrix[2][0] ?>">
								</div>
								<div class="col-md-2"> 
									<input type="submit" name="bassoCentro" class="<?php echo $grill->matrix[2][1] == "" ? "btn btn-default bottone" : ( $grill->matrix[2][1] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[2][1] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[2][1] != "" ? "disabled" : "") ?>>
									<input type="hidden" name="bassoCentroHidden" value="<?php echo $grill->matrix[2][1] ?>">
								</div>
								<div class="col-md-2"> 
									<input type="submit" name="bassoDestra" class="<?php echo $grill->matrix[2][2] == "" ? "btn btn-default bottone" : ( $grill->matrix[2][2] == "X" ? "btn btn-info" : "btn btn-success"); ?> btn-lg" value="<?php echo $grill->matrix[2][2] ?>" <?php echo $grill->winner ? "disabled" : ($grill->matrix[2][2] != "" ? "disabled" : "") ?>>
									<input type="hidden" name="bassoDestraHidden" value="<?php echo $grill->matrix[2][2] ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 text-center bg-warning text-info">
						<select class="form-control" name="numberMatch">
							<option> Partita 1 </option>
							<option> Partita 2 </option>
							<option> Partita 3 </option>
							<option> Partita 4 </option>
							<option> Partita 5 </option>
						</select>
						<input type="submit" name="salva" value="Salva sfida" <?php echo $grill->winner ? "disabled" : ""; ?>><br>
						<input type="submit" name="carica" value="Carica sfida">
					</div>
						<?php echo isset($log) ? $log : ""; ?>
				</form>
			</div>
		</div>
	</body>
</html>