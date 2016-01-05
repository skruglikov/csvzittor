<?php
	$line = 1;
	$matches = array();
	$prefix = array();

	$handle = @fopen("tmp/versan_epicentr.csv", "r");
	$output = @fopen("tmp/versan_lamptype_output.csv", "a");


	if ($handle) {

		while (($buffer = fgets($handle, 4096)) !== false) {

			$temp = explode(";", str_replace(array("\r\n", "\r", "\n"), "", $buffer));

			if ( !array_key_exists($temp[0], $result) ) {
				// артикул
				// $result[$temp[0]]["prop_sku"] = $temp[0];
				// код поставщика
				// $result[$temp[0]]["prop_supplier"] = $temp[1];
				// название
				// $result[$temp[0]]["prop_name"] = $temp[2];
				// код ean
				// $result[$temp[0]]["prop_ean"] = $temp[8];
				// код upc
				// $result[$temp[0]]["prop_upc"] = $temp[9];
			}

			// if ( $temp[4] == "Высота, мм:" )
			// 	$result[$temp[0]]["prop_height"] = $temp[6];

			// if ( $temp[4] == "Ширина, мм:" )
			// 	$result[$temp[0]]["prop_width"] = $temp[6];

			// if ( $temp[4] == "Высота min, мм:" )
			// 	$result[$temp[0]]["prop_height_min"] = $temp[6];

			// if ( $temp[4] == "Высота max, мм:" )
			// 	$result[$temp[0]]["prop_height_max"] = $temp[6];

			// if ( $temp[4] == "S освещения, м2:" )
			// 	$result[$temp[0]]["prop_area_lighting"] = $temp[6];

			// if ( $temp[4] == "Регулировка по высоте:" )
			// 	$result[$temp[0]]["prop_height_adjustment"] = $temp[6];

			// if ( $temp[4] == "Материал арматуры:" )
				// $result[$temp[0]]["prop_material"] = $temp[6];

			// if ( $temp[4] == "Цвет арматуры:" )
			// 	$result[$temp[0]]["prop_color"] = $temp[6];

			// if ( $temp[4] == "Материал плафона/абажура:" )
			// 	$result[$temp[0]]["prop_ceiling"] = $temp[6];

			// if ( $temp[4] == "Материал плафона/абажура:" )
			// 	$result[$temp[0]]["prop_lampshade_material"] = $temp[6];

			if ( $temp[4] == "Вид ламп:" )
				$result[$temp[0]]["prop_lamp_type"] = $temp[6];

			// if ( $temp[4] == "Цоколь:" )
			// 	$result[$temp[0]]["prop_lamp_base"] = $temp[6];

			// if ( $temp[4] == "Количество ламп:" )
			// 	$result[$temp[0]]["prop_qty"] = $temp[6];

			// if ( $temp[4] == "Максимальная мощность лампы:" )
			// 	$result[$temp[0]]["prop_power_max"] = $temp[6];

			// if ( $temp[4] == "Общая мощность:" )
			// 	$result[$temp[0]]["prop_power_total"] = $temp[6];

			// if ( $temp[4] == "Напряжение:" )
			// 	$result[$temp[0]]["prop_voltage"] = $temp[6];

			// if ( $temp[4] == "Место размешения:" )
			// 	$result[$temp[0]]["prop_location"] = $temp[6];

			// if ( $temp[4] == "Вес брутто, кг:" )
			// 	$result[$temp[0]]["prop_gross"] = $temp[6];

			// if ( $temp[4] == "Возможность подключения диммера:" )
			// 	$result[$temp[0]]["prop_dimmer"] = $temp[6];

			// if ( $temp[4] == "Способ крепления:" )
			// 	$result[$temp[0]]["prop_mounting"] = $temp[6];

			// if ( $temp[4] == "Лампы в комплекте:" )
			// 	$result[$temp[0]]["prop_lamp_included"] = $temp[6];
		}
		

		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}

		fclose($handle);
	}

	// echo "<pre>";
	// print_r($result);
	// echo "</pre>";

	foreach ($result as $key => $value) {
			
		$string = '';
		// необходимо указывать характеристику из массива
		$tmpArr = explode("+", str_replace(array("\r\n", "\r", "\n"), "", $value["prop_lamp_type"]));

		if ( count($tmpArr) == 1 ) {
			$string = $key.",\"".$tmpArr[0]."\"\r";
		}
		if ( count($tmpArr) > 1 ) {
			foreach ( $tmpArr as $value ) {
				$string .= $key.",\"".$value."\"\r";
			}
		}

		if (fwrite($output, $string))
			echo "saved<br>";
		else
			echo "error<br>";
	}
?>
