<?php

/**
 * @testCase
 */

namespace KdybyTests\RequestStack;

use Kdyby;
use Kdyby\RequestStack\RequestStack;
use KdybyTests;
use Nette;
use Nette\Http\Url;
use Nette\Http\UrlScript;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class RequestStackTest extends Tester\TestCase
{

	public function testPushAndPop()
	{
		$stack = new RequestStack();

		$url = new UrlScript('https://www.kdyby.org/');

		$request1 = new Nette\Http\Request($url);
		$stack->pushRequest($request1);
		Assert::same($request1, $stack->getCurrentRequest());

		$request2 = new Nette\Http\Request($url);
		$stack->pushRequest($request2);
		Assert::same($request2, $stack->getCurrentRequest());

		$head = $stack->popRequest();
		Assert::same($request2, $head);
		Assert::same($request1, $stack->getCurrentRequest());

		$head = $stack->popRequest();
		Assert::same($request1, $head);
		Assert::null($stack->getCurrentRequest());
	}

	public function testEmptyStack()
	{
		$stack = new RequestStack();

		Assert::null($stack->getCurrentRequest());
		Assert::null($stack->popRequest());
		Assert::null($stack->getCurrentRequest());
		Assert::null($stack->getUrl());
		Assert::same([], $stack->getQuery());
		Assert::null($stack->getQuery('foo'));
		Assert::same([], $stack->getPost());
		Assert::null($stack->getPost('foo'));
		Assert::null($stack->getFile('f'));
		Assert::same([], $stack->getFiles());
		Assert::null($stack->getCookie('c'));
		Assert::same([], $stack->getCookies());
		Assert::null($stack->getMethod());
		Assert::false($stack->isMethod('GET'));
		Assert::null($stack->getHeader('Accept-Language'));
		Assert::same([], $stack->getHeaders());
		Assert::false($stack->isSecured());
		Assert::false($stack->isAjax());
		Assert::null($stack->getRemoteAddress());
		Assert::null($stack->getRemoteHost());
		Assert::null($stack->getRawBody());
		Assert::null($stack->detectLanguage(['en']));
		Assert::null($stack->getReferer());
	}

	public function testNonEmptyStack()
	{
		$stack = new RequestStack();

		$httpRequest = new Nette\Http\Request(
			new UrlScript('https://www.kdyby.org/?hello=no'),
			NULL,
			['foo' => 'foo'],
			['f' => $f = new Nette\Http\FileUpload([])],
			['c' => 'C'],
			['accept-language' => 'en', 'x-requested-with' => 'XMLHttpRequest', 'referer' => 'https://www.example.com'],
			'GET',
			'127.0.0.1',
			'localhost'
		);
		$stack->pushRequest($httpRequest);

		Assert::same($httpRequest, $stack->getCurrentRequest());
		Assert::equal($httpRequest->getUrl(), $stack->getUrl());
		Assert::same(['hello' => 'no'], $stack->getQuery());
		Assert::same('no', $stack->getQuery('hello'));
		Assert::same(['foo' => 'foo'], $stack->getPost());
		Assert::same('foo', $stack->getPost('foo'));
		Assert::same($f, $stack->getFile('f'));
		Assert::same(['f' => $f], $stack->getFiles());
		Assert::same('C', $stack->getCookie('c'));
		Assert::same(['c' => 'C'], $stack->getCookies());
		Assert::same('GET', $stack->getMethod());
		Assert::true($stack->isMethod('GET'));
		Assert::same(['accept-language' => 'en', 'x-requested-with' => 'XMLHttpRequest', 'referer' => 'https://www.example.com'], $stack->getHeaders());
		Assert::same('en', $stack->getHeader('Accept-Language'));
		Assert::true($stack->isSecured());
		Assert::true($stack->isAjax());
		Assert::same('127.0.0.1', $stack->getRemoteAddress());
		Assert::same('localhost', $stack->getRemoteHost());
		Assert::same('', $stack->getRawBody());
		Assert::same('en', $stack->detectLanguage(['en']));
		Assert::equal(new Url('https://www.example.com'), $stack->getReferer());
	}

}

(new RequestStackTest())->run();
