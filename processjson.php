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
		
		$commands = implode(" ", $arr_data[commands]);
		
		var_dump($arr_data["files_in"]);
	
	
		$commands = escapeshellarg($commands);			
		$commands = explode("\n", str_replace("\r", "", $commands));
		
		array_push($commands, $dirname);
		$url = escapeshellarg($arr_data["user_url"]);
		array_push($commands, $url);
		
		$task_name = escapeshellarg($arr_data["task_name"]);
		$task_name = str_replace(' ', '_', $task_name);

		array_push($commands, $task_name);
		
		
		
	
	
	}


   

?>
