<?php

declare(strict_types=1);

namespace Baraja\TinyMCE;


use Baraja\Cms\Proxy\GlobalAsset\CmsAsset;

final class TinyMCEAsset implements CmsAsset
{
	private ?string $apiKey;


	public function __construct(?string $apiKey = null)
	{
		$this->apiKey = $apiKey;
	}


	public function getUrl(): string
	{
		return sprintf(
			'https://cdn.tiny.cloud/1/%s/tinymce/5/tinymce.min.js',
			$this->escape($this->apiKey ?? 'no-api-key'),
		);
	}


	public function getFormat(): string
	{
		return 'js';
	}


	/**
	 * Escapes string for use inside HTML attribute value.
	 */
	private function escape(string $s): string
	{
		if (str_contains($s, '`') && strpbrk($s, ' <>"\'') === false) {
			$s .= ' '; // protection against innerHTML mXSS vulnerability nette/nette#1496
		}

		return htmlspecialchars($s, ENT_QUOTES);
	}
}
