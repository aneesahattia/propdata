<?php

	$host      ="localhost";
	$dbname	   ="test";
	$user_name ="root";
	$password  ="";

	try{
		$dbh  = new PDO("mysql:host=$host;dbname=$dbname", $user_name,$password);
		$GLOBALS['dbh'] = $dbh;	
	}catch(PDOexception $e){
		echo 'conection failed'.$e->getMessage();
	}



	
	


	


?>