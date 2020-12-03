# Simple Shift Manager API

This is an API service to manage (review and process) worker's shifts applications.

## Servers:


##### GET Request [http://localhost/api/workers]
  - **Description:** view workers (two per page)
  - **Variables:**
        `page`: pagination (page number)

##### GET Request [http://localhost/api/worker/{id}/applications]
  - **Description:** view worker's applications
  - **Variables:**
        `id`: worker Id.
        `status`: view application of certain type (`pending`, `approved`, `declined`).
        `shift`: include shift object inside application object (`?shift=include`).

##### PATCH Request [http://localhost/api/worker/{id}/applications]
  - **Description:** Update a selection of worker's applications (either approved or declined application)
  - **Variables:**
        `id`: worker Id.
        `JSON`:  object of applications with either approved or declined status
  - **Example:** `JSON` PATCH request body as following
  ```
    [
        {
            "id": 10,
            "status": "declined"
        },
        {
            "id": 11,
            "status": "approved"
        },
        {
            "id": 12,
            "status": "approved"
        }
    ]
```
