<?php

	//If server post request, check the input.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//Generate a uniq id, will be used as folder name for the task.
	$dirname = uniqid("", true);
	
	//location to upload files.
	$new_dir = "/var/www/html/worker/uploads/".$dirname;
	mkdir($new_dir, 0777);
	
	//location to upload json file.
	$json_file = $new_dir . "/" . basename($_FILES['jsonfile']['name']);
	
	//upload json file	
	if (move_uploaded_file($_FILES['jsonfile']['tmp_name'], $json_file)) {
		$count++;
	} 
    
    //get the content of the json file.
    $content = file_get_contents($json_file);
	
	//convert json data into array
	$json = json_decode($content, true);
	//check if this is a valid json file.
	/*
	if($json === null) 
		print('Its not a Json!');
	else
		print('yes! json');
    */
    
    
    //Uplad files user selected.
    foreach ($_FILES['files']['name'] as $i => $name) {		
        if (strlen($_FILES['files']['name'][$i]) > 1) {			
			$target_file = $new_dir ."/". basename($_FILES["files"]["name"][$i]);			
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                $count++;              
            }
        }
    }
       

	//prepare the data to be written on the CSV file.	
	$user_name = $json["user_name"];	
	$user_name = str_replace(' ', '_', $user_name);
	
	$task_name = $json["task_name"];
	$task_name = str_replace(' ', '_', $task_name);	
	
	$email = $json["email_address"];	
	
	//prepare the commands, seprate them by : .
	$commands = $json["commands"];		
	$commandsList = "";
	
	$i = 0;
	foreach($commands as $value) {
		if($i == 0) {
			$commandsList .= $value;
		}
		else {
			$commandsList .= ":";
			$commandsList .= $value;
		}
		$i++;
	}	
	
	// open the file "TasksList.csv" for writing.
	$file = fopen('TasksList.csv', 'a');
 		
	//Prepare data that has to be written in the CSV file.
	$data = array($user_name, $task_name, $dirname, $commandsList, $email, 'NEW');
	
	//Place data in file.
	fputcsv($file, $data); 
	
	// Close the file.
	fclose($file);

}   

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Worker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel = "stylesheet"
   type = "text/css"
   href = "workerstyle.css" />
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <!--<li><a href="#">About</a></li>-->
        <li><a href="results.php">Results</a></li>
        <!--<li><a href="#">Contact</a></li>-->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>-->
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
    </div>
    <div class="col-sm-8 text-left"> 
      <h1>Your job is submitted</h1>
      <p>Hello <?php echo $user_name; ?>, your task <?php echo $task_name; ?> is succefully submitted. You will receive email notification when it is finished executing.</p>
      <hr>
      <h2>Task information</h2>
      <p>Your task id is: <?php echo $dirname;?></p>
    </div>
    
    
    <div class="col-sm-2 sidenav">
     <!-- <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>-->
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Worker</p>
</footer>

</body>
</html>
