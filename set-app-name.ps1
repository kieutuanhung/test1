# Chạy file này (hoặc copy từng dòng vào PowerShell) tại thư mục gốc project
(Get-Content .env) -replace '^APP_NAME=.*', 'APP_NAME=HAIAH' | Set-Content .env
php artisan config:clear
Write-Host "Đã đổi APP_NAME thành HAIAH và clear config cache."
