#!/bin/bash

# Author: Andrew Jarombek
# Date: 2/25/2018
# Future reference for how to resign the ssl certificate for HTTPS use

# First create a server key and CSR (Certificate Signing Request).  The CSR will be sent to the signing authority
# to approve the certificate
# https://linode.com/docs/security/ssl/obtain-a-commercially-signed-tls-certificate/
openssl req -new -newkey rsa:4096 -days 365 -nodes -keyout saintsxctf2018.com.key -out saintsxctf2018.com.csr

# Copy contents of the newly made CSR
sudo nano saintsxctf2018.com.csr

# You can check the date modified of a file with the stat command
stat saintsxctf2018.com.csr

# Copy the key that was generated from the CSR generation onto the apache certificates folder
sudo cp saintsxctf2018.com.key /etc/apache2/ssl-certs/saintsxctf.key

# This is the file where we define the relative paths to the ssl certificates
sudo nano /etc/apache2/sites-available/default-ssl.conf

# Change directories to the certificates folder on Apache
cd /etc/apache2/ssl-certs/

# Upload all the certificates
sudo nano www_saintsxctf_com.crt
sudo nano intermediateca_2018_1.crt
sudo nano intermediateca_2018_2.crt
sudo nano rootca_2018.crt

# If you need to go back and edit the ssl configuration...
cd ../sites-available/
sudo nano default-ssl.conf

# If this returns 'Syntax OK', the Apache setup is good
sudo apachectl configtest

# Restart the server for the changes to push through
sudo apachectl stop
sudo apachectl start
