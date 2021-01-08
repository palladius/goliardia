#!/bin/bash

# 2021
echo Bastava guardare su StackOverflow, imbecille che non sono altro...

for F in *php ; do
    if file $F | grep ISO-8859; then
        yellow Errato lo fixo: $F
        iconv -f ISO-8859-15 -t UTF-8 $F > $F.convertito
    else
        verde Gia fixato - lo lascio com e: $F.
    fi
done
