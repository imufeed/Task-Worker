#!/bin/bash

#Bash script that search for new tasks and run them
#This bash script will be called periodically from the CRONTAB.


#Loop through all the tasks in the file, and find the first NEW task.
#Start executing the NEW task, chantge its status to RUNNING and when finish this task break.
while IFS='' read -r task || [[ -n "$task" ]]; do
		
	#Print the task.
	#echo "$task"
	
	#Extract the status of the current task.
	task_status=$(echo $task| cut -d',' -f 6)
	#echo $task_status
	
	
	#If status is NEW, change the status to RUNNING and run the task.
	if [[ $task_status == "NEW" ]]; then
		echo "---------------------------------------------------------"
		#Change the status to RUNNING.		
		#replace the word new with running		
		sed -i '0,/\bNEW\b/{s/\bNEW\b/RUNNING/}' "$1"		
						
		#Get all the commands for the task, they are separated with ":".
		task_commands=$(echo $task| cut -d',' -f 4)
		
		#Get number of commands
		#number of ':' is the occurrences
		number_of_occurrences=$(grep -o ":" <<< $task_commands | wc -l)		
		let number_of_occurrences=number_of_occurrences+2
		#echo $number_of_occurrences
		
		#Prepare an array of all task commands.
		ARRAY=()
		COUNTER=1
        while [ $COUNTER -lt $number_of_occurrences ]; do
			#echo The counter is $COUNTER
			task_command=$(echo $task_commands| cut -d':' -f $COUNTER)
			#echo $task_command
			if [[ $COUNTER+1 -lt $number_of_occurrences ]]; then
				task_command="$task_command,"
			else
				task_command="$task_command"
			fi
			ARRAY[$COUNTER-1]=$task_command
            let COUNTER=COUNTER+1 
        done
		
		#let COUNTER=COUNTER-1
		#echo ${ARRAY[*]}
		
		#Prepare all the task info to send it to the Bashrun script.
		task_user=$(echo $task| cut -d',' -f 1)
		task_id=$(echo $task| cut -d',' -f 3)
		task_email=$(echo $task| cut -d',' -f 5)
		task_name=$(echo $task| cut -d',' -f 2)
		#echo $task_commands
		echo "User name is: $task_user"
		echo "Task id is: $task_id"
		echo "User email is: $task_email"
		echo "Task name is: $task_name"
		
		#Call the bashrun scrip and send it all the task info as parameter.
		/var/www/html/worker/bashrun.sh $task_user $task_name $task_id $task_email $COUNTER "${ARRAY[*]}"
		
		#Once we run one task, stop. Wait for the CRONTAB to make a new call for this scrip.
		break
	#else
		#echo "not new"		
	fi
done < "$1"


