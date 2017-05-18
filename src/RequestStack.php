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
	 * @var array|Nette\Http\IRequest
	 */
	private $requests = [];

	/**
	 * @var Nette\Http\IRequest
	 */
	private $current;



	public function pushRequest(Nette\Http\IRequest $request)
	{
		$this->requests[] = $request;
		$this->current = $request;
	}



	/**
	 * @return Nette\Http\IRequest
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
		return $this->current->getUrl();
	}



	/**
	 * @inheritdoc
	 */
	public function getQuery($key = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->current->getQuery();
		}

		return $this->current->getQuery($key, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getPost($key = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->current->getPost();
		}

		return $this->current->getPost($key, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getFile($key)
	{
		return $this->current->getFile($key);
	}



	/**
	 * @inheritdoc
	 */
	public function getFiles()
	{
		return $this->current->getFiles();
	}



	/**
	 * @inheritdoc
	 */
	public function getCookie($key, $default = NULL)
	{
		return $this->current->getCookie($key, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getCookies()
	{
		return $this->current->getCookies();
	}



	/**
	 * @inheritdoc
	 */
	public function getMethod()
	{
		return $this->current->getMethod();
	}



	/**
	 * @inheritdoc
	 */
	public function isMethod($method)
	{
		return $this->current->isMethod($method);
	}



	/**
	 * @inheritdoc
	 */
	public function getHeader($header, $default = NULL)
	{
		return $this->current->getHeader($header, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getHeaders()
	{
		return $this->current->getHeaders();
	}



	/**
	 * @inheritdoc
	 */
	public function isSecured()
	{
		return $this->current->isSecured();
	}



	/**
	 * @inheritdoc
	 */
	public function isAjax()
	{
		return $this->current->isAjax();
	}



	/**
	 * @inheritdoc
	 */
	public function getRemoteAddress()
	{
		return $this->current->getRemoteAddress();
	}



	/**
	 * @inheritdoc
	 */
	public function getRemoteHost()
	{
		return $this->current->getRemoteHost();
	}



	/**
	 * @inheritdoc
	 */
	public function getRawBody()
	{
		return $this->current->getRawBody();
	}



	/**
	 * Parse Accept-Language header and returns preferred language.
	 *
	 * @param  string[] supported languages
	 * @return string|NULL
	 */
	public function detectLanguage(array $langs)
	{
		if ($this->current instanceof Nette\Http\Request) {
			return $this->current->detectLanguage($langs);
		}
	}



	/**
	 * @return Url|null
	 */
	public function getReferer()
	{
		return ($url = $this->getHeader('referer')) ? new Url($url) : NULL;
	}

}
