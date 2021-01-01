#!/bin/bash

DIR=${1:-/var/www/www.goliardia.it/}

echo "Ciao da $0.

This is needed. We need to launch it both when dockerizing AND 
again if you mount the volume. This code is DRY. Everything which needs
to possibly be done TWICE (which alters filesystem)
To be safe this script is parametric in the DIR which it needs to taint.
DIR: $DIR
"
set -x

chown -R www-data.www-data ${DIR}/var/


# /var/uploads/
chown www-data.www-data ${DIR}/uploads/thumb  
chmod 775 ${DIR}/uploads/thumb/

# /var/log/
mkdir -p ${DIR}/var/log/
chown www-data.www-data ${DIR}/var/log/
touch ${DIR}/var/log/pannello.log.php \
    ${DIR}/var/log/log_ingressi.php 
touch ${DIR}/var/log/index.html # to avoid listings

# /var/state/
chown www-data.www-data ${DIR}/var/state/ 
chmod 775 ${DIR}/var/state/ 
touch ${DIR}/var/state/app_utentiattivi.txt \
    ${DIR}/var/state/app_UTENTI_ORA.txt \
    ${DIR}/var/state/app_online.txt

# just because its ugly and now unneeded.
# ma no che mi incasina il GIT fdopo... e devo fare mille revert
#rm ${DIR}/var/state/.placeholder \
#    ${DIR}/var/log/.placeholder