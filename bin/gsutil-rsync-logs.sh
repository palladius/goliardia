#!/bin/bash

gsutil -m rsync -dr /var/www/www.goliardia.it/var/log/ gs://www.goliardia.it/backups/logs/`hostname --fqdn`/
