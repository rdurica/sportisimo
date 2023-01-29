# Sportisimo

[![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)](http://php.net)
[![Docker](https://img.shields.io/badge/Docker-powered-blue.svg)](https://www.docker.com/)
[![Nette](https://img.shields.io/badge/Nette-powered-blue.svg)](https://nette.org/)
[![composer](https://img.shields.io/badge/composer-latest-green.svg)](https://getcomposer.org/)

## Overview

For this project no additional libraries were used (Except CodeSniffer for code consistency and Naja for AJAX requests)

- Translations are not implemented (all text in CZ language directly)
- Contains simple authentication without registration,roles etc..
- Test cases not included
- Database credentials (username: root, password: password)
- App credentials (username: Administrator, password: password)

## Preview

<img width="1321" alt="Screenshot 2023-01-29 at 23 45 45" src="https://user-images.githubusercontent.com/16089770/215360052-03aed58f-f42b-4bb7-ae5d-29fb2b276afa.png">
<img width="1435" alt="Screenshot 2023-01-30 at 0 15 38" src="https://user-images.githubusercontent.com/16089770/215361220-1ba6c9f3-45fb-48a7-9cff-28709f2fd159.png">
<img width="1435" alt="Screenshot 2023-01-30 at 0 18 30" src="https://user-images.githubusercontent.com/16089770/215361366-238f07a0-c4ef-4d59-a80b-b24838a190a4.png">

## Installation (Using docker-compose)

Application is shipped with created docker image. Used commands are for linux/mac users.

#### Step 1 - Clone repository

```shell
git clone https://github.com/rdurica/sportisimo.git
```

#### Step 2 - Navigate to project dir

```shell
cd sportisimo
```

#### Step 3 - Build containers (PHP + MySQL)

```shell
docker-compose build
```

#### Step 4 - Run containers

```shell
docker-compose up -d
```

#### Step 5 - Switch into php container

```shell
docker exec -it sportisimo_app /bin/bash
```

#### Step 6 - Run init commands (inside container)

```shell
composer install
cp config/example.local.neon config/example.local.neon
```

#### Step 7 - Update config & Run migrations

- Update <code>src/config/local.neon</code> - Insert db connection details
- Create database and run initial script <code>src/mirations/202301292216_init.sql</code>

#### Step 8 - Finish

Visit website at: http://127.0.0.1:8000/

## License

This project is licensed under the terms of the MIT license.