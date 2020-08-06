### Project Assignment 
- [Install](#install)
- [Demo](#demo)
## Install
[Xampp download ](https://www.apachefriends.org/download.html)

[Composer download](https://getcomposer.org/download/)
#### after installation done.....
```composer install```

[Node Installer ](https://nodejs.org/en/download/)
####after installation done.....
```npm install```

#### after all installation done.....
#### got to .env file
##### Enter your host
DB_HOST=127.0.0.1
##### Enter your Port
DB_PORT=3306
##### Enter Database name
DB_DATABASE=cisscom
##### Enter username and password
DB_USERNAME=root

DB_PASSWORD= 

### After Database setup done...
```php artisan migrate```

### Start Server localhost 
```php artisan serve```

### For production server

##### change domain name ./public path

#### Nginx Config
```
server {
       listen 80;
       server_name example.com;
       root /srv/example.com/public;
   
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-XSS-Protection "1; mode=block";
       add_header X-Content-Type-Options "nosniff";
   
       index index.php;
   
       charset utf-8;
   
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
   
       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }
   
       error_page 404 /index.php;
   
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
```
## Demo
![alt text](https://raw.githubusercontent.com/Mahmudulazamshohan/cisscom/master/preview/screenshot_1.png "Image")

