<?php

if ($_SERVER['SERVER_NAME']=="localhost") {
	// Servidor local/desenvolvimento
	$bd_host="localhost";
	$bd_user="root";
	$bd_password="mysql";
	$bd_database="labirinto";
}
else {
	// Servidor de produção
	$bd_host="localhost";
	$bd_user="usr21";
	$bd_password="dacic2020";
	$bd_database="usr21";
}
