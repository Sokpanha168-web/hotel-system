## When you clone a project from a repo <br />
==================================== <br />

==> Step 1:  We need to install PHP dependencies <br />
= Use this command : <br />
- composer install 
- npm install (for Node modules, if you want) 

==> Step 2: We need to set up <br />
= Use this command : <br />
- copy .env.example .env (when we cloned it, it doesn't have a .env file; use this command to create a .env file in your project ) <br />
- php artisan key:generate (this includes LARAVEL_APP_KEY in the .gitignore file ) <br />
== Set up or change the DB name (DB username/password if you have them)
- php artisan migrate <br />
Do this step by step
