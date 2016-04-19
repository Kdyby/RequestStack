<?php

/**
 * @testCase
 */

namespace KdybyTests\RequestStack;

use Kdyby;
use KdybyTests;
use Nette;
use Tester;
use Tester\Assert;



require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ExtensionTest extends Tester\TestCase
{

	/**
	 * @return \SystemContainer|\Nette\DI\Container
	 */
	protected function createContainer($configName = NULL)
	{
		$config = new Nette\Configurator();
		$config->setTempDirectory(TEMP_DIR);
		Kdyby\RequestStack\DI\RequestStackExtension::register($config);
		$config->addConfig(__DIR__ . '/../nette-reset.neon', !isset($config->defaultExtensions['nette']) ? 'v23' : 'v22');

		if ($configName !== NULL) {
			$config->addConfig(__DIR__ . '/config/' . $configName . '.neon');
		}

		return $config->createContainer();
	}



	public function testFunctional()
	{
		$dic = $this->createContainer();
		Assert::true($dic->getByType('Nette\Http\IRequest') instanceof Kdyby\RequestStack\RequestStack);
	}


}

(new ExtensionTest())->run();