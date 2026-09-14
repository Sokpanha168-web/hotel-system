https://github.com/cokerr9/gh_system.git
============================
When clone project from repo <br />
// step 1:  we need to install php dependencies <br />
// use this command : <br />
- composer install 
- npm install (for node modules, if you want) 

// step 2 : use this command :
- copy .env.example .env (when we cloned it not have .env file ) this command use to create .env file to your project
- php artisan key:generate (it mean include LARAVEL_APP_KEY : from gitignore file )
- set up or change db name , (db username password if you have )
- php artisan migrate <br />
do this step by step