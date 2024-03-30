## Run Locally

Run the containers

```bash
docker-compose up -d
```

Check `docker-compose.yml` for the ports you need to access.

Populate the database by running the SQL scripts in `references/sql-scripts`.

## Concepts
* API: Stands for Application Programming Interface, and it's a way for applications to communicate.
* REST: Stands for Representational State Transfer, and it's a way of organizing an API. Primarily uses GET, POST, PUT and DELETE operations.
* CRUD: Stands for Create, read, update and delete, and these are the operations used to interact with data in a database. Also associated with specific HTTP method POST, GET, PUT and DELETE.
* FastAPI: A framework to design APIs using Python. Based on OpenAPI and JSON schema and compatible with common API standard.
* Pydantic: A library that uses Python type hints to create data models.
