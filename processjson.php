<?php

	$myFile = "data.json";
	$arr_data = array(); // create empty array
	$target_dir = "uploads/";
   	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$dirname = uniqid();
	$new_dir = "/var/www/html/worker/uploads/".$dirname;
	mkdir($new_dir, 0777);	
	
	//Get data from existing json file
	$jsondata = file_get_contents($myFile);

	// converts json data into array
	$arr_data = json_decode($jsondata, true);
	
	var_dump($arr_data);
	echo $arr_data->commands . "\n";
	
	
	}


   

?>
