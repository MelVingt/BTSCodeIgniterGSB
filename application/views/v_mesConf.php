<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
</head>
<body>
<center>
	<div style = "border-radius : 100px; background : white; width : 33%; padding : 3px;">
		<h1>Mes conférences</h1>
	</div>
	<br>
<?php if($tableau == "") { // si le tableau ne contient aucune conférence on affiche un message
	echo br(4);
	if (!empty($message)){
		echo $message;
		echo br(2);
	}
}
else {?>
	<table border="1">
		<tr>
			<td><b>Nom thème</b></td>
			<td><b>Durée</b></td>
			<td><b>Date</b></td>
			<td><b>Heure</b></td>
			<td><b>Salle</b></td>
			<td><b>Nombre de place</b></td>
			<td><b>Animateur</b></td>
			<td><b>Place dispo.</b></td>
			<td><b>Réserver</b></td>
		</tr>
		<?php echo $tableau; 
	}?>
	</table>
	<?php echo br(2) ?>
	<form method="post" action="pdf">
		<input type="hidden" name="idconf" value="'.$idConf.'" />
		<button type="hidden" type="submit" class="btn btn-primary btn-block btn-large">Générer PDF</button>
	</form>
</center>