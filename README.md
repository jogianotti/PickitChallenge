# Pickit Challenge

## Docker deploy
Used versions
```text
Docker: 20.10.7
Docker Compose: 1.27.4
```


Create docker-compose.override.yaml file to set a free port.
```yaml
# file: docker-compose.override.yaml

version: '3'

services:

    apache:
        ports:
            - "8080:80"
```

Build and run containers 
```shell
docker-compose build
docker-compose up --detach
```

Execute database migrations
```shell
docker-compose exec php bin/console doctrine:migrations:migrate 
docker-compose exec php bin/console doctrine:migrations:migrate --env=test
```

Execute tests
```shell
docker-compose exec php bin/phpunit
```
Api use cases examples
> The *example.http* file contains the use cases examples. 