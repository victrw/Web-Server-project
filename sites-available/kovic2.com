server {
        #listen 80;
        #listen [::]:80;
	listen 2901;
	listen [::]:2901;

        server_name kovic.com svr2.kovic.com  www.kovic.com;

        root /var/www/kovic2.com/html;
        index index.html;

	keepalive_timeout 15s 15s;

        limit_req zone=kovic_client_limit burst=4 nodelay;
        limit_req zone=kovic_server_limit burst=20;
        limit_rate 8K;

        location =/ {
                try_files $uri $uri/ =404;
        }

        location ~* \.(jpg|jpeg|png|ico|css|js)$ {
                expires 30d;
                access_log off;
        }


        location /img/ {
                alias /var/www/kovic2.com/html/img/;
        }


        location ~ \.(php$|html)$ {
		include snippets/fastcgi-php.conf;
		fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
#		fastcgi_param REQUEST_METHOD $request_method;
#		fastcgi_param DOCUMENT_ROOT /var/www/kovic.com/php;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		include fastcgi_params;
	 }

        location ~ /.ht {
                deny all;
        }

	error_page 429 /custom_429.html;
        location = /custom_429.html {
                root /var/www/kovic2.com/error;
                internal;
        }


}	
