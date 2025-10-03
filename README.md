# hot to start
`docker-compose up -d`
`docker-compose exec php php yii migrate`

go to http://localhost:8000/

admin user login and password: admin/admin

# tests
`docker-compose exec php ./vendor/bin/codecept run --no-colors`
`docker-compose exec php ./vendor/bin/codecept run unit -v`
`docker-compose exec php ./vendor/bin/codecept run functional -v`