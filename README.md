# Carma Migration Checker

This package will add a new menu item "Migration checker" to the Moonshine admin panel.

## Installation

You can install the package via composer:

```bash
composer require carma/migration-checker
```

## Usage

After installing and configuring the package, you will see a new menu item 'Migration Checker' in your Moonshine admin panel. This will allow you to:

* View all migrations in your system
* Check the status of each migration (Ran/Pending)
* Update and delete migrations as needed

## MigrationService

The main service provided by this package is the `MigrationService` which includes methods to fetch and update migrations.

### Methods:

* `updateAllMigrations()`: This method updates the list of all migrations in the system.
* `getAllMigrationsFromSystem()`: This protected method retrieves all migration files from the system.