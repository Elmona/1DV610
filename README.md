# Course 1dv610 at Linnaeus university.  

The project is a MVC application written in `php`. A login/register module with some extra added feature. To get the application running you first have to install `Docker` and `docker-compose`.  
  
Download the code with `git clone https://github.com/Elmona/1DV610.git` && `cd 1DV610`.

There is two files you have to edit to get everything running. I have provided example files that you can copy and edit.
`cp ./web/Config.example.php ./web/Config.php`  
`vim ./web/Config.php`  

`cp ./.env.example ./.env`  
`vim ./env`  

To get the application running.  
`docker-compose up`  
  
Then it should run on `http://localhost:8000` (If you want to use this application in production I strongly advise `https://`)

You can find a running version here. [Workshop2](https://gosemojs.org/L2)

Username: `Admin`  
Password: `testar`