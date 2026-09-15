=================================
### When cloning a project from a repo <br />
==> Step 1:  we need to install PHP dependencies <br />
== Use this command : <br />
- composer install 
- npm install (for node modules, if you want) 

==> Step 2: use this command :
- copy .env.example .env (when we cloned it not have a .env file; use this command to create a .env file in your project )
- php artisan key:generate (it means include LARAVEL_APP_KEY from the .gitignore file )
== Set up or change the DB name (DB username/password if you have them)
- php artisan migrate <br />
Do this step by step
