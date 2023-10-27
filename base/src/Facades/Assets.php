<?php

namespace Grilar\Base\Facades;

use Grilar\Base\Supports\Assets as BaseAssets;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setConfig(array $config)
 * @method static array getThemes()
 * @method static string renderHeader($lastStyles = [])
 * @method static string renderFooter()
 * @method static \Grilar\Base\Supports\Assets usingVueJS()
 * @method static \Grilar\Base\Supports\Assets disableVueJS()
 * @method static \Grilar\Assets\Assets addScripts(string|array $assets)
 * @method static \Grilar\Assets\Assets addStyles(string|array $assets)
 * @method static \Grilar\Assets\Assets addStylesDirectly(array|string $assets)
 * @method static \Grilar\Assets\Assets addScriptsDirectly(string|array $assets, string $location = 'footer')
 * @method static \Grilar\Assets\Assets removeStyles(string|array $assets)
 * @method static \Grilar\Assets\Assets removeScripts(string|array $assets)
 * @method static \Grilar\Assets\Assets removeItemDirectly(string|array $assets, string|null $location = null)
 * @method static array getScripts(string|null $location = null)
 * @method static array getStyles(array $lastStyles = [])
 * @method static string|null scriptToHtml(string $name)
 * @method static string|null styleToHtml(string $name)
 * @method static string getBuildVersion()
 * @method static \Grilar\Assets\HtmlBuilder getHtmlBuilder()
 *
 * @see \Grilar\Base\Supports\Assets
 */
class Assets extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseAssets::class;
    }
}
