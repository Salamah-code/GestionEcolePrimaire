<?php
 // Se connecter à la base de données
	$hostname="localhost";
	$username="root";
	$password="";
	$dbname="gestschool";
   $congestschool=new mysqli($hostname,$username, $password,$dbname);
   mysqli_set_charset($congestschool, "utf8");
?>