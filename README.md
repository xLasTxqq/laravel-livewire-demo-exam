# Startup instructions
## Running with docker
<br>

### For linux
<b><i>
```bash
sudo chmod -R 777 ./storage && sudo chmod -R 777 ./bootstrap && mkdir ./tmp/mysql -p && cp -ri .env.example .env && docker compose up --build -d --wait && docker exec -it laravel-livewire-demo-exam-php-1 bash -c "composer u -n && composer i -n && php artisan key:generate && php artisan storage:link && php artisan migrate && php artisan db:seed"
```
</i></b>

