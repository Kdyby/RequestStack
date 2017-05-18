<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\RequestStack;

use Kdyby;
use Nette;
use Nette\Http\Url;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class RequestStack extends Nette\Object implements Nette\Http\IRequest
{

	/**
	 * @var array|Nette\Http\IRequest[]
	 */
	private $requests = [];

	/**
	 * @var Nette\Http\IRequest|NULL
	 */
	private $current;



	public function pushRequest(Nette\Http\IRequest $request)
	{
		$this->requests[] = $request;
		$this->current = $request;
	}



	/**
	 * @return Nette\Http\IRequest|null
	 */
	public function popRequest()
	{
		if (count($this->requests) === 0) {
			return NULL;
		}

		$head = array_pop($this->requests);
		$current = end($this->requests);
		$this->current = ($current !== FALSE) ? $current : NULL;
		return $head;
	}



	/**
	 * @return Nette\Http\IRequest|NULL
	 */
	public function getCurrentRequest()
	{
		return $this->current;
	}



	/**
	 * @inheritdoc
	 */
	public function getUrl()
	{
		return $this->current !== NULL ? $this->current->getUrl() : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getQuery($key = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->current !== NULL ? $this->current->getQuery() : [];
		}

		return $this->current !== NULL ? $this->current->getQuery($key, $default) : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getPost($key = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->current !== NULL ? $this->current->getPost() : [];
		}

		return $this->current !== NULL ? $this->current->getPost($key, $default) : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getFile($key)
	{
		return $this->current !== NULL ? $this->current->getFile($key) : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getFiles()
	{
		return $this->current !== NULL ? $this->current->getFiles() : [];
	}



	/**
	 * @inheritdoc
	 */
	public function getCookie($key, $default = NULL)
	{
		return $this->current !== NULL ? $this->current->getCookie($key, $default) : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getCookies()
	{
		return $this->current !== NULL ? $this->current->getCookies() : [];
	}



	/**
	 * @inheritdoc
	 */
	public function getMethod()
	{
		return $this->current !== NULL ? $this->current->getMethod() : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function isMethod($method)
	{
		return $this->current !== NULL ? $this->current->isMethod($method) : FALSE;
	}



	/**
	 * @inheritdoc
	 */
	public function getHeader($header, $default = NULL)
	{
		return $this->current !== NULL ? $this->current->getHeader($header, $default) : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getHeaders()
	{
		return $this->current !== NULL ? $this->current->getHeaders() : [];
	}



	/**
	 * @inheritdoc
	 */
	public function isSecured()
	{
		return $this->current !== NULL ? $this->current->isSecured() : FALSE;
	}



	/**
	 * @inheritdoc
	 */
	public function isAjax()
	{
		return $this->current !== NULL ? $this->current->isAjax() : FALSE;
	}



	/**
	 * @inheritdoc
	 */
	public function getRemoteAddress()
	{
		return $this->current !== NULL ? $this->current->getRemoteAddress() : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getRemoteHost()
	{
		return $this->current !== NULL ? $this->current->getRemoteHost() : NULL;
	}



	/**
	 * @inheritdoc
	 */
	public function getRawBody()
	{
		return $this->current !== NULL ? $this->current->getRawBody() : NULL;
	}



	/**
	 * Parse Accept-Language header and returns preferred language.
	 *
	 * @param  string[] supported languages
	 * @return string|NULL
	 */
	public function detectLanguage(array $langs)
	{
		return $this->current instanceof Nette\Http\Request
			? $this->current->detectLanguage($langs)
			: NULL;
	}



	/**
	 * @return Url|NULL
	 */
	public function getReferer()
	{
		$url = $this->getHeader('referer');
		return $url !== NULL ? new Url($url) : NULL;
	}

}
