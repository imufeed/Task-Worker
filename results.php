<!DOCTYPE html>
<html lang="en">
<head>
  <title>Worker: Results</title>
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
        <li><a href="index.php">Home</a></li>
        <!--<li><a href="#">About</a></li>-->
        <li class="active"><a href="results.php">Results</a></li>
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
      <h1>Results</h1>
      <p>Find your job.</p>
      <hr>
      <h2>Search your job</h2>
      <p>Here you can check the status of your task using task id. You can download it or delete it.</p>      
        
      <form action="results.php" method="POST" enctype="multipart/form-data">
			<label for="taskid">Task id</label> <input type="text" name="taskid" required="required" id="taskid" class="form-control" /> <br/>
           <input type="submit" value="Check Status" class="btn btn-info" /><br/><br/>
      </form>
    
    
    <?php
		//check if post request.
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(empty($_POST["taskid"])) {
				$id = "";
			} else {				
				$id = $_POST["taskid"];
				$dir    = 'finished';
				$files = scandir($dir);
				$files = array_diff($files, array('.', '..'));
				echo "<table>";
				$id = $id.".zip";
				//search for the task in the "finished" directory.	
				foreach($files as $file) {										
					if($file == $id) {
						$link_address = 'finished/'.$file;
						echo "<tr><td><a href='".$link_address."'>$file</a></td>";						
						echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><a href='?delete=1&file=".$file."'>Delete Now!</a></td></tr>";					
					}
				}		
				echo "</table>";				
			}	
		}
		
		//check if the delte button clicked, delete the file.
		if(isset($_GET['delete'])) {			
			$x = $_SERVER['DOCUMENT_ROOT']."/worker/finished/". $_GET['file'];			
			unlink($x);			
		}
		

		
		?>
		
    </div>
    <div class="col-sm-2 sidenav">
      <!--<div class="well">
        <p>asd</p>
      </div>
      <div class="well">
        <p>dd</p>
      </div>-->
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Worker</p>
</footer>

</body>
</html>
