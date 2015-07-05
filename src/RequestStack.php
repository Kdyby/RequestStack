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



	public function pushRequest(Nette\Http\IRequest $request)
	{
		$this->requests[] = $request;
	}



	/**
	 * @return Nette\Http\Request
	 */
	public function getCurrentRequest()
	{
		return end($this->requests);
	}



	/**
	 * @inheritdoc
	 */
	public function getUrl()
	{
		return $this->getCurrentRequest()->getUrl();
	}



	/**
	 * @inheritdoc
	 */
	public function getQuery($key = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->getCurrentRequest()->getQuery();
		}

		return $this->getCurrentRequest()->getQuery($key, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getPost($key = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->getCurrentRequest()->getPost();
		}

		return $this->getCurrentRequest()->getPost($key, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getFile($key)
	{
		return $this->getCurrentRequest()->getFile($key);
	}



	/**
	 * @inheritdoc
	 */
	public function getFiles()
	{
		return $this->getCurrentRequest()->getFiles();
	}



	/**
	 * @inheritdoc
	 */
	public function getCookie($key, $default = NULL)
	{
		return $this->getCurrentRequest()->getCookie($key, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getCookies()
	{
		return $this->getCurrentRequest()->getCookies();
	}



	/**
	 * @inheritdoc
	 */
	public function getMethod()
	{
		return $this->getCurrentRequest()->getMethod();
	}



	/**
	 * @inheritdoc
	 */
	public function isMethod($method)
	{
		return $this->getCurrentRequest()->isMethod($method);
	}



	/**
	 * @inheritdoc
	 */
	public function getHeader($header, $default = NULL)
	{
		return $this->getCurrentRequest()->getHeader($header, $default);
	}



	/**
	 * @inheritdoc
	 */
	public function getHeaders()
	{
		return $this->getCurrentRequest()->getHeaders();
	}



	/**
	 * @inheritdoc
	 */
	public function isSecured()
	{
		return $this->getCurrentRequest()->isSecured();
	}



	/**
	 * @inheritdoc
	 */
	public function isAjax()
	{
		return $this->getCurrentRequest()->isAjax();
	}



	/**
	 * @inheritdoc
	 */
	public function getRemoteAddress()
	{
		return $this->getCurrentRequest()->getRemoteAddress();
	}



	/**
	 * @inheritdoc
	 */
	public function getRemoteHost()
	{
		return $this->getCurrentRequest()->getRemoteHost();
	}



	/**
	 * @inheritdoc
	 */
	public function getRawBody()
	{
		return $this->getCurrentRequest()->getRawBody();
	}



	/**
	 * Parse Accept-Language header and returns preferred language.
	 *
	 * @param  string[] supported languages
	 * @return string|NULL
	 */
	public function detectLanguage(array $langs)
	{
		$this->getCurrentRequest()->detectLanguage($langs);
	}



	/**
	 * @return Url|null
	 */
	public function getReferer()
	{
		return ($url = $this->getHeader('referer')) ? new Url($url) : NULL;
	}

}
