## Boilerplate for simple PHP web applications

The app name and port can be configured via .env variables

```text
APP_NAME=
APP_PORT=
```

If needed the externally exposed port can be changed

```text
FORWARD_DB_PORT=
```

Application uses JWT, a private secret key needs to be provided

```text
JWT_SECRET_KEY="<YOUR-SECRET-KEY>"
```

Optionally, password salt can be provided

```text
PASSWORD_SALT=
```

### Setup

Copy .env variables

``cp .env.example .env``

Install the dependencies

``docker compose run --rm composer install``

### Running the project

To avoid running helper containers, only nginx needs to be started which will start the containers on which it depends

``docker compose up -d nginx``

### Running migrations

``docker compose run --rm migrations migrations:migrate``

### Running tests

``docker compose run --rm phpunit``
