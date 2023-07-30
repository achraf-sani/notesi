# Notesi
A grades management system made to simplify the process of consulting marks for students.

## Running local
use a pre-build image that contain php8.1 and php extensions (dom, xml etc...)
and start the app by using the following command  : php artisan serve --host 0.0.0.0:8000


## Updating .env file
starting by removing the old APP_KEY and using php artisan key:generate to generate a new key
add the callback URL in the azure Active Directory Portal

## Authors

- [Khalid KASSI](https://github.com/Khalid9ASSI) - Project idea and frontend development, initial implementation
- [Adnane BENAZZOU](https://github.com/AdnaneBenazzou) - Backend development and database design, initial implementation
