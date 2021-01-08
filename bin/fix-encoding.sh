#!/bin/bash

# 2021
echo Facciamo a manhouse e vediamo se va
# HEXDUMP STUDY
cat test-encoding.txt  | hd -c ; tail -2 test-encoding.txt

#--in-place
echo Cambiamo i SI e COSI:
for PHPFILE in *.php ; do
    cat $PHPFILE | 
        # A accentata
        sed -e "s/dignits�/dignità/" | 
        sed -e "s/sar�/sarà/" | 
        sed -e "s/novit�/novità/" | 
        # non cambniare citta' e stesso per dignita' perche' e' nel DB :/
        # Anzi si proviamoci
        # sed -e "s/dignits�/dignità/" | 

        # "e" accentata è
        sed -e "s/ � / è /" | 
          
        # I accentata
        sed -e "s/s� /sì /" | 
        sed -e "s/s�!/sì!/" | 
        sed -e "s/s�\"/sì\"/" | 
        sed -e "s/s�,/sì,/" | 
        # O accentata chennesò
        sed -e "s/iapas�/iapasò/" | 
        # U accentata
        tee $PHPFILE.codificato
done