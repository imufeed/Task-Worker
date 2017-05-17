This is a project that allow user to specify a task that he want to run on the server.

- User can upload the files using the web interface "index.php".
- Files will be stored under a unique name in the "Uploads" directory after being processed using "process.php".
- A new line for the task will be added to the "TasksList.csv" file with status "NEW".
- A crontab will execute the bash script "crontask" periodicly.
- "crontask" will search for first "NEW" task and extract its information from the csv file and make a call to "bashrun" bash scrip passing the task information as parameters. Task status will change in the csv file to "RUNNING".
- "bashrun" will execute the list of commands for this task, and once it finish, it will move it to the "finished" directory and change its status in the csv file to "FINISHED", finally, it will send an email notification for the user telling him that his task is finished.
- User can use the task id to search for his task and download its file from the server using the "results.php".
