#!/bin/bash

# even better: COMANDO_DEFAULT="/usr/local/bin/docker-php-entrypoint apache2-foreground" 
DFLT_COMMAND="/usr/local/bin/docker-php-entrypoint apache2-foreground"
COMMAND_TO_RUN=${@:-$DFLT_COMMAND}
GOLIARDIA_ENTRYPOINT_VER="1.1"
#export DEBUG=true
#export DEBUG_ON=true
export ENTRYPOINT8080_TIMESTAMP="$(date)"

function _fix_permissions() {
    PWD=$(pwd)
    echo DockerInitialize dir: $PWD. Im assuming you launch this from the rootdir or it wont work as wont be able to figure out where to get the script. 
    echo $PWD/bin/docker-post-build-init.sh "$PWD"
}
function _activate_ssmtp() {
    # https://gist.github.com/titpetric/114eb27f6e453e3e8849d65ca1a3d360
    if [[ $WEBMASTER_EMAIL ]] && [[ $SMTP_USER ]] && [[ $SMTP_PASS ]]; then
    cat << EOF > /etc/ssmtp/ssmtp.conf
root=${WEBMASTER_EMAIL}

# Here is the gmail configuration (or change it to your private smtp server)
# Riccardo: Quotes unneeded as variables come quoted.
mailhub=smtp.gmail.com:587
AuthUser=${SMTP_USER}
AuthPass=${SMTP_PASS}

UseTLS=YES
UseSTARTTLS=YES
EOF

    else 
        echo "[$0] SSMTP variables unavailable. Exiting. Dont believe me? Try: printenv WEBMASTER_EMAIL SMTP_USER SMTP_PASS"
        exit 42
    fi
}

echo "#MINOR TODO(ricc): move apache from 80 to 8080 for ease of GKE.."
_activate_ssmtp
_fix_permissions
echo "[$0] BEGIN (`date`) GOLIARDIA_ENTRYPOINT_VER=$GOLIARDIA_ENTRYPOINT_VER"
echo "[$0] 1. Setting SSMTP config thanks to succulent ENV vars like SMTP_USER=$SMTP_USER.."
_activate_ssmtp
echo "[$0] 2. Consider turning ENV[DEBUG_ON]! Currently: DEBUG='$DEBUG' DEBUG_ON='$DEBUG_ON'"
echo "[$0] 3. Bando alle Cionce, lets now finally run: $COMMAND_TO_RUN "
#DEBUG=cerrrrtamente 
# E qui eseguo il comando vero e proiprio. Ricorda che entrypoint e' un cazzillo PASSANTE
# Che esegue inizializzazione ma poi passa alla parola allo script passato da docker run.
$COMMAND_TO_RUN 
echo "[$0] END (`date`)"
