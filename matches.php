<?php

	$line = 0;
	$matches = array();
	$pattern = "([0-9]{1,})";

	$handle = @fopen("tmp/matches_branch_inputfile.csv", "r");
	$output = @fopen("tmp/matches_branch_outputfile.csv", "a");

	if ($handle) {
	    while (($buffer = fgets($handle, 4096)) !== false) {
	        preg_match($pattern, $buffer, $matches);

	        $result = str_replace("х", $matches[0], $buffer);
	        
	        echo $result."<br>";
	        
	        $line++;

	        if (fwrite($output, $result))
	        	echo "saved<br>";
	        else
	        	echo "error<br>";
	    }
	    if (!feof($handle)) {
	        echo "Error: unexpected fgets() fail\n";
	    }
	    fclose($handle);
	}
?>