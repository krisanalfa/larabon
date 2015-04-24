## Laravel Like Bono

Have you ever heard [Bono PHP Framework](https://github.com/xinix-technology/bono)? If you don't, you must try that framework. It's awesome framework! For those who knows about Bono and want to try Laravel in Bono way. Then, this archetype can help you to do so.

## Components

- Bono URL mapping
- Norm Schema for renderring Model
- Content Negotiator
- (more to come)

## Pre-requisites

- MongoDB
- PHP Mongo
- PHP >= 5.4

## Installing

Make sure you have installed `npm` and these modules:

- Bower
- Gulp

And run:

```
npm install
gulp
```

Done, you can try `php artisan serve` to try the Built In PHP server to quick test-drive this Framework.

## Query

### `AND EQUAL`

```
http://host/resources?name=Foo&?email=foo@mail.io
```

It will assume there's a record in database that match: `name = "Foo" AND email = "foo@mail.io"`

### `OR EQUAL`

```
http://host/resources?username=krisanalfa&!or[email]=krisan47@gmail.com

OR

http://host/resources?username=krisanalfa&!or[email]=!eq:krisan47@gmail.com
```

It will assume there's a record in database that match: `username = "krisanalfa" OR email = "krisan47@gmail.com"`

### `OR LESS THAN`

```
http://host/resource?name=Administrator&!or[age]=!lt:25
```

It will assume there's a record in database that match: `name = "Administrator" OR age < 25`

### `OR LESS THAN EQUAL`

```
http://host/resource?name=Administrator&!or[age]=!lte:25
```

It will assume there's a record in database that match: `name = "Administrator" OR age <= 25`

### `OR GREATER THAN`

```
http://host/resource?name=Administrator&!or[age]=!gt:25
```

It will assume there's a record in database that match: `name = "Administrator" OR age > 25`

### `OR GREATER THAN EQUAL`

```
http://host/resource?name=Administrator&!or[age]=!gte:25
```

It will assume there's a record in database that match: `name = "Administrator" OR age >= 25`

### `LESS THAN`

```
http://host/resource!lt[age]=30
```

It will assume there's a record in database that match: `age < 30`

### `LESS THAN OR EQUAL`

```
http://host/resource!lte[age]=30
```

It will assume there's a record in database that match: `age <= 30`

### `GREATER THAN`

```
http://host/resource!gt[age]=30
```

It will assume there's a record in database that match: `age > 30`

### `GREATER THAN OR EQUAL`

```
http://host/resource!gte[age]=30
```

It will assume there's a record in database that match: `age >= 30`

### `SKIP`

(TBD)

### `LIMIT`

(TBD)

### `SORT`

(TBD)

## Hacking Data

Make sure you have read the `BonoizeController`. You can see the response is handled by event. You can register your event to manipulate basic response. Or, you can change the behavior of `DataTransport` (**not recomended**). I'll explain the detail later.

## What to read?

- `bonoize.php`
- `BonoizeServiceProvider`
- `ContentNegotiator`
- `ControllerEventsHandler`
