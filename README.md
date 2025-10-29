# RBAC-System (Laravel 12 + Swagger)

# overview
This project was created by Muhammad Adeeb Bin Abdullah. 
- myadeeb03@gmail.com || 0132849417
- It is a simple Role-Based Access Control (RBAC) system built with Laravel Framework. There are 3 user roles :- 
- ADMIN (create:article, read:article, delete:article)
- EDITOR (read:article, create:article, delete only its own article)
- VIEWER (only read:article)
# feature 
- Header-based authentication ('Authorization: User 'username'')
- Get, Post, Delete API. 
- /me to get current authenticated user info
- /health for system health check
- Swagger (add "/api/documentation" after http://127.0.0.1:8000 )
- feature tests
- simple react frontend

# Prerequisites
- PHP >= 8.1
- Composer
- MySQL or any supported database
- Node.js + npm (for frontend) 

# SETUP INSTRUCTION
- copy .env.example -> .env and adjust database settings if needed.
- in terminal :- 
    - composer install
    - php artisan key:generate
    - php artisan migrate --seed
    - php artisan serve

# CURL TEST EXAMPLE IN COMMAND PROMPT
# ALWAYS DO BEFORE EACH TIME CURL TESTING (fresh migrate+seed and start server)    ##IMPORTANT
- php artisan migrate:fresh --seed 
- php artisan serve

# IN COMMAND PROMPT :

# check system health -> 200
- curl http://localhost:8000/api/health  

# authenticated user info (ADMIN) -> 200
- curl -H "Authorization: User admin" http://localhost:8000/api/me  
# authenticated user info (EDITOR) -> 200
- curl -H "Authorization: User ed" http://localhost:8000/api/me  
# authenticated user info (VIEWER) ->200
- curl -H "Authorization: User vi" http://localhost:8000/api/me  

# missing header -> 401
- curl http://localhost:8000/api/articles   
# invalid user ->401
- curl -H "Authorization: User unknown" http://localhost:8000/api/articles  

# viewer read:article, GET : return 200 - retrieved
- curl -H "Authorization: User vi" http://localhost:8000/api/articles
# editor read:article, GET : return 200 - retrieved
- curl -H "Authorization: User ed" http://localhost:8000/api/articles 
# admin read:article, GET : return 200 - retrieved
- curl -H "Authorization: User admin" http://localhost:8000/api/articles  

# editor create:article, POST : return 201- created
- curl -X POST -H "Authorization: User ed" -H "Content-Type: application/json" -d "{\"title\":\"Editor create Article\",\"body\":\"This is article creation testing cURL\"}" http://localhost:8000/api/articles 
# admin create:article, POST : return 201 - created
- curl -X POST -H "Authorization: User admin" -H "Content-Type: application/json" -d "{\"title\":\"Admin create Article\",\"body\":\"Hi this is publish by admin\"}" http://localhost:8000/api/articles
# viewer create:article, POST : return 403 - forbidden
- curl -X POST -H "Authorization: User vi" -H "Content-Type: application/json" -d "{\"title\":\"Viewer create Article\",\"body\":\"Cannot create\"}" http://localhost:8000/api/articles

# admin delete:article, DELETE : return 204 - No Content
- curl -X DELETE -H "Authorization: User admin" http://localhost:8000/api/articles/1 
# editor delete own article, DELETE  :return 204 - No Content
- curl -X DELETE -H "Authorization: User ed" http://localhost:8000/api/articles/4
# editor delete:article(others' article), DELETE : return 403- forbidden
- curl -X DELETE -H "Authorization: User ed" http://localhost:8000/api/articles/2
# admin/editor delete non exist article, DELETE : return 404 - Not Found
- curl -X DELETE -H "Authorization: User ed" http://localhost:8000/api/articles/99
# viewer delete:article, DELETE : return 403 - forbidden
- curl -X DELETE -H "Authorization: User vi" http://localhost:8000/api/articles/1


# FEATURE TESTING (in terminal)
php artisan test

# SWAGGER 
- after "php artisan serve" ctrl + click on http://127.0.0.1:8000
- add "api/documentation" in url search bar. 
- should look like this http://127.0.0.1:8000/api/documentation and enter.
- click on "Authorize" at top right. 
- enter user header (which user) :- 
    - User admin
    - User ed
    - User vi
- click authorize and close. logout when changing role OR stop using swagger.
- Can "Try it out" all of API endpoints. 
- The response should be correct based on user requirements.

# REACT FRONTEND SETUP
in project terminal :-
- cd cdn.frontend
- npm install
- npm install axios
- npm start

# start using frontend
- LOGIN PAGE : enter "admin" / "ed" / "vi" -> click login. Invalid/missing headers/username show error
- HOME PAGE :-
    - headers with welcome and logout button
    - create article form
    - article list table with action delete button
All rules/middleware/controller logic from laravel is applied.

### thankyou ###




