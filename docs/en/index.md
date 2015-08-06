# Quickstart

This extension replaces value object `Http\Request` that is used as a service,
with a `RequestStack` that can hold onto `Http\Request` and change it in runtime.


## Installation

You can install the extension using this command

```sh
$ composer require kdyby/request-stack
```

and enable the extension using your neon config.

```yml
extensions:
	requestStack: Kdyby\RequestStack\DI\RequestStackExtension
```


## Usage

Everywhere where you depend on `Http\Request` in your application, you have to replace it with `Http\IRequest`.
This allows for the `RequestStack` to be injected instead.

When you want to change the `Http\Request` object, you simply call

```php
$httpRequestStack->pushRequest(new Http\Request(
	new UrlScript('https://www.kdyby.org/?some=query'),
	NULL, // deprecated
	[],  // post
	[], // files
	[], // cookies
	[], // headers
	'GET', // HTTP method
	'127.0.0.1', // remote address
	'127.0.0.1' // remote host
));
```

And that's it.
