@echo off
echo ========================================
echo  EDUCOUNSEL - FRESH CLONE SETUP
echo ========================================
echo.

REM Step 1: Install Dependencies
echo [1/7] Installing Composer Dependencies...
call composer install
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)
echo ✓ Dependencies installed!
echo.

REM Step 2: Copy .env
echo [2/7] Creating .env file...
if exist .env (
    echo .env already exists. Skipping...
) else (
    copy .env.example .env
    echo ✓ .env file created!
)
echo.

REM Step 3: Generate App Key
echo [3/7] Generating application key...
php artisan key:generate
echo ✓ App key generated!
echo.

REM Step 4: Clear Cache
echo [4/7] Clearing all caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo ✓ Cache cleared!
echo.

REM Step 5: Database Instructions
echo [5/7] Database Setup Required!
echo.
echo IMPORTANT: Before continuing, please:
echo 1. Open phpMyAdmin (http://localhost/phpmyadmin)
echo 2. Create database: sistem_bk
echo 3. Press any key after database is created...
pause > nul
echo.

REM Step 6: Run Migrations
echo [6/7] Running database migrations...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Migration failed! Check database connection.
    pause
    exit /b 1
)
echo ✓ Database migrated!
echo.

REM Step 7: Final Instructions
echo [7/7] Setup Complete!
echo.
echo ========================================
echo  NEXT STEPS:
echo ========================================
echo.
echo 1. Edit .env file:
echo    - Set GEMINI_API_KEY (Get from https://aistudio.google.com/app/apikey)
echo    - Verify DB_DATABASE=sistem_bk
echo.
echo 2. Run: php artisan config:clear
echo.
echo 3. Start server: php artisan serve
echo.
echo 4. Open browser: http://localhost:8000
echo.
echo ========================================
echo.
pause
