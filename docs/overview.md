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
    public function execute(): bool;
}
```

The return value expresses whether the controller ran to completion. A controller may return
`false` when a precondition was not met — a missing parameter, a failed authorisation check — and
leave the response to the caller.

## `AbstractController`

`AbstractController` stores an application and an input object and exposes them to subclasses:

```php
use Joomla\Controller\AbstractController;

final class DisplayController extends AbstractController
{
    public function execute(): bool
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
| `__construct(?Input $input = null, ?ApplicationInterface $app = null)` | | Both arguments are optional |
| `getApplication(): ApplicationInterface` | `ApplicationInterface` | Throws `UnexpectedValueException` if no application is set |
| `setApplication(ApplicationInterface $app): static` | `$this` | Fluent |
| `getInput(): Input` | `Input` | Throws `UnexpectedValueException` if no input object is set |
| `setInput(Input $input): static` | `$this` | Fluent |

## Things to know before you build on this

**The dependencies are optional at install time but mandatory at runtime.** `joomla/application`
and `joomla/input` are listed under `suggest`, not `require`. `AbstractController` type hints both,
so installing this package alone gives you a class that cannot be instantiated. Install them
alongside:

```bash
composer require joomla/controller joomla/application joomla/input
```

**The getters throw when the dependency is missing.** The constructor accepts `null` for both
dependencies, but `getApplication()` and `getInput()` throw an `UnexpectedValueException` naming
the controller class when nothing was set, as the traits in `joomla/model` do. Either always pass
both dependencies, or check with `hasApplication()` / `hasInput()` before calling a getter.

**The application is typed against `ApplicationInterface`.** Any application implementing
`Joomla\Application\ApplicationInterface` can be injected, not only subclasses of
`AbstractApplication`. `getApplication()` is declared to return the interface, so static analysers
expect you to narrow it with `instanceof` (for example to `WebApplicationInterface`) before calling
methods that only a more specific application has, such as `setBody()` in the example above.

## Using controllers with the Application package

`joomla/application` resolves route targets to callables through
`Joomla\Application\Controller\ControllerResolver`. When it is handed a class name that implements
`ControllerInterface`, it instantiates the class and returns `[$instance, 'execute']`:

```php
$router->get('/articles/:id', DisplayController::class, ['id' => '\d+']);
```

Because the resolver instantiates with `new $class()`, a controller resolved this way must have a
constructor with no required arguments — or must come from a container via
`ContainerControllerResolver`. Such a controller is built without an input object or application,
so its getters throw until it sets them itself. See the `joomla/application` documentation for the
details.

## What this package does not do

* No action or task mapping (`task=article.save` → `save()`); `execute()` is the only entry point.
* No arguments — `execute()` takes none, so route parameters have to travel through `Input`.
* No PSR-7. `execute()` neither receives a request nor returns a response.
* No controller resolution. That lives in `joomla/application`.
