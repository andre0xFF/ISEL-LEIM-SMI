@echo off
echo off

set XAMP_HOME=C:\xampp

set OPENSSL_CONF=%XAMP_HOME%\apache\bin\openssl.cnf
set OPEN_SSL=%XAMP_HOME%\apache\bin\openssl
set KEY_FILE=%XAMP_HOME%\apache\conf\ssl.key\server.key
set CRT_FILE=%XAMP_HOME%\apache\conf\ssl.crt\server.crt

set cmd=%OPEN_SSL% req -new -x509 -days 365 -sha1 -newkey rsa:1024 -nodes -keyout %KEY_FILE% -out %CRT_FILE%

echo open ssl configuration to use: %OPENSSL_CONF%
echo open ssl to use: %OPEN_SSL%
echo key file: %KEY_FILE%
echo Certificate file: %CRT_FILE%

echo Full command: %cmd%

%cmd%

pause