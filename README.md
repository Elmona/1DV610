# Course 1dv610 at Linnaeus university.  

The project is a MVC application written i php. A login module with some extra added feature.  
  
To get the application running you first have to install `Docker` and `docker-compose`.  
  
There is two files you have to edit to get everything running. I have provided example files that you can copy and edit.  
  
`cp ./web/Config.example.php ./web/Config.php`  
`vim ./web/Config.php`  

`cp ./.env.example ./.env`  
`vim ./env`  

To start the application.  
`docker-compose up`  
  
Then it should run on `http://localhost:8000` (If you want to use this application in production I strongly advise `https://`)

You can find a running version here.  
[Workshop2](https://gosemojs.org/L2)

Username: `Admin`
Password: `testar`