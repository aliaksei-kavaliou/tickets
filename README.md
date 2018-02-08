# Show tickets task implementation

Currently contains two required user stories implementation.
CLI command and GUI to get show tickets inventory.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Requirements

- PHP 7.1.3 or higher
- Yarn

### Installing

Clone application

```
$ git clone https://github.com/aliaksei-kavaliou/tickets.git
$ cd tickets
```

Install dependences:
```
$ composer install
$ yarn install
$ yarn encore --dev
```

## Running the tests

Execute this command to run tests:
```
$ bin/phpunit
```

## Usage
### CLI
Run following conmmand to see command usage info:
```
$ bin/consple app:get-inventory --help
```

### GUI
Run the built-in web server and access the application in your browser at http://localhost:8000
```
$ bin/console server:run
```
Gui version uses [data/shows.csv](data/shows.csv) file as data source.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

