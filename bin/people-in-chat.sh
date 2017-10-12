cat ./state/app_messaggi.txt  | sed -e 's:</font>\$:</font>$\n:g' | cut -f 2 -d@ | sort | uniq -c

