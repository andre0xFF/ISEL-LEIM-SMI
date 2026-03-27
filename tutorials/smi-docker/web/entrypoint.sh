#!/usr/bin/env bash
set -e

if [[ -n "${GMAIL_USER:-}" && -n "${GMAIL_APP_PASSWORD:-}" ]]; then
  cat > /var/www/.msmtprc <<EOF
defaults
auth           on
tls            on
tls_starttls   on
tls_trust_file /etc/ssl/certs/ca-certificates.crt
logfile        /var/log/msmtp.log

account        gmail
host           smtp.gmail.com
port           587
from           ${GMAIL_USER}
user           ${GMAIL_USER}
password       ${GMAIL_APP_PASSWORD}

account default : gmail
EOF

  chown www-data:www-data /var/www/.msmtprc
  chmod 600 /var/www/.msmtprc
fi

exec "$@"
