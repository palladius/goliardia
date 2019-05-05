#!/bin/bash

# add to stackdriver: https://cloud.google.com/monitoring/custom-metrics/creating-metrics#monitoring-create-metric-php

cat ../var/state/app_messaggi.txt  | sed -e 's:</font>\$:</font>$\n:g' | cut -f 2 -d@ | sort | uniq -c

