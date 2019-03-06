@echo off

cd "W:\www\AFTC\F19"
call composer dumpautoload -o

cd "W:\www\AFTC\F19\AFTC\framework"
call composer dumpautoload -o

cd "W:\www\AFTC\F19"

rem pause

rem cmd