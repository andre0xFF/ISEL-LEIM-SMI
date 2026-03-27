#!/bin/bash

XAMP_HOME=/home/${USERNAME}/xampp

OPENSSL_CONF=${XAMP_HOME}/apache/bin/openssl.cnf
OPEN_SSL=${XAMP_HOME}/apache/bin/openssl
KEY_FILE=${XAMP_HOME}/apache/conf/ssl.key/server.key
CRT_FILE=${XAMP_HOME}/apache/conf/ssl.crt/server.crt

cmd=${OPEN_SSL} req -new -x509 -days 365 -sha1 -newkey rsa:1024 -nodes -keyout ${KEY_FILE} -out ${CRT_FILE}

echo "open ssl configuration to use: ${OPENSSL_CONF}"
echo "open ssl to use: ${OPEN_SSL}"
echo "key file: ${KEY_FILE}"
echo "Certificate file: ${CRT_FILE}"

echo "Full command: ${cmd}"
${cmd}
