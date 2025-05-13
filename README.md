# PhysioMobile - Patient Service
A Laravel-based RESTful API for managing patient data with secure access control.

## Tech Stack
- **Framework**: Laravel 12 (PHP 8.2)
- **DBMS**: MySQL (8.0.30) 

## Requirements

- PHP 8.2+
- Laravel 12
- Composer
- MySQL

## Installation

1. Clone the repository:
```bash
git clone https://github.com/hildanku/patient-backend.git

cd patient-backend
```
2. Install dependencies:
```bash
composer install
```
3. Set up environment variables:
```bash 
cp .env.example .env
php artisan key:generate
```
4. Configure your database in the .env file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=patient_management
DB_USERNAME=root
DB_PASSWORD=
```

5. Set up your access key for API authentication:
```
ACCESS_KEY=your_secure_access_key_here
```

6. Run migrations:
```bash
php artisan migrate
```
7. Start the development server:
```bash
php artisan serve
```

## Important Notes
All endpoints require the following headers:
```
accessKey: <ACCESS_KEY_IN_ENV> 
# or by default if you copy .env.example to .env the value accessKey is physiomobile!
```

## API Endpoints
### Get All Patients

```
URL: /api/patients
Method: GET
Headers: 
    accessKey: your_secure_access_key_here
```
Success Response:
```json
{
  "message": "Success",
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "medium_acquisition": "mobile",
      "created_at": "2023-05-13T10:30:00.000000Z",
      "updated_at": "2023-05-13T10:30:00.000000Z",
      "user": {
        "id": 1,
        "name": "Lorem Ipsum",
        "id_type": "KTP",
        "id_no": "330000000000000000",
        "gender": "male",
        "dob": "1990-01-01",
        "address": "Jl. Lorem Ipsum Dolor Sit Amet",
        "created_at": "2023-05-13T10:30:00.000000Z",
        "updated_at": "2023-05-13T10:30:00.000000Z"
      }
    }
  ]
}
```
Empty Response:
```json
{
  "message": "No patient found",
  "data": []
}
```
---
### Create Patient

```
URL: /api/patients
Method: POST
Headers: 
    accessKey: your_secure_access_key_here
    Content-Type: application/json
```

Body:
```json
{
  "name": "Lorem Ipsum",
  "id_type": "KTP",
  "id_no": "333000000000000000",
  "gender": "male",
  "dob": "1990-01-01",
  "address": "Jl. Lorem Ipsum Dolor Sit Amet",
  "medium_acquisition": "mobile"
}
```

Success Response (201 Created):
```json
{
  "message": "Patient created successfully",
  "data": {
    "id": 1,
    "user_id": 1,
    "medium_acquisition": "mobile",
    "created_at": "2023-05-13T10:30:00.000000Z",
    "updated_at": "2023-05-13T10:30:00.000000Z",
    "user": {
      "id": 1,
      "name": "Lorem Ipsum",
      "id_type": "KTP",
      "id_no": "3300000000000000",
      "gender": "male",
      "dob": "1990-01-01",
      "address": "Jl. Lorem Ipsum Dolor Sit Amet",
      "created_at": "2023-05-13T10:30:00.000000Z",
      "updated_at": "2023-05-13T10:30:00.000000Z"
    }
  }
}
```

Validation Error Response (422 Unprocessable Entity):

```json
{
  "message": "Validation error",
  "errors": {
    "name": ["The name field must be a string."],
    "id_type": ["The id type field is required."]
  }
}
```
---
### Get Patient Details

```
URL: /api/patients/{id}
Method: GET
Headers: 
    accessKey: your_secure_access_key_here
```

Success Response:

```json
{
  "message": "Success",
  "data": {
    "id": 1,
    "user_id": 1,
    "medium_acquisition": "mobile",
    "created_at": "2023-05-13T10:30:00.000000Z",
    "updated_at": "2023-05-13T10:30:00.000000Z",
    "user": {
      "id": 1,
      "name": "Lorem Ipsum",
      "id_type": "KTP",
      "id_no": "33300000000000000",
      "gender": "male",
      "dob": "1990-01-01",
      "address": "Jl. Lorem Ipsum Dolor Sit Amet",
      "created_at": "2023-05-13T10:30:00.000000Z",
      "updated_at": "2023-05-13T10:30:00.000000Z"
    }
  }
}
```

Not Found Response (404 Not Found):
```json
{
  "message": "Patient not found",
  "data": null
}
```
---
### Update Patient

```
URL: /api/patients/{id}
Method: PUT
Headers: 
    accessKey: your_secure_access_key_here
    Content-Type: application/json
```
Body (partial updates supported):
```json
{
  "name": "Ipsum Lorem",
  "address": "Jl. Ipsum Dolor Sit Amet",
  "medium_acquisition": "website"
}
```
Success Response:
```json
{
  "message": "Patient updated successfully",
  "data": {
    "id": 1,
    "user_id": 1,
    "medium_acquisition": "website",
    "created_at": "2023-05-13T10:30:00.000000Z",
    "updated_at": "2023-05-13T11:45:00.000000Z",
    "user": {
      "id": 1,
      "name": "Ipsum Lorem",
      "id_type": "passport",
      "id_no": "AB123456",
      "gender": "male",
      "dob": "1990-01-01",
      "address": "Jl. Ipsum Dolor Sit Amet",
      "created_at": "2023-05-13T10:30:00.000000Z",
      "updated_at": "2023-05-13T11:45:00.000000Z"
    }
  }
}
```

Validation Error Response (422 Unprocessable Entity):
```json
{
  "message": "Validation error",
  "errors": {
    "name": ["The name field must be a string."]
  }
}
```
Not Found Response (404 Not Found):
```json
{
  "message": "Patient not found",
  "data": null
}
```

### Delete Patient

```
URL: /api/patients/{id}
Method: DELETE
Headers: 
    accessKey: your_secure_access_key_here
```
Success Response:
```json
{
  "message": "Patient deleted successfully",
  "data": null
}
```
Not Found Response (404 Not Found):
```json
{
  "message": "Patient not found",
  "data": null
}
```

## Important Implementation Details

1. Access Control: All API endpoints are protected by the HasAccessKey middleware which verifies the accessKey header.
2. Data Validation: Proper validation is implemented for all user inputs using Laravel's validation system.
3. Consistent JSON Responses: The system ensures consistent JSON responses even for error cases, avoiding HTML error responses.
4. Database Transaction: This ensures data consistency, if any step fails during the operation, all changes are automatically rolled back, preventing partial writes and maintaining relational integrity.
