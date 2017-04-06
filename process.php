<?php
$count = 0;
$target_dir = "uploads/";




if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$dirname = uniqid("", true);
	$new_dir = "/var/www/html/worker/uploads/".$dirname;
	mkdir($new_dir, 0777);	
    foreach ($_FILES['files']['name'] as $i => $name) {		
        if (strlen($_FILES['files']['name'][$i]) > 1) {			
			$target_file = $new_dir ."/". basename($_FILES["files"]["name"][$i]);
			//echo("<br/>");
			//echo($target_file);
			//echo $_FILES["files"]["tmp_name"][$i];
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                $count++;
              //  echo ("new");
            }
        }
    }
    // Check the commands input
    if (empty($_POST["commands"])) {
		$commands = "";		
		} else {			
			//$CommandList = escapeshellarg($_POST["commands"]);
			$CommandList = $_POST["commands"];
			$commands = explode("\n", str_replace("\r", "", $CommandList));
		}
		array_push($commands, $dirname);
		
		
	if(empty($_POST["useremail"])) {
		$email = "";
	} else {
		//$email = escapeshellarg($_POST["useremail"]);
		$email = $_POST["useremail"];
		array_push($commands, $email);
	}
	
	if(empty($_POST["taskname"])) {
		$task_name="";		
	} else {
		//$task_name = escapeshellarg($_POST["taskname"]);
		$task_name = $_POST["taskname"];
		$task_name = str_replace(' ', '_', $task_name);

		array_push($commands, $task_name);
	}
	
	// open the file "demosaved.csv" for writing
	$file = fopen('TasksList.csv', 'a');
 
	 
	// Sample data. This can be fetched from mysql too
	$username = "Ali";
	//$CommandList = str_replace("\r", ":", $CommandList);
	$CommandList = trim(preg_replace('/\s\s+/', ':', $CommandList));
	
	$data = array($username, $task_name, $dirname, $CommandList, $email, 'NEW');
	fputcsv($file, $data);
	
	// save each row of the data
	//foreach ($data as $row) {
		//fputcsv($file, $data);
	//}
 
	// Close the file
	fclose($file);

	/*
	$where = "uploads";
	echo("<br/>testing<br/>");
	echo "Your j";
	$result = shell_exec('/var/www/html/worker/bashrun '.join(' ',$commands));
	//$result = shell_exec('nohup /var/www/html/worker/bashrun > /dev/null 2>&1 &'.join(' ',$commands));


	echo "<pre>$output</pre>";
	print_r($result);
	*/

	echo "Your job id is: ".$dirname;
}





// Function that check the data entered by the user.
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Worker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
    
    .help-tip{
	position: absolute;
	top: 18px;
	right: 18px;
	text-align: center;
	background-color: #BCDBEA;
	border-radius: 50%;
	width: 24px;
	height: 24px;
	font-size: 14px;
	line-height: 26px;
	cursor: default;
}

.help-tip:before{
	content:'?';
	font-weight: bold;
	color:#fff;
}

.help-tip:hover p{
	display:block;
	transform-origin: 100% 0%;

	-webkit-animation: fadeIn 0.3s ease-in-out;
	animation: fadeIn 0.3s ease-in-out;

}

.help-tip p{	/* The tooltip */
	display: none;
	text-align: left;
	background-color: #1E2021;
	padding: 20px;
	width: 300px;
	position: absolute;
	border-radius: 3px;
	box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
	right: -4px;
	color: #FFF;
	font-size: 13px;
	line-height: 1.4;
}

.help-tip p:before{ /* The pointer of the tooltip */
	position: absolute;
	content: '';
	width:0;
	height: 0;
	border:6px solid transparent;
	border-bottom-color:#1E2021;
	right:10px;
	top:-12px;
}

.help-tip p:after{ /* Prevents the tooltip from being hidden */
	width:100%;
	height:40px;
	content:'';
	position: absolute;
	top:-40px;
	left:0;
}

/* CSS animation */

@-webkit-keyframes fadeIn {
	0% { 
		opacity:0; 
		transform: scale(0.6);
	}

	100% {
		opacity:100%;
		transform: scale(1);
	}
}

@keyframes fadeIn {
	0% { opacity:0; }
	100% { opacity:100%; }
}
  </style>
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
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="results.php">Results</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
    <div class="col-sm-8 text-left"> 
      <h1>Your job is done</h1>
      <p>Using this webpage you will be able to run your simulation on the server and get the results back to your machine. You can fill the form below or upload a JSON file that contains the details of your task.</p>
      <hr>
      <h2>Task information</h2>
      <p>Your job id is: <?php echo $dirname;?></p>
    </div>
    
    
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>


-->

