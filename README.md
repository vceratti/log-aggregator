# log-aggregator


## Application

Tech stack:
- PHP 8.2
- Symfony 6.2
- MySql 8.0
- RabbitMQ
- Docker (docker compose for development)

### NOTES:

- [ASSUMPTIONS / TODOs](ASSUMPTIONS.md)
- The automatic workers are still NOT implemented; I intend to add supervisor in the next version.
  - **However**, [RequestLogLifeCycleTest](./tests/Functional/Application/RequestLogLifeCycleTest.php) shows the commands that
are implemented as well as the API endpoint, all working together in a functional test
- I took this task also as exercise/learning some concepts and libraries:
- TDD, DDD, SOLID, [The Twelve-Factor App](https://12factor.net)
- High test coverage with #Covers attributes to prevent [unintentional code coverage](https://docs.phpunit.de/en/10.2/risky-tests.html#risky-tests-unintentionally-covered-code)
- strict code rules checked by [phpmd](phpmd.xml)
- strict typing with generics checked by [phpstan](phpstan.neon)

## Requirements

Docker and Docker compose

## Install

The provided `composer` executable will run the application using docker-compose ahd execute composer inside
the container. To install and execute the application, run:

```bash
./composer install
```

The `composer` script will:
- create a new `.env` if it doesn't exist
- check if `app` container is up and running
   - if not, `compose_exec up -d --build --pull=always` is executed (helping also with rebuilding on updates)
- run any composer command inside the container

The `composer install` command will:
- run composer install
- run database migrations in the containers
   - it waits for the DB to be ready, but if it times out or fail please re-run it

See [docker-app](./docker-app) and [composer](./composer)

The application will be then available in `http://localhost:8080` (simple PHP native server)

## Development

All common commands are defined as composer scripts and can be executed with the provider `composer` executable

The following command will execute all expected steps before a commit is pushed:

```bash
./composer pre-commit
```

pre-commit will:
- update the database (run [migrations](./migrations))
- fix code style ([php-cs-fixer](.php-cs-fixer.dist.php)
- syntax and type check ([phpstan](phpstan.neon))
- clean code / design check ([phpmd](phpmd.xml))
- run tests with coverage report ([phpunit](phpunit.xml))

See `scripts` in [composer.json](composer.json) for details

Cached resources for the container (composer cache, database persistence) as well as reports generated by the tools
mentioned above are stored in the unversioned `/var/cache` directory

Composer scripts already provide some useful shortcuts, but `Symfony console` can also be executed also with a
[helper script](./console):

```bash
./console {symfony console command}
```