#!/bin/bash

# even better: COMANDO_DEFAULT="/usr/local/bin/docker-php-entrypoint apache2-foreground" 
DFLT_COMMAND="/usr/local/bin/docker-php-entrypoint apache2-foreground"
COMMAND_TO_RUN=${@:-$DFLT_COMMAND}
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
        echo "[$0] SSMTP variables unavailable. Exiting"
        exit 42
fi
}

_activate_ssmtp
_fix_permissions

echo "[$0] BEGIN. Turning on SSMTP.."
_activate_ssmtp
echo "[$0] Consider turning ENV[DEBUG_ON]! Currently: DEBUG_ON=$DEBUG_ON"

echo "[$0] Bando alle Cionce, lets now finally run: $COMMAND_TO_RUN "
DEBUG=cerrrrtamente $COMMAND_TO_RUN 
echo "[$0] END"
