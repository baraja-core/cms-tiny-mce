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
		return 'https://cdn.tiny.cloud/1/' . $this->escape($this->apiKey ?? 'no-api-key') . '/tinymce/5/tinymce.min.js';
	}


	public function getFormat(): string
	{
		return 'js';
	}


	/**
	 * Escapes string for use inside HTML attribute value.
	 */
	private function escape(string $s, bool $double = true): string
	{
		if (str_contains($s, '`') && strpbrk($s, ' <>"\'') === false) {
			$s .= ' '; // protection against innerHTML mXSS vulnerability nette/nette#1496
		}

		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8', $double);
	}
}
