#!/bin/bash

gsutil -m rsync -dr /var/www/www.goliardia.it/immagini/ gs://www.goliardia.it/env/prod/immagini/

