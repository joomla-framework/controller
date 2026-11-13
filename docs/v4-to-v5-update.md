# Updating from v4 to v5

Release 5.0.0 adds native types to the controller API, types the application against
`ApplicationInterface` and makes the getters throw when their dependency was not set.

## At a glance

| | v4 | v5 |
|---|---|---|
| `ControllerInterface::execute()` | untyped | `execute(): bool` |
| Application type | `AbstractApplication` | `ApplicationInterface` |
| `getApplication()` / `getInput()` without a dependency | return `null` (deprecated since 4.1) | throw `UnexpectedValueException` |
| `setApplication()` / `setInput()` | untyped | return `static` |

## Native return types

`ControllerInterface::execute()` now declares `bool`. Every controller has to add the return type
and actually return a boolean:

```php
// v4
public function execute()
{
    // …
}

// v5
public function execute(): bool
{
    // …

    return true;
}
```

`AbstractController`'s methods are typed as well. Subclasses that override them must use
compatible signatures:

| Method | v4 | v5 |
|---|---|---|
| `__construct()` | `(?Input $input = null, ?AbstractApplication $app = null)` | `(?Input $input = null, ?ApplicationInterface $app = null)` |
| `getApplication()` | untyped, `AbstractApplication\|null` | `getApplication(): ApplicationInterface` |
| `setApplication()` | `(AbstractApplication $app)` | `(ApplicationInterface $app): static` |
| `getInput()` | untyped, `Input\|null` | `getInput(): Input` |
| `setInput()` | `(Input $input)` | `(Input $input): static` |

The `$app` and `$input` properties are private and now typed `?ApplicationInterface` and `?Input`.

## The application is typed against `ApplicationInterface`

The constructor and `setApplication()` accept any `Joomla\Application\ApplicationInterface`, not
only subclasses of `AbstractApplication`. Callers need no change. Subclasses that override
`setApplication()` must widen the parameter to `ApplicationInterface`, and code that relies on
`getApplication()` returning an `AbstractApplication` (or a web application) has to narrow the
result with `instanceof` for static analysis.

## The getters throw when nothing is set

In 4.x, `getApplication()` and `getInput()` returned `null` when the controller was built without
that dependency; since 4.1 this triggers a deprecation notice. In 5.0 they throw an
`UnexpectedValueException` naming the controller class instead. Check with `hasApplication()` /
`hasInput()` (available since 4.1) where a dependency may legitimately be missing:

```php
// v4
if ($this->getInput() === null) {
    // …
}

// v5
if (!$this->hasInput()) {
    // …
}
```
