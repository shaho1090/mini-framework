**Short instruction:**

After cloning the repository, please go to the project directory and run these commands respectively on the terminal:
````
# docker-compose up --build -d

#docker exec -it selected-test_app_1 /bin/bash

#composer install

#php console migrations:up
````

**Upload the json file via this link using Insomnia or Postman:**
````
http://localhost:8100/import-file
````
**Go to the terminal you opened before and run:**
````
#php console worker:start
````

**Check the product table with phpMyAdmin via this link:**
````
http://localhost:8088/
````

I have not used any framework for implementing this project. I just used the ReactPHP library to run the jobs.
I have done this project a little bit like frameworks, you can check out the code and see!

