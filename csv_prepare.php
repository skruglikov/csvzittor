<?php

	$line = 1;
	$matches = array();
	$prefix = array();

	$handle = @fopen("tmp/iblock_element_text2.csv", "r");
	$output = @fopen("tmp/iblock_element_text2_output.csv", "a");


	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			$result = explode(";|;", str_replace(array("\r\n", "\r", "\n"), "", $buffer));

			if (count($result) == 2) {
				$matches[$result[0]] = $result;
			}

			if (count($result) == 1) {
				$prefix[--$line] = $result;
			}
			$line++;
		}
		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}
		fclose($handle);
	}

	foreach ($matches as $key => $value) {
		$matches[$key][1] = $value[1].$prefix[$key][0];

		$string = "\"".$matches[$key][0]."\",\"".$matches[$key][1]."\"\r";
	
		if (fwrite($output, $string))
			echo "saved<br>";
		else
			echo "error<br>";
	}

	// echo "<pre>";
	// print_r($matches);
	// echo "</pre>";

	// echo "<pre>";
	// print_r($prefix);
	// echo "</pre>";
?>
