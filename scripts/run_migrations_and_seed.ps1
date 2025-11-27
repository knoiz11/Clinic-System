# Run composer autoload dump, migrations, seeders and clear caches for employment_status merge
# Use PowerShell; run from project root

Write-Host "Dumping composer autoload..."
composer dump-autoload

Write-Host "Running migrations (non-destructive)..."
php artisan migrate

Write-Host "Seeding RichEmployeeSeeder..."
php artisan db:seed --class=RichEmployeeSeeder

Write-Host "Clearing view cache..."
php artisan view:clear

Write-Host "Clearing application cache..."
php artisan cache:clear

Write-Host "Clearing all caches (optimize:clear)..."
php artisan optimize:clear

Write-Host "Done. Verify database schema and sample records in employees table."