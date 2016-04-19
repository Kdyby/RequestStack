<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\RequestStack\DI;

use Kdyby;
use Nette;
use Nette\PhpGenerator as Code;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class RequestStackExtension extends Nette\DI\CompilerExtension
{

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		$originalRequest = $builder->getDefinition($requestService = ($builder->getByType('Nette\Http\IRequest') ?: 'httpRequest'));

		$builder->addDefinition($this->prefix('firstRequest'))
			->setClass('Nette\Http\IRequest')
			->setFactory($originalRequest->getFactory())
			->setAutowired(FALSE);

		$originalRequest
			->setClass('Kdyby\RequestStack\RequestStack')
			->setFactory('Kdyby\RequestStack\RequestStack')
			->addSetup('pushRequest', [$this->prefix('@firstRequest')]);
	}



	public static function register(Nette\Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Nette\DI\Compiler $compiler) {
			$compiler->addExtension('requestStack', new RequestStackExtension());
		};
	}

}
