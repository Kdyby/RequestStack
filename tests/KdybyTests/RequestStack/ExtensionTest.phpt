<?php

/**
 * @testCase
 */

namespace KdybyTests\RequestStack;

use Kdyby\RequestStack\DI\RequestStackExtension;
use Kdyby\RequestStack\RequestStack;
use Nette\Application\LinkGenerator;
use Nette\Configurator;
use Nette\Http\IRequest;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class ExtensionTest extends \Tester\TestCase
{

	/**
	 * @return \SystemContainer|\Nette\DI\Container
	 */
	protected function createContainer($configName = NULL)
	{
		$config = new Configurator();
		$config->setTempDirectory(TEMP_DIR);
		RequestStackExtension::register($config);
		$config->addConfig(__DIR__ . '/../nette-reset.neon');

		if ($configName !== NULL) {
			$config->addConfig(__DIR__ . '/config/' . $configName . '.neon');
		}

		return $config->createContainer();
	}

	public function testFunctional()
	{
		$dic = $this->createContainer();
		Assert::true($dic->getByType(IRequest::class) instanceof RequestStack);
		Assert::true($dic->getByType(LinkGenerator::class) instanceof LinkGenerator);
	}

}

(new ExtensionTest())->run();
