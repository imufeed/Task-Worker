<?php

//Number of uploaded files.
$count = 0;

//$target_dir = "uploads/";



//If server post request, check the input.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//Generate a uniq id, will be used as folder name for the task.
	$dirname = uniqid("", true);
	
	//location to upload files.
	$new_dir = "/var/www/html/worker/uploads/".$dirname;
	mkdir($new_dir, 0777);	
    
    //Upload single Zip file
    $target_file = $new_dir ."/". basename($_FILES["fileToUpload"]["name"]);    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$count++;
	}
    /*
    //Upload files user selected.
    foreach ($_FILES['files']['name'] as $i => $name) {		
        if (strlen($_FILES['files']['name'][$i]) > 1) {			
			$target_file = $new_dir ."/". basename($_FILES["files"]["name"][$i]);			
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                $count++;              
            }
        }
    }
    */
    
    //Check task commands.
    if (empty($_POST["commands"])) {
		$commands = "";		
	} else {			
		//$CommandList = escapeshellarg($_POST["commands"]);
		$CommandList = $_POST["commands"];
		$commands = explode("\n", str_replace("\r", "", $CommandList));
	}
	
	// Add directory name (task_id) to the comands
	//array_push($commands, $dirname);
	
	//Check user email address.
	if(empty($_POST["useremail"])) {
		$email = "";
	} else {
		//$email = escapeshellarg($_POST["useremail"]);
		$email = $_POST["useremail"];
		//Add it to the commands array.
		array_push($commands, $email);
	}
	
	//Check user name.
	if(empty($_POST["username"])) {
		$user_name="";		
	} else {		
		$user_name = $_POST["username"];
		$user_name = str_replace(' ', '_', $user_name);
		//Add it to the commands array.
		array_push($commands, $user_name);
	}
	
	//Check task name.
	if(empty($_POST["taskname"])) {
		$task_name="";		
	} else {
		//$task_name = escapeshellarg($_POST["taskname"]);
		$task_name = $_POST["taskname"];
		$task_name = str_replace(' ', '_', $task_name);
		//Add it to the commands array.
		array_push($commands, $task_name);
	}
	
	// open the file "TasksList.csv" for writing.
	$file = fopen('TasksList.csv', 'a');
 
	 
	//Separate commands with ":".
	$CommandList = trim(preg_replace('/\s\s+/', ':', $CommandList));
	
	//Prepare data that has to be written in the CSV file.
	$data = array($user_name, $task_name, $dirname, $CommandList, $email, 'NEW');
	
	//Place data in file.
	fputcsv($file, $data); 
	
	// Close the file.
	fclose($file);

	/*
	 * Old way of doing it; call shell_exec to execute the task directly.
	$where = "uploads";
	echo("<br/>testing<br/>");
	echo "Your j";
	$result = shell_exec('/var/www/html/worker/bashrun '.join(' ',$commands));
	//$result = shell_exec('nohup /var/www/html/worker/bashrun > /dev/null 2>&1 &'.join(' ',$commands));


	echo "<pre>$output</pre>";
	print_r($result);
	*/

	//Inform user his task id.
	//echo "Your job id is: ".$dirname;
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
      <p>Please note that your files will be automatically <strong>deleted after 30 days.</strong></p>
    </div>
    
    
    <div class="col-sm-2 sidenav">
      <!--<div class="well">
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




