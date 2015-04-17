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

## Hacking Data

Make sure you have read the `BonoizeController`. You can see the response is handled by event. You can register your event to manipulate basic response. Or, you can change the behavior of `DataTransport` (**not recomended**). I'll explain the detail later.

## What to read?

- `bonoize.php`
- `BonoizeServiceProvider`
- `ContentNegotiator`
- `ControllerEventsHandler`

