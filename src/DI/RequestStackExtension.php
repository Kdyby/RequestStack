<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\RequestStack\DI;

use Kdyby\RequestStack\RequestStack;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\Http\IRequest;

class RequestStackExtension extends \Nette\DI\CompilerExtension
{

	use \Kdyby\StrictObjects\Scream;

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		$originalRequest = $builder->getDefinition($builder->getByType(IRequest::class));

		$builder->addDefinition($this->prefix('firstRequest'))
			->setClass(IRequest::class)
			->setFactory($originalRequest->getFactory())
			->setAutowired(FALSE);

		$originalRequest
			->setClass(RequestStack::class)
			->setFactory(RequestStack::class)
			->addSetup('pushRequest', [$this->prefix('@firstRequest')]);
	}

	public static function register(Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Compiler $compiler) {
			$compiler->addExtension('requestStack', new RequestStackExtension());
		};
	}

}
