<?php

	$file = fopen("bandera.txt", "r");

	while(!feof($file)) {

		$flag = fgets($file);
		echo "la bandera es: ".$flag."<br>";

	}

	fclose($file);

	++$flag;

	if ($flag == 10) {
		$flag = 1;
	}

	$file = fopen("bandera.txt", "w");

	fwrite($file, $flag);


	fclose($file);

	echo "la nueva bandera es: ".$flag."<br>";

?>