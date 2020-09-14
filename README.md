# Ajax actions behavior for Yii2 Framework.

Simple yii2 behavior, what auto set JSON response format to actions.

## Getting Started

### Installing

Run in your terminal

```bash
> composer require srv44/yii2-ajax-actions-behavior ^1.0
```

### Usage

#### AjaxActionsBehavior
Add in controller behaviors
##### Simple:
> Note! By default, AjaxActionsBehavior::checkResponse = true. It`s run afterAction validation of returned value.
```php
use srv44\AjaxActions\AjaxActionsBehavior;

...

public function behaviors()
{
    return [
        ...
        AjaxActionsBehavior::className(),
    ];
}
```

##### With disable afterAction validate returned value:

```php
use srv44\AjaxActions\AjaxActionsBehavior;

...

public function behaviors()
{
    return [
        ...
        [
            'class' => AjaxActionsBehavior::className(),
            'checkResponse' => false
        ],
    ];
}

...
```

#### Actions

You ajax actions name must be start with actionAjax{YourAction}.

##### Example:

```php
...

public function actionAjaxYourAction() 
{
    ...
}

...
```

If you disabled AjaxActionsBehavior::checkResponse, you may return any value.

```php
...

public function actionAjaxYourAction() 
{
    return 'some value';
}
// result: 'some value'

...
```

By default, you need return array value with 'success' => (bool)

```php
...

public function actionAjaxYourAction() 
{
    return ['success' => true, 'your' => 'value'];
}
// result: {"success":true,"your":"value"}

...
```

#### AjaxActionsHelper

To make things easier, you can use the AjaxActionsHelper.

It is a simple helper that provides several static methods.

The most necessary are success([array $params]) and error([string $errorMsg, array $params, string $errorMsgKey])

##### Examples

AjaxActionsHelper::success

```php
use srv44\AjaxActions\AjaxActionsHelper;

...

// without params
public function actionAjaxWithoutParams() 
{
    return AjaxActionsHelper::success();
}
// result: {"success":true}

// with params
public function actionAjaxWithParams() 
{
    return AjaxActionsHelper::success(['your' => 'value']);
}
// result: {"success":true}

...
```

AjaxActionsHelper::error

```php
use srv44\AjaxActions\AjaxActionsHelper;

...

// Without params
public function actionAjaxWithoutParams() 
{
    return AjaxActionsHelper::error();
}
// result: {"success":false, "errorMessage":"Error!"}

// Only error message
public function actionAjaxOnlyErrorMessage() 
{
    return AjaxActionsHelper::error('Bad request!');
}
// result: {"success":false, "errorMessage":"Bad request!"}

// With error message and params
public function actionAjaxWithErrorMessageAndParams() 
{
    return AjaxActionsHelper::error('Bad request!', ['your' => 'value']);
}
// result: {"success":false, "errorMessage":"Bad request!", "your" => "value"}

// With custom error message field
public function actionAjaxWithCustomErrorField() 
{
    return AjaxActionsHelper::error('Bad request!', ['your' => 'value'], 'myErrorMessage');
}
// result: {"success":false, "myErrorMessage":"Bad request!", "your" => "value"}

...
```

## Running the tests

PhpUnit /tests

```bash
> vendor/bin/phpunit
``` 

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
