# Course 1DV610 at Linnaeus university.  

To get the application running, you need `docker` and `docker-compose`installed and working.
```bash
git clone https://github.com/Elmona/1DV610.git
cd 1DV610
chmod +x createConfigs.sh
./createConfigs.sh
docker-compose up
```
  
The application should be running at `http://localhost:8000`  
(You don't need to configure anything more, the script and Docker do the rest)  
  
## The system contains of two parts.
  
### Login
[Use cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md)  
[Test cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md)
  
### Text Save
[Use cases](https://github.com/Elmona/1DV610/wiki/Use-case---textSave)  
[Test cases](https://github.com/Elmona/1DV610/wiki/Test-cases---Text-Save)  
  
You can find a running version here. [Workshop2](https://gosemojs.org/L2)  
Username: `Admin`  
Password: `testar`  
  
### WARNING
> Because of this code was developed against an automatic test I use a wonky session hack to cheat the test.
> I strongly advise to use https and set cookie secure instead.
