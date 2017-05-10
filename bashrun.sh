#!/bin/bash

#Bash script to execute each individual task.
echo "Hello world from BashRUN!"

#User name.
task_user=$1
#echo "1 is $task_user"

#Task name.
task_name=$2
#echo "2 is $task_name"

#Task id.
task_id=$3
#echo "3 is $task_id"

#User email address.
email=$4
#echo "4 is $email"

#Array of commands (comma separated).
num_of_commands=$5
#echo "5: $num_of_commands"

#List of commands
commands=$6
#echo "6: $commands"

#Remove first and last quotes.
commands=$(sed -e 's/^"//' -e 's/"$//' <<<"$commands")
#echo "7: $commands"

#Change the directory. move to the task directory
cd /var/www/html/worker/uploads/$task_id

#Unzip the compressed file
unzip `ls *.zip`

#Chage directory inside the newly generated folder
cd `ls -d -- */`

#Execute all the commands, one after the other.
for (( i=1; i<$num_of_commands; i++ ));do
	command=$(echo $commands| cut -d',' -f $i)
	echo "command is: $command"
	$command
done



#Compress the complete task directory
zip $task_id.zip *

#Copy the results to the finished tasks directory
cp $task_id.zip /var/www/html/worker/finished


#Prepare email to send it to user
TO_ADDRESS=$email
FROM_ADDRESS="work@worker.de"
SUBJECT="Worker: $task_name Task finished"
BODY="Hello $task_user! Your task $task with id: $task_id is finished."

#Send email to user
echo "${BODY}" | mail -s "${SUBJECT}" "${TO_ADDRESS}"  # -- -r "${FROM_ADDRESS}"



#Go back to the root directory.
cd /var/www/html/worker

#Search for the task in the file and chage status to FINISHED
filename="TasksList.csv"
while IFS='' read -r task || [[ -n "$task" ]]; do

	#Get the id for each task in the TasksList file
	file_task_id=$(echo $task| cut -d',' -f 3)
	#echo $file_task_id
	
	#If id is equal to current task_id, change status to FINISHED
	if [[ $file_task_id == $task_id ]]; then
		#replace the word RUNNING with FINISHED		
		sed -i '0,/\bRUNNING\b/{s/\bRUNNING\b/FINISHED/}' "$filename"
		break
	fi
done < $filename


#Done
echo "done!"
echo  "---------------------------------------------------------"



