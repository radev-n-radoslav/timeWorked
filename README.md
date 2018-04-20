# Time Worked
# Installation

 1. First you need to have php installed and all dependencies of it required by Laravel MVC. Link to instructions on what Laravel requires: [this](https://laravel.com/docs/5.6)
 2. Afterwards you need to import the sql file from the project to the database.
 3. Edit the .env file to match your system
 4. Add a virtual host to your apache server 

<VirtualHost *:80>
	DocumentRoot "/Users/myName/Projects/laravel/public"
	ServerName myLaravel.dev
	<Directory "/Users/myName/Projects/laravel/public">
		AllowOverride All
		Options FollowSymLinks +Indexes
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>

<br>

 or run 

> php artisan serve
 
 in the system console, while in the project directory

Test and Enjoy!