# Metablock

[![Built With Plugin Machine](https://img.shields.io/badge/Built%20With-Plugin%20Machine-lightgrey)](https://pluginmachine.com)

## Installation

- Git clone:
    - `git clone git@github.com:shelob9/joshmetablock.git`
- Install javascript dependencies
    - `yarn`

## Create Installable ZIP File

- `npx plugin-machine plugin zip`

## Working With JavaScript

- Build JS/CSS
    - `yarn build`
- Start JS/CSS for development
    - `yarn start`
- Test changed files
    - `yarn test --watch`
- Test all files once
    - `yarn test`
    - `yarn test --ci`


## Local Development Environment

A [docker-compose](https://docs.docker.com/samples/wordpress/)-based local development environment is provided.

- Start server
    - `docker-compose up -d`
- Acess Site
    - [http://localhost:6091](http://localhost:6091)
- WP CLI
    - Run any WP CLI command in container:
        - `docker-compose run wpcli wp ...`
    - Setup site with WP CLI
        - `docker-compose run wpcli wp core install --url=http://localhost:6091 --title="Metablock" --admin_user=admin0 --admin_email=something@example.com`
        - `docker-compose run wpcli wp user create admin admin@example.com --role=administrator --user_pass=pass`
