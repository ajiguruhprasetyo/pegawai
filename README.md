langkah pertama clone project dari repository
1. git clone https://github.com/ajiguruhprasetyo/pegawai.git
2. cp .env.example .env
3. setting database di .env
4. ketik di terminal project yang diclone dengan perintah php artisan migrate
5. jalan kan project dengan php artisan serve dengan port default 8000

langkah kedua mencoba semua endpoint Rest API di routes/api.php atau dengan cara
import collection dari postman https://www.getpostman.com/collections/76da9e1cfa1930c9c0bd

Cara Testing dengan cara ketikan perintah
vendor/bin/phpunit di terminal atau cmd


