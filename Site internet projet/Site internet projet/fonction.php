<?php
function connexion()
{
	// ouverture de connexion
	$connection = mysqli_connect("localhost", "user", "user", "pepf");	// force l'envoie de caractète au format UTF8
	mysqli_set_charset($connection , 'utf8');
	// si erreur de connexion
	if ( mysqli_connect_errno()) die("<p>Echec lors de la connexion MySQL</p>");
	return $connection;
}

function close($co)
{
	mysqli_close($co);
}
$c2ooki = 20;
echo "$c2ooki";

function requete($co,$req)
{
	$d = mysqli_query($co, $req);
	return $d;
}

function affichage($data)
{
	
	//print_r ($data);
	
	$nblignes = mysqli_num_rows($data);
	
	echo "<br> il y a $nblignes lignes<br> \n";

	// booléen pour gérer la première ligne
	$first = true;
	
	echo "<table border=1> \n";

	while ($row = mysqli_fetch_assoc($data))  // $data->fetch_assoc()
	
	{
		
		// pour la première ligne
		if ($first)
		{
			$first = false;
			echo '<tr>';
			foreach ($row as $key => $value)
				echo "<th> $key </th>";
			echo "</tr> \n";
		}

		echo '<tr>';
		foreach ($row as $key => $value)
			echo "<td> $value </td>";
		echo "</tr> \n";
		
		//echo'<tr><td>'.$row['nom'].'</td><td>'.$row['emploi'].'</td></tr>';
	}
	echo "</table> \n";
}
?>