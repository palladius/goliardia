#!/bin/bash

gsutil -m rsync -dr /var/www/www.goliardia.it/var/log/ gs://www.goliardia.it/backups/www.goliardia.it/logs/`hostname --fqdn`/app/
gsutil -m rsync -dr /var/log/apache2/ gs://www.goliardia.it/backups/www.goliardia.it/logs/`hostname --fqdn`/apache/
