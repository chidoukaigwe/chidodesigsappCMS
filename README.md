# Chido Designs SPA Content Management System

An API driven application, built with Laravel resource collections. The application enables a user via a vue.js frontend to create, edit and publish articles. 

- Laravel 7 and Vue.js.
- User account creation and authentication.
- Users can only view their own articles. 
- The CMS can be used as an internal content management system.
- [Laravel Scout + TNT Search Driver](https://github.com/teamtnt/laravel-scout-tntsearch-driver "TNT Search Drive") , used to search for created articles on the database.

## How It Works
1. Register and create a user account .
2. Add a new article.
3. View an index of articles 
4. Edit your newly published article 
5. Search for a specific article within your database.

![alt text][logo]

[logo]: https://github.com/chidoukaigwe/chidodesigsappCMS/blob/master/cms-screenshot.png?raw=true "App Screenshot"

## Upcoming Features (Version 2)
  - Blogging Feature:Add image upload to article creation.
  - Blogging Feature: Tagging and Categorisation of articles.
  - Article Creation Page: Brainstorm and implement new additions for article creation page.
  - Dashboard: Add a dashboard events and display (logging of web app events) widget
  - User Interface: Create a new UI for the content management system.
  - Main header: Logout and main user display is handled via Laravel, change to Vue.js navbar.
  - Refactor Vue JS Code: Convert repeated HTML into reusable Vue components.
  - Add An Api Error Container: Show specific container message on api error calls.
  - Laravel Passport: Create an API endpoint to enable 3rd party account authentication and registration.
           

