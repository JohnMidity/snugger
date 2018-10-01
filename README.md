# Snugger

**Snugger** is a starterkit for Slim Framework projects

Included:

- **Slim** https://www.slimframework.com
- **Twig** template engine https://twig.symfony.com/
- **Eloquent** ORM from Laravel https://laravel.com/docs/5.7/eloquent
- **Respect** validation engine https://respect-validation.readthedocs.io/
- **PHP dotenv** environment variables https://github.com/vlucas/phpdotenv
- **Phinx** database migration https://phinx.org/
- Twitters **Bootstrap**
- **jQuery**
- Cross site request forgery protection
- **PHPUnit** unit testing (code coverage far from complete in this version)

## Adding a controller

## Adding a route

## Database migrations with Phinx
create a new migration:

`$ vendor/bin/phinx create AddNameToUsersTable`

Edit the file /database/migrations/<NR>add_name_to_users_table.php to up() and down() change the database. Use the Laravel Schema definitions.

Execute a migration to the last version:

`$ vendor/bin/phinx migrate`

Go back one step:

`$ vendor/bin/phinx rollback`

Go back to the start

`$ vendor/bin/phinx rollback -t 0`

`MigrationStub.php` is the template file, `Migration.php` is the base-class file.

# TODO
Open for improvement:

- Improve readme
  - how to add controllers
  - explain how to add routes
- improve bootstrap/app.php by better separating code to files or maybe even use some class system.
- increase number of tested units
- End to end test
- Some files are attached to the app with require_once wich is a bit messy. IDE's don't like this and code-completion fails. Maybe change this into a class hierarchy?
- Gut feeling says that the use of the container-array can be changed to a strong-typed system with interfaces (implements IClass)?

## Thank you ##
Snugger is partly based on the YouTube tutorials of **Codecourse** https://www.youtube.com/user/phpacademy/featured.

See https://codecourse.com/.
