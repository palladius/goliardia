#!/bin/bash
#todo acicate ssmtp and stuff

function _activate_ssmtp() {

# https://gist.github.com/titpetric/114eb27f6e453e3e8849d65ca1a3d360
if [[ $WEBMASTER_EMAIL ]] && [[ $SMTP_USER ]] && [[ $SMTP_PASS ]]; then
    cat << EOF > /etc/ssmtp/ssmtp.conf
root=${WEBMASTER_EMAIL}

# Here is the gmail configuration (or change it to your private smtp server)
mailhub=smtp.gmail.com:587
AuthUser=${SMTP_USER}
AuthPass="${SMTP_PASS}"

UseTLS=YES
UseSTARTTLS=YES
EOF

    else 
        echo "[$0] SSMTP variables unavailable. Exiting"
        exit 42
fi
}


_activate_ssmtp()

echo "[$0] BEGIN"
echo "[$0] BEGIN"| lolcat # probably error
_activate_ssmtp
apache2 -D FOREGROUND
echo "[$0] END"
