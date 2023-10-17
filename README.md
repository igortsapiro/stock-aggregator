### Installation
- clone project
- copy env file `cp .env.example .env`
- run `docker-compose up -d`
- after building go into php container `docker-compose exec app bash`
- inside the container run next commands:  
  - `composer install`
  - `php artisan key:generate`
  - `php artisan migrate`

### Run tests
All tests are placed in folder `/tests`  
To run tests just call next command in terminal `php artisan test`

### Main Logic

- There is prepared artisan command that is run in cron `RefreshEnabledStocksCommand`.
It has main logic to retrieve data from aggregator api, insert in db and put it to the cache.
To check the command how it works, run `php artisan app:refresh-enabled-stocks-command`
- API endpoints are placed in `app/Http/Controllers/Api`. Examples how to use them you can find in tests.
Controllers handle/validate request params and redirect them to Services then main business logic
are handled in Service class: retrieve/save data from db or cache. Next step is to get data, here
it goes to repository where first it check if data exists in cache and return it, if not them make a query
to database.
- In the code you can find that data is kept 30 days in the cache. It's made in case of aggregator api can return
intraday data with several days interval and to avoid to make unneeded request to db I prolong ttl for such amount of days.
