@echo off
echo off

set XAMP_HOME=C:\xampp
set EXEMPLOS_HOME=C:\Users\cajo\Documents\Aulas\UCs\Bolonha\LERCM\SMI\2014-2015-SV-(cajo)\Exemplos\PHP

set FileAuthBasic=%EXEMPLOS_HOME%\07-Auth\.htauth-basic.pw
set FileAuthDigest=%EXEMPLOS_HOME%\07-Auth\.htauth-digest.pw

set Realm="Authentication HTTP - Digest"

set htpasswd=%XAMP_HOME%\apache\bin\htpasswd.exe
set htdigest=%XAMP_HOME%\apache\bin\htdigest.exe

echo Creating setting for basic authentication...
%htpasswd% -cb %FileAuthBasic% user1 pass1
%htpasswd% -b %FileAuthBasic% user2 pass2

echo Creating setting for digest authentication...
%htdigest% -c %FileAuthDigest% %Realm% user1
%htdigest% %FileAuthDigest% %Realm% user2

pause