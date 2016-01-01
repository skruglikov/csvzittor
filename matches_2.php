<?php

	$line = 0;
	$matches = array();
	$pattern = "([0-9]{1,})";

	$handle = @fopen("tmp/matches_trimming_inputfile.csv", "r");
	$output = @fopen("tmp/matches_trimming_outputfile.csv", "a");

	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			// preg_match($pattern, $buffer, $matches[]);

			$result = explode(";", $buffer);
			$result[1] = explode(",", $result[1]);

			foreach ($result[1] as $value) {
				$string = $value ? trim($result[0]).",\"".trim($value)."\"\r" : "";

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
	}
?>