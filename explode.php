<?php

	$line = 0;
	$headline = array();

	$handle = @fopen("tmp/storage_input.csv", "r");
	$output = @fopen("tmp/storage_output.csv", "a");

	if ($handle) {
	    while (($buffer = fgets($handle, 4096)) !== false) {
	    	
	    	// if ($line == 0)
	    	// 	$headline = explode(";", $buffer);
	    	// else
	    	$result = explode(";", $buffer);
	    	$result[1] = explode(",", str_replace(array("\r\n", "\r", "\n", ""), "", $result[1]));


	    	foreach ($result[1] as $value) {


	    	// 	$value = str_replace(array("\r\n", "\r", "\n"), "", $value);
	    	// 	// $result[$key] = $value ? $value.";\"".$headline[$key]."\"" : "";

	    		$string = str_replace(array("|"), ",", "\"".$result[0]."\",\"".trim($value)."\"\r");


	    		if (fwrite($output, $string))
	    			echo "saved<br>";
	    		else
	    			echo "error<br>";
	    	}

	        $line++;
	    }
	    if (!feof($handle)) {
	        echo "Error: unexpected fgets() fail\n";
	    }
	    fclose($handle);
	    fclose($output);
	}

	// echo "<pre>";
	// print_r($headline);
	// echo "</pre>";
?>