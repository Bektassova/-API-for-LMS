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