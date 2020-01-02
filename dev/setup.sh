#!/bin/bash
echo "Please enter the information as prompted to establish a connection."
read -p "Enter the db_user: " db_user
read -p "Enter the db_hostname: " db_hostname
read -p "Enter the db_name: " db_name
read -p "Enter the db_password: " db_password

sed -e "s/DB_NAME/$db_name/" -e "s/DB_HOSTNAME/$db_hostname/" -e "s/DB_USER/$db_user/" -e "s/DB_PASSWORD/$db_password/" dbconnect_string_template.php > ../lib/dbconnect_string.php

psql "dbname='$db_name' user='$db_user' password='$db_password' host='$db_hostname'" -f schema.sql

chmod 711 ../.
chmod 711 ../view
