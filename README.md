## Formations Management

- We carried out this project in an internship at CURI - University Center for informatics Resources -, <br>                                
- The subject : Management of students registered for continuing formations at ibn tofail university.

----------------------------------------------------------------------------------------------------------------

- Laravel Auth is a Complete Build of Laravel 8 with Email Registration Verification, Social Authentication, User Roles and Permissions, User Profiles, and Admin restricted user management system. Built on Bootstrap 4.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

 ### Sponsor
<table>
    <tr>
        <td>
            <img src="https://cdn.auth0.com/styleguide/components/1.0.8/media/logos/img/badge.png" alt="Auth0" width="50">
        </td>
        <td>
            If you want to quickly add secure token-based authentication to Laravel apps, feel free to check Auth0's Laravel SDK and free plan at <a href="https://auth0.com/developers?utm_source=GHsponsor&utm_medium=GHsponsor&utm_campaign=laravel-auth&utm_content=auth" target="_blank">https://auth0.com/developers</a>.
        </td>
    </tr>
</table>

#### Table of contents
- [About](#about)
- [Features](#features)
- [Installation Instructions](#installation-instructions)
    - [Build the Front End Assets with Mix](#build-the-front-end-assets-with-mix)
    - [Optionally Build Cache](#optionally-build-cache)
- [Seeds](#seeds)
    - [Seeded Roles](#seeded-roles)
    - [Seeded Users](#seeded-users)
- [Routes](#routes) 
- [Other API keys](#other-api-keys)
- [Environment File](#environment-file)
- [Updates](#updates)
- [Screenshots](#screenshots)


### About
Laravel 8 with user authentication, registration with email confirmation, social media authentication, password recovery, and captcha protection. Uses official [Bootstrap 4](https://getbootstrap.com). This also makes full use of Controllers for the routes, templates for the views, and makes use of middleware for routing. Project can be stood up in minutes.

### Features
#### A [Laravel](https://laravel.com/) 8.x with [Bootstrap](https://getbootstrap.com) 4.x project.

| Laravel Auth Features  |
| :------------ |
|Built on [Laravel](https://laravel.com/) 8|
|Built on [Bootstrap](https://getbootstrap.com/) 4|
|Uses [MySQL](https://github.com/mysql) Database (can be changed)|
|Uses [Artisan](https://laravel.com/docs/master/artisan) to manage database migration, schema creations, and create/publish page controller templates|
|Dependencies are managed with [COMPOSER](https://getcomposer.org/)|
|Laravel Scaffolding **User** and **Administrator Authentication**.|
|CRUD (Create, Read, Update, Delete) User Management|
|CRUD (Create, Read, Update, Delete) Formation Management|
|CRUD (Create, Read, Update, Delete) Branche of Formation Management|
|Robust [Laravel Logging](https://laravel.com/docs/master/errors#logging) with admin UI using MonoLog|
|Makes use of Laravel [Mix](https://laravel.com/docs/master/mix) to compile assets|
|Makes use of [Language Localization Files](https://laravel.com/docs/master/localization)|
|Active Nav states using [Laravel Requests](https://laravel.com/docs/master/requests)|
|Restrict User Email Activation Attempts|
|Uses [Laravel Debugger](https://github.com/barryvdh/laravel-debugbar) for development|
|Makes use of [Password Strength Meter](https://github.com/elboletaire/password-strength-meter)|
|Makes use of [hideShowPassword](https://github.com/cloudfour/hideShowPassword)|
|User Avatar Image AJAX Upload with [Dropzone.js](https://www.dropzonejs.com/#configuration)|
|User Gravatar using [Gravatar API](https://github.com/creativeorange/gravatar)|
|User Password Reset via Email Token|
|User Login with remember password|
|User [Roles/ACL Implementation](https://github.com/jeremykenedy/laravel-roles)|
|Roles and Permissions GUI|
|Eloquent user profiles|
|User Themes|
|404 Page|
|403 Page|
|Configurable Email Notification via [Laravel-Exception-Notifier](https://github.com/jeremykenedy/laravel-exception-notifier)|
|Activity Logging using [Laravel-logger](https://github.com/jeremykenedy/laravel-logger)|
|Optional 2-step account login verfication with [Laravel 2-Step Verification](https://github.com/jeremykenedy/laravel2step)|
|Uses [Laravel PHP Info](https://github.com/jeremykenedy/laravel-phpinfo) package|
|Uses [Laravel Blocker](https://github.com/jeremykenedy/laravel-blocker) package|
|Makes use of [Laravel's Soft Delete Structure](https://laravel.com/docs/master/eloquent#soft-deleting)|
|Soft Deleted Users Management System|
|Permanently Delete Soft Deleted Users|
|User Delete Account with Goodbye email|
|User Restore Deleted Account Token|
|Restore Soft Deleted Users|
|View Soft Deleted Users|
|Soft Deleted Formations Management System|
|Permanently Delete Soft Deleted Formations|
|Delete Formation with Goodbye|
|Restore Soft Deleted Formation|
|View Soft Deleted Formations|
|Soft Deleted Branches Management System|
|Permanently Delete Soft Deleted Branches|
|Delete Branches with Goodbye|
|Restore Soft Deleted Branche|
|View Soft Deleted Branches|
|**Statistics :** Representation of students by formation, by branche of formation, by their payment status|
|**Statistics :** Representation of formation by their branches depending on number of students|

### Installation Instructions
1. Run `git clone https://github.com/Anas-Hilia/pfa_project.git pfa_project`
2. Create a MySQL database for the project
3. Configure your `.env` file
4. Run `composer update` from the projects root folder

### Seeds :
1. **Seeded Roles**

|Id|Name|Description|
|:------------|:------------|:------------|
|1|Admin|Admin Role|
|2|Professor|Professor Role|
|3|Student|Student Role|

2. **Seeded Users**

|Email|Password|Access|
|:------------|:------------|:------------|
|admin@admin.com|password|Admin Access|
|prof email |pwd prof |prof Access|
|student email |pwd student |student Access|


### Environment File
Example `.env` file:

```bash
....

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pfa
DB_USERNAME=root
DB_PASSWORD=

....

```

#### Laravel Developement Packages Used References
* https://laravel.com/docs/master/authentication
* https://laravel.com/docs/master/authorization
* https://laravel.com/docs/master/routing
* https://laravel.com/docs/master/migrations
* https://laravel.com/docs/master/queries
* https://laravel.com/docs/master/views
* https://laravel.com/docs/master/eloquent
* https://laravel.com/docs/master/eloquent-relationships
* https://laravel.com/docs/master/requests
* https://laravel.com/docs/master/errors

### Screenshots
#### Login and Registration
- Login :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/login.PNG?raw=true)
- Registration (Student) :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/register_1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/register_2.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/register_3.PNG?raw=true)
- Forget Password :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/forget_password.PNG?raw=true)

#### Admin Space :
##### Home page : 
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/home.PNG?raw=true)

##### CRUD User (Professor or Student) :
- Show All Users :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowAllUsers.PNG?raw=true)
- Search User :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/SearchUser.PNG?raw=true)
- Create (Professor or Student):
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/create_user.PNG?raw=true)
###### CRUD Professor :
- Show All Professors :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowAllProfs.PNG?raw=true)
- Show :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowProf0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowProf1.PNG?raw=true)
- Create :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/create_prof.PNG?raw=true)
- Update :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditProf0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditProf1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditProf2.PNG?raw=true)

###### CRUD Student :
- Show All Students :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowAllStudents.PNG?raw=true)
- Show :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStudent1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStudent2.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStudent3.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStudent4.PNG?raw=true)
- Create :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/create_student1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/create_student2.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/create_student3.PNG?raw=true)

- Update :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditStudent0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditStudent1.PNG?raw=true)

- Delete (Professor or Student):
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteUser0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteUser1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteUser2.PNG?raw=true)


##### Import and Export Students :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ImportAndExportStudent.PNG?raw=true)
##### CRUD Formation :
- Show All Formations :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowAllFormations.PNG?raw=true)
- Show formation :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowFormation.PNG?raw=true)
- Create :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/CreateNewFormation.PNG?raw=true)
- Update :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditFormation.PNG?raw=true)
- Delete :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteFormation0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteFormation1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteFormation2.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteFormation3.PNG?raw=true)

##### CRUD Formation's Branches :
- Show Branches of the formation "Industrie" : 
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowFormationBranches.PNG?raw=true)
- Show :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowBranche.PNG?raw=true)
- Create :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/CreateNewBranche.PNG?raw=true)
- Update :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/EditBranche.PNG?raw=true)
- Deleted : 
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteBranche0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteBranche1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteBranche2.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/DeleteBranche3.PNG?raw=true)

 

##### Users Recently Created :
##### Users Recently Updated :
##### Formations Recently Created :
##### Formations Recently Updated :
##### Branches Recently Created :
##### Branches Recently Updated :
##### Users Recently Deleted :
##### Formations Recently Deleted :
##### Branches Recently Deleted :
##### Show Statistics
- Representation of students by formation :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics1_1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics1_2.PNG?raw=true)

- Representation of students by branche of formation :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics2_1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics2_2.PNG?raw=true)

- Representation of formation by their branches depending on number of students:
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics3_0.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics3_1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics3_2.PNG?raw=true)

- Representation of students by their payment status :
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics4_1.PNG?raw=true)
![alt text](https://github.com/Anas-Hilia/pfa_project/blob/master/screenshoots/admin/ShowStatistics4_2.PNG?raw=true)




```

* Tree command can be installed using brew: `brew install tree`
* File tree generated using command `tree -a -I '.git|node_modules|vendor|storage|tests'`

### Opening an Issue
Before opening an issue there are a couple of considerations:
* You are all awesome!
* **Please Read the instructions** and make sure all steps were *followed correctly*.
* **Please Check** that the issue is not *specific to the development environment* setup.
* **Please Provide** *duplication steps*.
* **Please Attempt to look into the issue**, and if you *have a solution, make a pull request*.
* **Please Show that you have made an attempt** to *look into the issue*.
* **Please Check** to see if the issue you are *reporting is a duplicate* of a previous reported issue.

### Formations Management License
Formations Management is licensed under the [MIT license](https://opensource.org/licenses/MIT). Enjoy!

### Laravel Auth License
Laravel-auth is licensed under the [MIT license](https://opensource.org/licenses/MIT). Enjoy!
