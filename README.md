# Symfony Project: Blogging System

This project is a web application built with the Symfony framework that enables content management in the form of blog posts categorized into specific topics. The system defines two types of users: **administrators** and **unauthenticated users**.

## Project Features

### User Roles

- **Administrator**
  - Can create, edit, and delete posts and categories.
  - Has the ability to delete comments left by unauthenticated users.
  - Has access to an admin panel with functions for login, password change, and profile management.

- **Unauthenticated User**
  - Can view available content (posts).
  - Can add comments to posts. The comment form includes fields for the user’s email address, nickname, and comment content.

### Functional Requirements

1. **CRUD for Posts**
   - Full Create, Read, Update, and Delete (CRUD) functionality for blog posts.
   - Posts can be categorized.

2. **CRUD for Categories**
   - Full CRUD functionality for categories.
   - Ability to assign categories to posts.

3. **Post List by Category**
   - Display a list of posts for a specific category.

4. **Post List Pagination**
   - Display posts in a list, ordered from newest to oldest, with pagination showing 10 posts per page.

5. **Admin Features**
   - Administrator login and logout functionality.
   - Ability for the admin to change their password and edit their profile.

6. **Comments by Unauthenticated Users**
   - Unauthenticated users can add comments to posts.
   - The comment form requires the user’s email, nickname, and comment content.
   - Administrators can delete user comments.


