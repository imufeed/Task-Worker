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
      <h1>Welcome to Worker</h1>
      <p>Using this webpage you will be able to run your simulation on the server and get the results back to your machine. You can fill the form below or upload a JSON file that contains the details of your task.</p>
      <hr>
      <h2>Task information</h2>
      <p>Fill the following form with the details of your task</p>      
        
        <form action="process.php" method="POST" enctype="multipart/form-data">
			<label for="username">User name</label> <input type="text" name="username" required="required" id="username" class="form-control" /> <br/>
			<label for="taskname">Task name</label> <input type="text" name="taskname" required="required" id="taskname" class="form-control" /> <br/>
			<label for="useremail">Email address</label> <input type="text" name="useremail" id="useremail" required="required" class="form-control" /> <br/>
			<label for="commands">Commands</label> <textarea name="commands" id="commands" required="required" class="form-control" rows="5"></textarea> <br/>
			<label for="files"> Input directory </label> <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="" class="form-control" /> <br/>

			<input type="submit" value="Submit Task" class="btn btn-info" />
        </form>
        
        <br/>
        
        <hr>
        <h2>Using JSON file</h2>
        
        <form action="processjson.php" method="POST" enctype="multipart/form-data">
			<label for="jsonfile"> Select JSON file </label><input type="file" name="jsonfile" id="jsonfile"/><br/>
			<label for="files"> Input directory </label> <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="" class="form-control" /> <br/>
        <input type="submit" value="Submit JSON" class="btn btn-info" />
    <br/>    
        </form>
        
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
