# Town Student Parliament 

## Youth organisation brief

This website was created for the Town Student Parliament of Veliko Tarnovo - an organisation that unites ambitious students from all schools in the town. They aim to make their town a more interesting place to live and help those who are in need. Through their participation students develop their teamwork, event management and communication skills.

The main aims of the website is to structure and gather in one platform all of the student's past and future activities. In enables them to advertise new events that they are planning, keep a record of old ones and share engaging articles about their past work and achievements.

## Website structure

Pages
- index.php - Home page
- events.php - List of all events
- calendar.php - Calendar of events page
- news.php - List of all news
- article.php - Separate article page

Includes
- templates/header.php - Site header
- templates/navbar.php - Site navigation bar
- templates/footer.php - Site footer
- db-connect.php - Database connection

Assets
- style.css - Stylesheet files
- js/ - Javascript files
- images/ - Image files
- photos/ - Image files

Admin Pages
- admin/admin.php - Login system
- admin/article-edit.php - Manage events
- admin/event-edit.php - Manage articles

Admin includes
- admin/event-backend.php - Database interaction handling
- admin/article-backend.php - Database interaction handling
- admin/admin-header.php - Admin dashboard header
- admin/admin-navbar.php - Admin dashboard navigation bar
- admin/db-connect.php - Database connection
- admin/logout.php - Logout functionality 

Admin Assets
- admin-style.css - Stylesheet files

Tables:
- users - Stores admin accounts
- events - Stores all events
- articles - Stores articles

Heroku
- Procfile - Tells Heroku how to run the app
- /vendor - Contains Composer dependencies
- composer.json - Dependency management for Heroku
- composer.lock - Locks dependency versions
- runtime.txt - Specifies PHP version

## Page functionality

### index.php

- Connects to MySQL database using mysqli PHP extension
- Executes parametrized query to select 3 latest events ordered by id
- Fetches results into $events array via while loop and fetch_assoc()
- Loops through $events to display event title, date, time, place
- Encodes image blobs to base64 before output for proper HTML embedding

### events.php

- Implements pagination for event listings
- SELECTs events with LIMIT for current page
- Fetches results into $events array via while loop
- Loops through $events to display title, date, time, place
- Formats date and truncates time before display
- Encodes event photo blob to base64 for HTML

### news.php

- Implements pagination for displaying article listings
- SELECTs articles from database with LIMIT for current page
- Fetches results into $articles array via while loop
- Loops through $articles to display title, snippet, date
- Truncates article content to snippet with substr()
- Formats date before display with strtotime() and date()
- Encodes article photo to base64 for display

### calendar.php and cal_code.php

Full implementation of the calendar functionality
Code adapted from:
https://www.spaceotechnologies.com/blog/php-event-calendar-jquery-ajax/

Modifications made by Yoana Yakova:
- Solved various implementation bugs to ensure smoother functionality.
- Redesigned the calendar interface for a customized look and feel.
- Enhanced event display by embedding event lists within each date cell.
- Implemented dynamic pop-up text boxes to provide detailed event information.

### admin.php

- Login page for admin access to site management
- Input fields for username and password
- On submit, AJAX request sent to check.php
- check.php validates credentials and returns JSON response
- Error handling displays warnings for empty fields
- On success, redirects to admin dashboard page
- Uses jQuery for form submit handling without page reload

### check.php

- Validates admin login POST data
- Checks username and password are not empty
- Queries database for actual stored admin credentials
- Verifies submitted password matches hashed password
- Returns JSON response indicating login success/failure
- On success, sets admin user ID in session for authorization
- Escapes user inputs before query to prevent SQL injection
- Exits after JSON response to avoid unauthorized access

### event-edit.php

- Allows creating, deleting, and editing events in admin area
- Form to add new event with title, date, time, place, link, photo
- Delete form with dropdown to select event and delete query
- Edit form with dropdown to pick event and inputs to update fields
- Inputs and values escaped before queries to prevent SQL injection

### article-edit.php

- Allows creating, deleting, and editing articles in admin area
- Form to add new article with title, content/text, and photo
- Delete form with dropdown to select article and delete query
- Edit form with dropdown to pick article and inputs to update fields
- Inputs and values escaped before queries to prevent SQL injection

### event/article-backend.php

- Queries database to fetch list of existing events/articles
- Populates dropdowns with titles for delete and edit selection
- Validates and sanitizes user inputs before database queries
- Common logic and processing for event and article CRUD operations