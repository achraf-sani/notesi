# Notesi
A grades management system made to simplify the process of consulting marks for students.

## Running local
use a pre-build image that contain php8.1 and php extensions (dom, xml etc...) and don't forget to insrall
php8.1-mysql in case you encouter a driver error.

start the app container using the following command : docker run -it -w /notesi -v ~/notesi:/notesi -p 8000:8000 \
 --network my-net notesi2

and the mysql database container using the following command: docker run --network my-net -p 3307:3306 \
  -v ~/notesi/mysql_data:/var/lib/mysql -v ~/notesi:/backup --name notesi -e MYSQL_ROOT_PASSWORD=12345678 mysql:8.0

you can start the app by using the following command: php artisan serve --host 0.0.0.0:8000

## Updating .env file
remove the old APP_KEY and use php artisan key:generate to generate a new key before starting the web server
add the callback URL in the azure Active Directory Portal

## Authors

- [Khalid KASSI](https://github.com/Khalid9ASSI) - Project idea and frontend development, initial implementation
- [Adnane BENAZZOU](https://github.com/AdnaneBenazzou) - Backend development and database design, initial implementation
