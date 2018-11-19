sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo  apt-get install sqlite3
sudo apt-get install php-sqlite3
sudo apt-get install php7.2-sqlite3
sudo apt-get install php7.2-xml

cp -R Laravel.old/resources/views/coupon 			Laravel/resources/views 
cp    Laravel.old/routes/web.php 				Laravel/routes/web.php
cp    Laravel.old/app/Http/Controllers/CouponController.php	Laravel/app/Http/Controllers/CouponController.php
cp -R Laravel.old/app/Classes					Laravel/app/
cp    Laravel.old/config/database.php				Laravel/config/database.php
cp    Laravel.old/.env						Laravel/.env
cp    coupons.sqlite3						Laravel/database/ZXV.sqlite3

chmod u+x Laravel/artisan
cd Laravel
composer require google/apiclient:"^2.0"
artisan   migrate

