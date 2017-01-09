<?php

	function print_r2($val) {
		echo '<pre>';
		print_r($val);
		echo  '</pre>';
	}

	function map2darray($Headers, $Elements) {
		//get header names of the table
		foreach($Headers as $Header) {
			$headers_array[] = trim($Header->textContent);
		}
		
		//get table elements and assign integer to row key, and Header to column key
		$elements = 0;
		$rows = 0;
		$noOfHeaders = count($headers_array);
		foreach($Elements as $Element){
			$elements_2darray[$rows][$headers_array[$elements % $noOfHeaders]] = trim($Element->textContent);
			//begin new "row" when $elements reaches 5, 10, 15...
			$elements = $elements + 1;
			if ($elements % $noOfHeaders == 0) {
				$rows = $rows + 1;
			}
		}
		
		return $elements_2darray;
	}

	$htmlContent = file_get_contents("http://www.towerbridge.org.uk/lift-times/");

	$DOM = new DOMDocument();
	//suppress error warnings to PHP
	libxml_use_internal_errors(true);
	$DOM->loadHTML($htmlContent);
	$Headers = $DOM->getElementsByTagName('th');
	$Elements = $DOM->getElementsByTagName('td');
	$table = map2darray($Headers, $Elements);

	date_default_timezone_set('Europe/London');
	$earliestMonth = DateTime::createFromFormat('d M', $table[0]["Date"])->format("m");

	//date-time handling and conversion to ISO8601
	//combination of Date and Time fields into a single Datetime field
	$rows = count($table);
	for($row = 0; $row < $rows; $row++) {
		$dateTime = DateTime::createFromFormat("d MH:i", "{$table[$row]["Date"]}{$table[$row]["Time"]}");
		
		if($dateTime->format("m") < $earliestMonth) {
			$dateTime = $dateTime->modify("+1 year");#handles dates that fall in the following year
		}
		$db[$row]["datetime"] = $dateTime->format("Y-m-d-H-i");
		$db[$row]["vessel"] = $table[$row]["Vessel"];
		$db[$row]["direction"] = $table[$row]["Direction"];
	}

	//implosion of $db for SQL script
	$columns = implode("`, `", array_keys($db[1]));
	$escaped_values = implode("'), ('", array_map(function ($entry) {
	  return implode("','", $entry);
	}, $db));
	$sql = "INSERT IGNORE INTO `lifttimes` (`$columns`) VALUES ('$escaped_values')";
	//echo $sql;
	<?php

	function print_r2($val) {
		echo '<pre>';
		print_r($val);
		echo  '</pre>';
	}

	function map2darray($Headers, $Elements) {
		
		//get header names of the table
		foreach($Headers as $Header) {
			$headers_array[] = trim($Header->textContent);
		}
		
		//get table elements and assign integer to row key, and Header to column key
		$elements = 0;
		$rows = 0;
		$noOfHeaders = count($headers_array);
		foreach($Elements as $Element){
			$elements_2darray[$rows][$headers_array[$elements % $noOfHeaders]] = trim($Element->textContent);
			//begin new "row" when $elements reaches 5, 10, 15...
			$elements = $elements + 1;
			if ($elements % $noOfHeaders == 0) {
				$rows = $rows + 1;
			}
		}
		
		return $elements_2darray;
		echo $elements_2darray;
	}

	$htmlContent = file_get_contents("http://www.towerbridge.org.uk/lift-times/");

	$DOM = new DOMDocument();
	//suppress error warnings to PHP
	libxml_use_internal_errors(true);
	$DOM->loadHTML($htmlContent);
	$Headers = $DOM->getElementsByTagName('th');
	$Elements = $DOM->getElementsByTagName('td');

	if (count($Headers) > 1) {
		$table = map2darray($Headers, $Elements);
		date_default_timezone_set('Europe/London');
		$earliestMonth = DateTime::createFromFormat('d M', $table[0]["Date"])->format("m");
	
		//date-time handling and conversion to ISO8601
		//combination of Date and Time fields into a single Datetime field
		$rows = count($table);
		for($row = 0; $row < $rows; $row++) {
			$dateTime = DateTime::createFromFormat("d MH:i", "{$table[$row]["Date"]}{$table[$row]["Time"]}");
			
			if($dateTime->format("m") < $earliestMonth) {
				$dateTime = $dateTime->modify("+1 year");#handles dates that fall in the following year
			}
			$db[$row]["datetime"] = $dateTime->format("Y-m-d-H-i");
			$db[$row]["vessel"] = $table[$row]["Vessel"];
			$db[$row]["direction"] = $table[$row]["Direction"];
		}
	
		//implosion of $db for SQL script
		$columns = implode("`, `", array_keys($db[1]));
		$escaped_values = implode("'), ('", array_map(function ($entry) {
		  return implode("','", $entry);
		}, $db));
		$sql = "INSERT IGNORE INTO `lifttimes` (`$columns`) VALUES ('$escaped_values')";
	}
	else {
		$sql = "";
	}

	$servername = "***";
	$username = "***";
	$password = "***";
	$dbname = "***";
	$port = ***;
	
	//open log
	$myFile = "***";
	$fh2 = fopen($myFile, 'a');
	if ($fh2 === FALSE) {
		die();
	}
	else {
		$ctime = date('Y-m-d-H-i-s');
		$stringData = "$ctime\t";
		fwrite($fh2, $stringData);

		//create and check connection
		$conn = new mysqli($servername, $username, $password, $dbname, $port);

		if ($conn->connect_error) {
			fwrite($fh2, $conn->connect_error);			
		}
		else if ($conn->multi_query($sql) === TRUE) {
			fwrite($fh2, "update successful");
			$conn->close();
		}
		else {
			fwrite($fh2, $conn->error);
		}
		fwrite($fh2, "\n");
		fclose($fh2);
	}	

?>
