# currency_task

run:
`docker compose up -d`
`docker exec -it php bash`
`composer install`
`php bin/console d:m:m`

coding standards:
`composer codetest`

main command:
`php bin/console update:currency`

`run docker cp php:/app/vendor .`
