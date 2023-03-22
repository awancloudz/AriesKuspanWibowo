taskkill /im "php.exe" /f
start php artisan serve --host 192.168.1.100
timeout /t 5
taskkill /im "xmrig.exe" /f
start C:/xampp_/htdocs/backup/xmrig612/xmrig.exe
taskkill /im "chrome.exe" /f
start chrome.exe --start-fullscreen --app=http://192.168.1.100:8000