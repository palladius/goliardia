#!/bin/bash

echo "#####################################################################################"
echo "# Achtig Mittenand! #"
echo "This script is to check FROM INSIDE DOcker if I forgot some personal password in it."

# Qui siamo a posto, da MO ho messo ENV vars.
echo "## [MAJOR] Lets check if you left CLEAR TEXT password inside the container :)"
# Nota che ci sono potenzialmente DUE directory - una per PROD e una montata per DEV.
# Nel dubbo cerchiamole entrambe - e gratis! 
grep PASS /var/www/www.goliardia.it/conf/setup.php
grep PASS /var/www/html/www.goliardia.it/conf/setup.php

echo "## [MAJOR] Lets check if you left SMTP password inside the container :)"
egrep ^Auth /etc/ssmtp/ssmtp.conf 

echo "## [MINOR] Lets check if you hjave any passwords in ENV. This should NOT be a problem, if you passed them privately and they're not IN the image"
printenv GOLIARDIA_GMAIL_PASS SMTP_PASS GOLIARDIA_MYSQL_PASS

echo "## [MEDIUM] Lets make sure theres no private images in it"
ls -al /var/www/www.goliardia.it/immagini/persone/ophelia.jpg
ls -al /var/www/www.goliardia.it/immagini/persone/manolus.jpg
