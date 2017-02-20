#!/bin/bash

# Author: Andrew Jarombek
# Date: 2/20/2017
# A Simple Shell Script For Backing Up the MySQL Database

Task="Backing Up MySQL Database"
echo $Task

# Create the New File Name With The Current Date
FileName=SaintsxctfBackup_$(date +"%m%d%y").sql 

# Dump the database into the new file
# A password prompt will be presented
mysqldump --opt --user=root --password saintsxctf > $FileName