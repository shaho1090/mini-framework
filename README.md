**Short instruction:**

After cloning the repository please go to project directory run this commands respectively on terminal:
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

**Check the product table with phpmyadmin via this link:**
````
http://localhost:8088/
````

I have not used any framework for implementing this project. I just used ReactPHP library for running the job.
I have done this project a little bit like frameworks you can check out the code and see!
     

* *And also I should mention that the project is not completed yet.*
