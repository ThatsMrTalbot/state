# State

Simple state management.

## About

This is a simple action dispatcher and state manager. It has the following components

1. *State* - Is the state object it contains all the data you want to manage
2. *Action* - Is an action informing a state update
3. *Dispatcher* - Dispatches actions to registered stores

## Example

LoginAction.php
```php
class LoginAction extends \State\Action {
    private $uid;

    private function __constructor($uid) {
        $this->uid = $uid;
    }

    public function getUID() {
        return $this->uid;
    }

    public static function fromUser($username, $password) {
        // Some heavy lifting here
        $uid = do_login_action($username, $password);

        if (!$uid) {
            // Should return error action
        }

        return new LoginAction($uid);
    }
}
```

```php
class UserState extends \State\State {
    private $uid;

    public function getUID() {
        return $this->uid;
    }

    public static function reduce(\State\Action $action, self $state) : self {
        switch (true) {
            case LoginAction::is($action):
                return $state->mutate(['uid' => $action->getUID()]);
            default:
                return $state;
        }
    }
}
```

```php
$state = new UserState();
$dispatcher = new \State\Dispatcher();

$dispatcher->register($state);

function login($username, $password) {
    $dispatcher->dispatch(LoginAction::fromUser($username, $password));
}

```