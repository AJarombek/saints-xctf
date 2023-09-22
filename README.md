# saints-xctf

![Maintained Label](https://img.shields.io/badge/Maintained-No-red?style=for-the-badge)
![Deprecated Label](https://img.shields.io/badge/Deprecated-Yes-lightgray?style=for-the-badge)
![Archived Label](https://img.shields.io/badge/Archived-Yes-lightgray?style=for-the-badge)

> This repository is for Version 1 of my SaintsXCTF web application and API.  As of May 30th, 2021, SaintsXCTF switched to Version 2.  This repository is no longer used.

**Version 2 Repositories**

* [saints-xctf-web](https://github.com/AJarombek/saints-xctf-web)
* [saints-xctf-api](https://github.com/AJarombek/saints-xctf-api)

## Overview

Saintsxctf.com is my very first website.  It is a team running log website made specifically for the St. Lawrence Cross Country
and Track & Field teams.  With other team based running log websites being shut down, this was a great alternative for the team.
It is also my way of giving back.

## Technologies

The Website is built using the LAMP stack.  Server side operations are done in PHP with client side working in a JQuery flavor
of Javascript.  The database is built in MySQL.  

The website also has a REST API backend.  I chose this approach to meet my multi device needs.  I currently have an Android
app on the Play Store + Amazon Store and an IOS app in Development (As of 9/14/2017).

You can follow development of the android app here: [SaintsXCTF Android GitHub](https://github.com/AJarombek/saints-xctf-android)
You can follow development of the ios app here: [SaintsXCTF iOS GitHub](https://github.com/AJarombek/saints-xctf-ios)

The website has completed initial development and new features + updates are in the planning stages.

## Releases

**V.0.4 - Beta Release**

> Release Date: Dec 24, 2016

This was the first public release of the website.

**V.0.5 - Feedback Release**

> Release Date: Jan 18, 2017

The feedback release fixed some of the common reported bugs in the initial beta release.  It also added a few new features.

* Added Email to Sign Up Form
* Added Forgot Password Feature


**V.0.6 - Updated Groups Release**

> Release Date: Feb 20, 2017

The updated groups release fixed a few bugs but added many new features.  The goal was to give the user more to do on the
website besides just browse and upload logs.  To accomplish this, the group pages were completely overhauled.

* Edit Logs
* Delete Logs
* Group Panels
* Group Leaderboards
* Group Messages
* User Notifications

* Fixed Sign Up Form Validation
* Fixed Email Validation Fail When Copy+Paste
* Fixed Log Time and Pace Not Displaying Correctly

**V.1.0 - Official Release**

> Release Date: Jun 2, 2017

This update marks the official release of SaintsXCTF.com.  Desktop support is complete.  From here on only bug fixes and additional
features will be added.  Mobile support will also be needed to go along with the Android and iOS apps.  In this release both a 
montly and weekly log view have been added to the profile pages.  The groups got admin pages and security so no random user can 
join a group.

* Group Admin Pages
* Group Security
* Edit Group Page
* Monthly Log View
* Weekly Log View

* Fixed Comment Length Cutoff
* Fixed Edit Logs Not Working Properly

**V.1.1 - Notification Release**

> Release Date: Jun 28, 2017

This was the first post-launch release which included full notifications for different activities on the website.  There is also increased
functionality for the weekly and monthly views on the profile page as well as more functionality for the group leaerboards.

* Ability to tag users in logs and comments
* Notifications for Log Comments
* Notifications for user Tagging
* Notifications for Group Requests
* Notifications for Group Messages
* Ability for Admins to send a Notification
* Leaderboards Sorting by Activity Type
* Monthly View Sorting by Activity Type
* Weekly View Sorting by Activity Type

**V.1.2 - Mobile Release**

> Release Date: Jul 15, 2017

This was the final major release for the 2017 Cross Country season.  The website is now compatible for viewing on mobile browsers.

* Unique CSS Styling For Mobile Devices

**Future Plans**

Current development is being spent on the mobile apps and other projects.  However a codebase is always dynamic.  Future plans include:

* Suggested Features (ex. Delete/Edit Comments)
* Excel Log Data Download
* Real-Time Notifications
* RabbitMQ Messaging to Mobile Apps
* V.2.0 - Multi-Team Website w/ Laravel Framework
