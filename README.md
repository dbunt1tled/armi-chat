Yii 2 long polling chat
============================

Simple chat on Yii 2 basic project template.


INSTALLATION
------------

### Install via github

You can install this application the following command:

~~~
git clone https://github.com/dbunt1tled/armi-chat.git ./
~~~

CONFIGURATION
-------------

### Vendors

Install depending modules

~~~
 composer update
~~~

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=armi-chat',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```
#### Applying Migrations

To upgrade a database to its latest structure, you should apply all available new migrations using the following command:

~~~
yii migrate up
~~~

Now you should be able to access the application through the following URL

~~~
http://localhost/
~~~

Instructions for use
-------

- `Enter your name`
- `Enter your message`
- `Click on Send button`

**Note**
User go offline if not active for more than 5 minutes