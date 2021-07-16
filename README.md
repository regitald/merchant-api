Basic Instalation

### Developer
* Regita Lisgiani

### Built With
* [Laravel](https://laravel.com/)
* [MySQL](https://www.mysql.com/)

### Package Use
* [JWT Auth](https://github.com/tymondesigns/jwt-auth)
* [Id Generator](https://github.com/haruncpi/laravel-id-generator)


### Installation

1. First Clone the project 
```sh
git clone https://gitlab.com/regitalisgianidrajat/merchant-management.git
```
2. Whenever you clone a new Laravel project you must now install all of the project dependencies. This is what actually installs Laravel itself, among other necessary packages to get started.When we run composer, it checks the composer.json file which is submitted to the github repo and lists all of the composer (PHP) packages that your repo requires. Because these packages are constantly changing, the source code is generally not submitted to github, but instead we let composer handle these updates. So to install all this source code we run composer with the following command.
```sh
composer install
```
3. Next you should install and build your database and migrate existing migratio:
```sh
php artisan migrate
```
3. Setup the database on env (I already copy my env value on env example) 
4. Run the seeder
 ```sh
php artisan db:seed
```
5. If you run in local do php artisan server in the terminal and run the application
6. To test all the apliaction starting with create merchant first [Colllection Folder : Merchant > Create]
7. Next you can create user that linked with the merchant code that you already create [Colllection Folder : User > Create]
8. Now you can login with the credential user that you create and do CRUD categories and product


### API DOCUMENTATION

1. Import the postman Documentation [Merchant Management](https://www.getpostman.com/collections/8844c3ca147152445793)
2. Setup the postman variables 
3. Get Session token to start aplication by hitting login API with superadmin credential 
```sh
email:superadmin@mail.com
password:secret123
```

### ROLES PERMISSION

1. Superamin
```sh
- Can do and access all the API
```
2. Admin
```sh
Can do and access all the API expect 
 - CRUD User Module
 - View All, Create and delete Merchant
```





