@echo off
REM ============================================================
REM  run-local.bat - starts the site on http://localhost:8000
REM  Double-click this file. Needs PHP on PATH, or XAMPP/Laragon
REM  installed in the usual place.
REM ============================================================
setlocal
cd /d "%~dp0"

set PHPEXE=

REM 1. php already on PATH?
where php >nul 2>nul && set PHPEXE=php

REM 2. common XAMPP / Laragon locations
if "%PHPEXE%"=="" if exist "C:\xampp\php\php.exe" set PHPEXE=C:\xampp\php\php.exe
if "%PHPEXE%"=="" if exist "C:\laragon\bin\php\php.exe" set PHPEXE=C:\laragon\bin\php\php.exe
if "%PHPEXE%"=="" for /d %%D in ("C:\laragon\bin\php\php-*") do set PHPEXE=%%D\php.exe
if "%PHPEXE%"=="" if exist "C:\php\php.exe" set PHPEXE=C:\php\php.exe

if "%PHPEXE%"=="" (
  echo.
  echo   PHP was not found.
  echo.
  echo   Install one of these, then run this file again:
  echo     - XAMPP    https://www.apachefriends.org
  echo     - Laragon  https://laragon.org
  echo     - PHP only https://windows.php.net/download  ^(unzip to C:\php^)
  echo.
  pause
  exit /b 1
)

echo.
echo   PHP found: %PHPEXE%
echo   Serving   : %CD%
echo   Open      : http://localhost:8000
echo.
echo   Leave this window open. Press Ctrl+C to stop.
echo.
start "" http://localhost:8000
"%PHPEXE%" -S localhost:8000 router.php
endlocal
