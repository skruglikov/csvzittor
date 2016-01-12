<?
	$result = array();
	$brand_prefix = "Marlin";
	$brand_prefix = prefix_generator($brand_prefix);
	echo strtoupper(rand_str($brand_prefix))."<br>";

	$handle = @fopen("tmp_msub/msub_products_12012016.csv/Подводная_охота_Гидрокостюмы-Tаблица_1.csv", "r");
	$output = @fopen("tmp_msub/Подводная_охота_Гидрокостюмы_output.csv", "a");


	if ($handle) {

		while (($buffer = fgets($handle, 4096)) !== false) {

			$temp = explode(";", str_replace(array("\r\n", "\r", "\n"), "", $buffer));

			echo "<pre>";
			print_r($temp);
			echo "</pre>";

			// префикс для артикула
			$prefix = prefix_generator($temp[3]);
			// генерим артикул
			$prop_sku = strtoupper(rand_str($brand_prefix));

			// xml_id
			$result[$prop_sku]["XML_ID"] = $prop_sku;
			// артикул
			$result[$prop_sku]["PROP_SKU"] = $prop_sku;
			// код поставщика
			$result[$prop_sku]["PROP_SUPPLIER"] = $temp[1];
			// название
			$result[$prop_sku]["IE_NAME"] = $temp[2];
			// code
			$result[$prop_sku]["CODE"] = strtolower($prop_sku);
			// [23] => price_price
			$result[$prop_sku]["PRICE"] = trim(currency_generator($temp[23]));
			// [24] => price_currency
			$result[$prop_sku]["CURRENCY"] = $temp[24];
			// [25] => ic_group0
			$result[$prop_sku]["IC_GROUP0"] = $temp[25];
			// [26] => ic_group1
			$result[$prop_sku]["IC_GROUP1"] = $temp[26];

		}
			echo "<pre>";
			print_r($result);
			echo "</pre>";
		

		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}

		fclose($handle);
	}

	// Prefix generator
	function currency_generator($string) {
		$replace_pairs = array("$" => "", "€" => "", "," => ".",);
		return strtr($string, $replace_pairs);
	}

	// Prefix generator
	function prefix_generator($string) {
		$replace_pairs = array("A" => "", "a" => "", "E" => "", "e" => "", "I" => "", "i" => "", "O" => "", "o" => "", "U" => "", "u" => "",);
		return substr(strtr($string, $replace_pairs), 0, 3);
	}
	// Generator of unique numbers
	function rand_str($prefix = false, $length = 7, $chars = "0123456789") {
		// получаем длину строки символов
		$chars_length = (strlen($chars) - 1);
		// Итак, строчка начинается
		$string = $chars{ rand(0, $chars_length) };

		// Генерируем
		for ($i = 1; $i < $length; $i = strlen($string))  {
			// Берем случайный элемент из набора символов
			$r = $chars{rand(0, $chars_length)};
			// Убеждаемся, что соседние символы не совпадают.
			if ($r != $string{$i - 1}) $string .=  $r;
		}

		return $prefix ? $prefix.$string : $string;
	}


?>