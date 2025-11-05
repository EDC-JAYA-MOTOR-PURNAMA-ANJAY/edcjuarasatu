@echo off
echo ========================================
echo VERIFYING AI CONFIGURATION
echo ========================================
echo.
echo Clearing cache...
php artisan config:clear
php artisan cache:clear
echo.
echo Checking configuration...
php artisan tinker --execute="echo 'API Key: ' . substr(config('ai.gemini.api_key'), 0, 20) . '...' . PHP_EOL; echo 'Model: ' . config('ai.gemini.model') . PHP_EOL; echo 'Enabled: ' . (config('ai.companion.enabled') ? 'YES' : 'NO') . PHP_EOL;"
echo.
echo ========================================
echo Done! Check the Model value above.
echo It MUST be: gemini-2.5-flash
echo ========================================
pause
