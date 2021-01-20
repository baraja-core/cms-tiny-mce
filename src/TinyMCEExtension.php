<?php

declare(strict_types=1);

namespace Baraja\TinyMCE;


use Baraja\Cms\CmsExtension;
use Baraja\Cms\Proxy\GlobalAsset\CustomGlobalAssetManager;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class TinyMCEExtension extends CompilerExtension
{

	/**
	 * @return string[]
	 */
	public static function mustBeDefinedBefore(): array
	{
		return [CmsExtension::class];
	}


	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'apiKey' => Expect::string(),
		])->castTo('array');
	}


	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('tinyMCEAsset'))
			->setFactory(TinyMCEAsset::class)
			->setArgument('apiKey', $this->config['apiKey'] ?? null);

		/** @var ServiceDefinition $manager */
		$manager = $builder->getDefinitionByType(CustomGlobalAssetManager::class);
		$manager->addSetup('?->addAsset(?)', ['@self', '@' . TinyMCEAsset::class]);
	}
}
