<?php
$count = 0;
$target_dir = "uploads/";

//Test


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$dirname = uniqid();
	$new_dir = "/var/www/html/worker/uploads/".$dirname;
	mkdir($new_dir, 0777);	
    foreach ($_FILES['files']['name'] as $i => $name) {		
        if (strlen($_FILES['files']['name'][$i]) > 1) {			
			$target_file = $new_dir ."/". basename($_FILES["files"]["name"][$i]);
			echo("<br/>");
			//echo($target_file);
			echo $_FILES["files"]["tmp_name"][$i];
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
			$commands = escapeshellarg($_POST["commands"]);			
			$commands = explode("\n", str_replace("\r", "", $commands));
		}
		array_push($commands, $dirname);
		
		
	if(empty($_POST["userurl"])) {
		$url = "";
	} else {
		$url = escapeshellarg($_POST["userurl"]);
		array_push($commands, $url);
	}
	
	if(empty($_POST["taskname"])) {
		$task_name="";		
	} else {
		$task_name = escapeshellarg($_POST["taskname"]);
		$task_name = str_replace(' ', '_', $task_name);

		array_push($commands, $task_name);
	}
	
	var_dump($commands);
}

$where = "uploads";


$result = shell_exec('/var/www/html/worker/bashrun '.join(' ',$commands));
//shell_exec('sh get_countries.sh '.join(' ',$array));

echo "<pre>$output</pre>";
print_r($result); 

//http://stackoverflow.com/questions/32721216/how-to-pass-a-php-array-to-a-bash-script


//header('Location: http://localhost/index.php?success=true');

// Function that check the data entered by the user.
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>




