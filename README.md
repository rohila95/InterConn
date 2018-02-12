#InterConn - A Slack like platform for Interprofessional Collaboration

### Intro to the features available 

InterConn is a web based platform, works like the very popularly used collaborative tool called Slack. This tool allows the user to post messages in channels, directly to another user, makes it possible for the user to like and dislike the messages posted, allows the user to search for other user profiles. 

Along with these features, live collaboration satisfies an effective use case for the users to be able to collaborate live by looking at, editing each other changes at real time like Google Docs. 

Third party APIs like Gravatar for standardize avatars across the platforms, GitHub API for Authentication through GitHub, No Captcha ReCaptcha for solving bot issues and finally Firebase to get the Websockets implemented toward accomplishing live collaboration were used. 

LAMP is technical stack used for implementation of this project.

**Following is the live link of the project - [Live Demo](http://qav2.cs.odu.edu/rohila/WebProgramming-CS518/index.php)**

### DataBase Schema Design
![DB Schema Design](FinalDBDesign.JPG)

### TechStuff
* The porject is very well modularized by segregating the code into neat folder structure. All the UI scripts are placed inside **scripts** folder, Stylesheets are put up under folder **CSS**.

* **Assets** folder is the place where the scripts for the frameworks like jQuery and Bootstrap are preserved, In addition Images that are posted by the users are also stored in here under folder named **msgimages**.

* **services** is the folder containing all the serverside services, business logic is put in here. These services return a JSON object as the response to client.

* **controller.php** is the place that acts as a controller/router and navigates the request to the correct service.

* This project can be hosted on Nginix, Apachache Tomcat (All servers tha can support PHP), MYSQL is the database used, **milestone4dump.sql** has all the SQL create queries needed to brig up the Database schema.


