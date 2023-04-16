## Boilerplate for simple PHP web applications

The app name and port can be configured via .env variables

```text
APP_NAME=
APP_PORT=

FORWARD_DB_PORT=
```

### Setup

Copy .env variables

``cp .env.example .env``

Install the dependencies

``docker compose run --rm composer install``

### Running the project

To avoid running helper containers, only nginx needs to be started which will start the containers on which it depends

``docker compose up -d nginx``
