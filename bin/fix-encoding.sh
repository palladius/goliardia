# #!/bin/bash

# # 2021

# ## Mannaggia ho appena scoperto guardando la storia del GIT che se vai indietro abbastanza nel tempo
# # i caratteri NON erano tutti a cazzo :)
# # Guarda:
# # $ git show 5e59f88eb345eae5d4e69b474aef9d4642eaaad3:funzioni.php # rev del 20120916 in cui cambiavo a 644 tutto. 
# # [..]
# # // venerd<EC> puoi (1) capire xch<E8> va ottimizzata; (2) ottimizzarla. il passo 1 <E8> + difficile ;-) scherzo.
# # # la PRIMISSIMA revisione e questa: edc7d44c4595d7a761f17e97935e31b5857d1c7e
# # $ git show edc7d44c4595d7a761f17e97935e31b5857d1c7e:funzioni.php > funzioni.php.aleph0 # rev primissima, meglio non si puo fare

# echo Facciamo a manhouse e vediamo se va
# # HEXDUMP STUDY: i caratteri sono purtroppo indistinguibili: tutti "ef bf bd"
# #cat test-encoding.txt  | hd -c ; tail -2 test-encoding.txt

# #--in-place
# echo Cambiamo i SI e COSI:
# for PHPFILE in *.php ; do
#     cat $PHPFILE | 
#         ##################################################
#         # A accentata
#         ##################################################
#         # non cambniare citta' e stesso per dignita' perche' e' nel DB :/
#         # Anzi si proviamoci
#         sed -e "s/ignit�/ignità/g" |
#         sed -e "s/acolt�/acoltà/g" |
#         sed -e "s/implicher�/implicherà/g" |
#         sed -e "s/dar�/darà/g" |
#         sed -e "s/sar�/sarà/g" | # puo essere saro'# ma chissene
#         sed -e "s/ovit�/ovità/g" | 
#         sed -e "s/verr�/verrà/g" | 
#         sed -e "s/servir�/servirà/g" | 
#         sed -e "s/funzioner�/funzionerà/g" | 
#         sed -e "s/varr�/varrà/g" | 
#         sed -e "s/ealt�/ealtà/g" | 
#         sed -e "s/si degner�/si degnerà/g" | 
#         sed -e "s/pap�/papà/g" | 
#         sed -e "s/itt�/ittà/g" | 
#         sed -e "s/gi�/già/g" | # puo essere GIU ma amen 
#         sed -e "s/t�/tà/g" | # Ho impressione che Tx sia sempre TA a parte RIVOLTO' e IMBRUTTI' :) si confermo
#         sed -e "s/ d� / dà /g" | # Ho impressione che Tx sia sempre TA a parte RIVOLTO' e IMBRUTTI' :) si confermo
#         sed -e "s/Ullall�/Ullallà/g" | # Ho impressione che Tx sia sempre TA a parte RIVOLTO' e IMBRUTTI' :) si confermo
#         sed -e "s/D�/Dà/g" | 
#         sed -e "s/mi potr�/mi potrà/g" | 
        
#         ##################################################
#         # "e" accentata GRAVE è
#         ##################################################
#         sed -e "s/ �/ è/g" |
#         sed -e "s/'�/'è/g" | 
#         sed -e "s/\"�/\"è/g" | 
#         ##################################################
#         # "e" accentata e acuta perché Né
#         ##################################################
#         sed -e "s/ch�/ché/g" | 
#         sed -e "s/ n�/ né/g" | 

#         ##################################################
#         # I accentata
#         ##################################################
#         # SI da solo e con virgole perche e difficile da prendere..
#         sed -e "s/s� /sì /" | 
#         sed -e "s/s�!/sì!/" | 
#         sed -e "s/tres�/tresì/" | 
#         sed -e "s/s�\"/sì\"/" | 
#         sed -e "s/\"s�/\"sì/" | 
#         sed -e "s/s�,/sì,/" |
#         # /SI
#         sed -e "s/dibb�/dibbì/" | 
#         sed -e "s/enerd�/enerdì/" | 

#         ##################################################
#         # O accentata chennesò
#         ##################################################
#         sed -e "s/ci�/ciò/" | 
#         sed -e "s/Ci�/Ciò/" | 
#         sed -e "s/iapas�/iapasò/" | 
#         sed -e "s/pu�/può/" | 
#         sed -e "s/per�/però/" | 
#         sed -e "s/ccer�/ccerò/g" | # abbreccero' 
#         sed -e "s/abbasser�/abbasserò/g" | 
#         sed -e "s/picchier�/picchierò/g" | 
#         sed -e "s/punir�/punirò/g" | 
#         sed -e "s/Io mander�/Io manderò/" |
#         sed -e "s/far�/farò/" | # non e mai FARA ho guardato.. 
#         sed -e "s/ercher�/ercherò/g" | # cerchero'
#         sed -e "s/user�/userò/" | # cerchero'
#         sed -e "s/se violer�/se violerò/" | # cerchero'
        

#         sed -e "s/pou�/può/" | # era un typo ma lo fixiamo qui :P  pou�
#         ##################################################
#         # U accentata Più
#         # Nota maiuscole: È, À Ò, Ù, Ì,
#         ##################################################
#         sed -e "s/pi�/più/" | # non e mai FARA ho guardato.. 
#         sed -e "s/Pi�/Più/" | # non e mai FARA ho guardato.. 
#         sed -e "s/PI�/PIÙ/" | # non e mai FARA ho guardato.. 

#         ##################################################
#         # ridirigo (tee >/dev/null) cosi va ok con pipe a SX :P

#         tee $PHPFILE.codificato 1>/dev/null
# done

# for i in *.codificato ; do 
#     echo mv "$i" $(basename $i .codificato); 
# done > se-ti-fidi-bashami-ma-assicurati-prima-che-sia-diffabile-e-rollbackabile.sh

# echo Creato: se-ti-fidi-bashami-ma-assicurati-prima-che-sia-diffabile-e-rollbackabile.sh
# echo "Per vedere ulteriori errori, digita:  fgrep --color=auto � *php"