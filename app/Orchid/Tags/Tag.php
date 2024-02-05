<?php

namespace App\Orchid\Tags;

class Tag
{
	public static function IMG(?string $src, string $style = '', string $alt = ''): string
	{
		return "<img src=\"{$src}\" style=\"{$style}\" alt=\"{$alt}\">";
	}
}
