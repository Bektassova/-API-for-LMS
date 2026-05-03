# -API-for-LMS
Design and Planning of a RESTful API for a Centralised Learning Management System (LMS) Integrating Web and Mobile Platforms
API for LMS
Task
Add different HTTP response codes and all necessary validation checks to every endpoint.

HTTP Response Codes Used
CodeMeaningWhen200OKSuccessfully retrieved or updated201CreatedSuccessfully created a new record400Bad RequestMissing required fields or ID404Not FoundNo record found in database405Method Not AllowedWrong HTTP method used503Service UnavailableDatabase failed to execute

What Was Done
Validation checks added to every endpoint:

Checks if request body is empty
Checks if all required fields are present
Checks if ID is provided for single record requests
Checks if correct HTTP method is used (DELETE endpoints)

Endpoints updated with response codes:
User: create read readSingle update updateAge delete
Post: create readSingle update updateContent delete
Comment: create readSingle update updateComment delete

Example
jsonPOST /endpoint/user/create.php
Response 201:
{
    "message": "User created."
}

GET /endpoint/user/readSingle.php?id=999
Response 404:
{
    "message": "No user found."
}

DELETE /endpoint/user/delete.php (no id)
Response 400:
{
    "message": "User ID was not provided."
}




From 27 April-3May 2026

Project: PHP Integration with REST API
Overview
This project demonstrates a complete integration between a PHP-based frontend and a RESTful API. The development process evolved from manual cURL handling to a structured, modular architecture.

Phase 1: Manual cURL Operations (The "Deep Dive")
The initial stage involved hard-coding every API request manually. This was the most intensive part of the project, focusing on understanding how data travels between the client and the server.

POST Requests: We manually configured cURL sessions to create data, specifically focusing on:

post/create.php: Initializing the creation of blog posts.

comment/create.php: Generating comments and linking them to specific posts.

Challenges: Each request required about 15–20 lines of code to manage headers, JSON encoding, and session initialization. This stage was critical for mastering the "under-the-hood" mechanics of web communication.

Phase 2: Post Feed with Full Details
Once the creation logic was established, we moved to the visualization of data. We built a dynamic Post Feed that displays the full content of the database.

Recursive Display: Implemented a "Master-Detail" view where the main loop renders the Post and a nested loop renders all associated Comments.

Data Integrity: Added validation checks (e.g., isset()) to ensure the feed remains stable even if certain data fields (like comment text) are missing.

Phase 3: Architecture & Refactoring (functions.php)
To clean up the "messy" code from Phase 1, we implemented a professional refactoring strategy.

Modularization: We extracted the repetitive cURL logic into a central functions.php file. The new callAPI() function reduced the codebase by nearly 80%.

Dynamic GET Parameters: Developed a search feature to fetch a single user by ID (readSingle.php). This required resolving technical issues regarding URL parameters and file-naming conventions (case sensitivity).

User Registration (POST): Transitioned from hard-coded test data to a functional HTML Registration Form, allowing real-time user creation with fields for username, name, email, and age.

Final Project Structure
functions.php: The core engine managing all API communication.

index.php: The primary interface featuring the Post Feed, User Search, and Registration Form.

Endpoints: A suite of external API files (read_all.php, readSingle.php, create.php) serving as the backend.

Key Learning Outcomes
Mastery of HTTP Methods (GET and POST).

Handling JSON payloads and API headers.

Implementing the DRY (Don't Repeat Yourself) principle through PHP functions.

Debugging complex data structures and server response codes.