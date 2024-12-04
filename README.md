# About this project:
-It has a register and login endpoint
-JWT authentication
-Admin can create users with spesefic roles
-A sql file to run whatever it needs on database
-Unit test for create user endpoint

 ## How to use
 First, register a user using {register.php} endpoint and send email, pass, confirm parametrs. this user will be the main admin user.  
 Then, log-in with {login.php} endpoint. It will return a token.
 Admin can create users with some defined roles. The create user endpoint has an Unit test to test every function to see if they are working as they shuold be.
 Run sql file using mysql command or create a database with the tables that defined on this sql file.
