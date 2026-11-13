# The Controller Package [![Build Status](https://github.com/joomla-framework/controller/actions/workflows/ci.yml/badge.svg?branch=4.x-dev)](https://github.com/joomla-framework/controller)

[![Latest Stable Version](https://poser.pugx.org/joomla/controller/v/stable)](https://packagist.org/packages/joomla/controller)
[![Total Downloads](https://poser.pugx.org/joomla/controller/downloads)](https://packagist.org/packages/joomla/controller)
[![Latest Unstable Version](https://poser.pugx.org/joomla/controller/v/unstable)](https://packagist.org/packages/joomla/controller)
[![License](https://poser.pugx.org/joomla/controller/license)](https://packagist.org/packages/joomla/controller)

The Controller package defines what a controller is in the Joomla Framework: an object with a single `execute()`
method. It ships one interface and one abstract base class.

| Class | Purpose |
|---|---|
| `Joomla\Controller\ControllerInterface` | The contract: `execute()`, returning `true` if the controller finished execution and `false` if it did not |
| `Joomla\Controller\AbstractController` | A base class holding a `Joomla\Input\Input` and a `Joomla\Application\AbstractApplication` object |

## Usage

`AbstractController` takes the input and the application as optional constructor arguments, and has the
setters `setInput()` / `setApplication()` and the getters `getInput()` / `getApplication()`. A subclass only has
to implement `execute()`:

```php
use Joomla\Controller\AbstractController;

final class DisplayController extends AbstractController
{
    public function execute()
    {
        $id = $this->getInput()->getUint('id');

        if ($id === 0) {
            return false;
        }

        $this->getApplication()->setBody('Article ' . $id);

        return true;
    }
}

$controller = new DisplayController($input, $app);
$controller->execute();
```

There is no task mapping: each controller does one thing, and `execute()` takes no arguments. Route targets are
resolved to controllers by `joomla/application`'s `ControllerResolver`.

See the [documentation](docs/index.md) for details, including what the getters return when no dependency was
set, and the update guides in `docs/` when upgrading between major versions.

## Installation via Composer

Add `"joomla/controller": "~4.0"` to the require block in your composer.json and then run `composer install`.

```json
{
	"require": {
		"joomla/controller": "~4.0"
	}
}
```

Alternatively, you can simply run the following from the command line:

```sh
composer require joomla/controller "~4.0"
```

If you want to include the test sources, use

```sh
composer require --prefer-source joomla/controller "~4.0"
```
