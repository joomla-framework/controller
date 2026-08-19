# Overview

The Controller package defines what a controller is in the Joomla Framework: an object with a
single `execute()` method. It ships only one interface and one abstract base class.

```bash
composer require joomla/controller
```

## What is in the package

| Class | Purpose |
|---|---|
| `Joomla\Controller\ControllerInterface` | The contract — `execute(): bool` |
| `Joomla\Controller\AbstractController` | A base class holding an application and an input object |

## `ControllerInterface`

```php
interface ControllerInterface
{
    /**
     * @return  boolean  True if the controller finished execution, false if it did not.
     *
     * @throws  \LogicException
     * @throws  \RuntimeException
     */
    public function execute();
}
```

The return value expresses whether the controller ran to completion. A controller may return
`false` when a precondition was not met — a missing parameter, a failed authorisation check — and
leave the response to the caller.

## `AbstractController`

`AbstractController` stores an application and an input object and exposes them to subclasses:

```php
use Joomla\Application\AbstractApplication;
use Joomla\Controller\AbstractController;
use Joomla\Input\Input;

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

### API

| Method | Returns | Notes |
|---|---|---|
| `__construct(?Input $input = null, ?AbstractApplication $app = null)` | | Both arguments are optional |
| `getApplication()` | `AbstractApplication\|null` | |
| `setApplication(AbstractApplication $app)` | `$this` | Fluent |
| `getInput()` | `Input\|null` | |
| `setInput(Input $input)` | `$this` | Fluent |

## Things to know before you build on this

**The dependencies are optional at install time but mandatory at runtime.** `joomla/application`
and `joomla/input` are listed under `suggest`, not `require`. `AbstractController` type hints both,
so installing this package alone gives you a class that cannot be instantiated. Install them
alongside:

```bash
composer require joomla/controller joomla/application joomla/input
```

**The getters can return `null`.** The constructor accepts `null` for both dependencies and the
getters hand that `null` straight back. A controller written as
`$this->getInput()->getUint('id')` therefore fails with *Call to a member function on null* when
the controller was built without an input object. Either always pass both dependencies, or guard:

```php
public function execute()
{
    $input = $this->getInput();

    if ($input === null) {
        throw new \LogicException('No input object was set on ' . static::class);
    }

    // …
}
```

Note that `joomla/model` solves the same problem the other way round — its traits throw an
`UnexpectedValueException` from the getter. This package does not.

**`AbstractApplication` is a class, not an interface.** `setApplication()` accepts only
`Joomla\Application\AbstractApplication` or a subclass. An application that implements
`Joomla\Application\ApplicationInterface` without extending the abstract class cannot be used.

## Using controllers with the Application package

`joomla/application` resolves route targets to callables through
`Joomla\Application\Controller\ControllerResolver`. When it is handed a class name that implements
`ControllerInterface`, it instantiates the class and returns `[$instance, 'execute']`:

```php
$router->get('/articles/:id', DisplayController::class, ['id' => '\d+']);
```

Because the resolver instantiates with `new $class()`, a controller resolved this way must have a
constructor with no required arguments — or must come from a container via
`ContainerControllerResolver`. See the `joomla/application` documentation for the details.

## What this package does not do

* No action or task mapping (`task=article.save` → `save()`); `execute()` is the only entry point.
* No arguments — `execute()` takes none, so route parameters have to travel through `Input`.
* No PSR-7. `execute()` neither receives a request nor returns a response.
* No controller resolution. That lives in `joomla/application`.
