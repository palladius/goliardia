#!/bin/bash

# 2021
echo Facciamo a manhouse e vediamo se va
# HEXDUMP STUDY: i caratteri sono purtroppo indistinguibili: tutti "ef bf bd"
#cat test-encoding.txt  | hd -c ; tail -2 test-encoding.txt

#--in-place
echo Cambiamo i SI e COSI:
for PHPFILE in *.php ; do
    cat $PHPFILE | 
        ##################################################
        # A accentata
        ##################################################
        # non cambniare citta' e stesso per dignita' perche' e' nel DB :/
        # Anzi si proviamoci
        sed -e "s/ignit�/ignità/g" |
        sed -e "s/acolt�/acoltà/g" |
        sed -e "s/sar�/sarà/g" | # puo essere saro'# ma chissene
        sed -e "s/ovit�/ovità/g" | 
        sed -e "s/verr/verrà/g" | 
        sed -e "s/ealt�/ealtà/g" | 
        sed -e "s/itt�/ittà/g" | 
        sed -e "s/gi�/già/g" | # puo essere GIU ma amen 
        sed -e "s/t�/tà/g" | # Ho impressione che Tx sia sempre TA a parte RIVOLTO' e IMBRUTTI' :) si confermo

        ##################################################
        # "e" accentata GRAVE è
        ##################################################
        sed -e "s/ �/ è/g" |
        sed -e "s/'�/'è/g" | 
        sed -e "s/\"�/\"è/g" | 
        ##################################################
        # "e" accentata e acuta perché
        ##################################################
        sed -e "s/ch�/chè/g" | 

        ##################################################
        # I accentata
        ##################################################
        # SI da solo e con virgole perche e difficile da prendere..
        sed -e "s/s� /sì /" | 
        sed -e "s/s�!/sì!/" | 
        sed -e "s/s�\"/sì\"/" | 
        sed -e "s/\"s�/\"sì/" | 
        sed -e "s/s�,/sì,/" |
        # /SI
        sed -e "s/dibb�/dibbì/" | 
        sed -e "s/enerd�/enerdì/" | 

        ##################################################
        # O accentata chennesò
        ##################################################
        sed -e "s/ci�/ciò/" | 
        sed -e "s/iapas�/iapasò/" | 
        sed -e "s/pu�/può/" | 
        sed -e "s/abbasser/abbasserò/" | 
        sed -e "s/far�/farò/" | # non e mai FARA ho guardato.. 
        ##################################################
        # U accentata
        ##################################################
        tee $PHPFILE.codificato 1>/dev/null
done