#!/bin/bash

FOTO="${1:-GIVEMEUSER.jpg}"
UTENTE=$(basename "$FOTO" .jpg)

echo Sfruggoling pic for user $UTENTE...

if [ -f "$FOTO" -a  ! -f "../../immagini/persone/$FOTO" ] ; then
  mv "$FOTO"  ../../immagini/persone/
  echo Foto spostata: $FOTO
else
  echo Errore: o il file DST esiste: ../../immagini/persone/$FOTO o il SRC non esiste:  "$FOTO"
  exit 11
fi

echo "open http://www.goliardia.it/utente.php?nomeutente=$UTENTE"

