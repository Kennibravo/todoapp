**A TODO APP by Kehinde Alade using PHP/Laravel**

**Features**
 - User authentication using Tymon's JWT package, run php artisan jwt:secret.
 - CRUD Todo.
 - Can assign tags to TODOs.
 - A scheduler that runs daily to see if a TODO is due and reminds the User with their email, I used mailtrap.
 - Formatted the responses and created JSON Exception handler for almost all exceptions.
 - Postman documentation link is [Documentation Link](https://www.getpostman.com/collections/c374e3646e442c1aa02f)
 - Also created a ModelMake command to always store Models in the Models folder and not the app directory(though Laravel 8 has it).
 - Used Route Model Binding for the Todo and Tag model, I used explicit binding, which is in the **RouteServiceProvider** file.


**Logging in**
After logging in, the Bearer Token token should be pasted in the Authorization tab of Postman, after migrating, the database is populated with users.

**email:** test@gmail.com
**password:** testuser


All passwords are **testuser**

**Running the Command**
This command is meant to be run daily but it can be tested by 
running `php artisan pending-todo:send-reminder` ,
it checks all pending Todo and check their deadline/due date whether it is today,
if it is today then it Queues and send emails to the Users to remind them, you'd have to add your mailtrap details and
have a Todo due of the current day to test it.


