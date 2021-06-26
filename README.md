# Tic tac toe - Laravel REST API

## Setup

```shell
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

## Tests

```shell
composer test
```

# REST API Documentation

## Get or start the game

### Request

`GET /api/`

    curl -i -H 'Accept: application/json' http://localhost:8000/api/

### Response

    HTTP/1.1 200 OK
    Date: Sat, 26 Jun 2021 14:14:14 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    []

## Make a move

### Request

`POST /api/`

    curl -i -H 'Accept: application/json' -X POST -d 'x=1&y=0' http://localhost:8000/api/x

### Response

    HTTP/1.1 200 OK
    Date: Sat, 26 Jun 2021 14:14:14 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    []

## Restart the game

### Request

`POST /api/restart`

    curl -i -H 'Accept: application/json' -X POST http://localhost:8000/api/restart

### Response

    HTTP/1.1 200 OK
    Date: Sat, 26 Jun 2021 14:14:14 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    []

## Delete the game

### Request

`DELETE /api/`

    curl -i -H 'Accept: application/json' -X DELETE http://localhost:8000/api/

### Response

    HTTP/1.1 204 No Content
    Date: Sat, 26 Jun 2021 14:14:14 GMT
    Status: 204 No Content
    Connection: close
