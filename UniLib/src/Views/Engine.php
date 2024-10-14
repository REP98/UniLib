<?php
declare(strict_types=1);

namespace UniLib\Views;

use UniLib\Traits\Singleton;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extra\CssInliner\CssInlinerExtension;
use Twig\Extra\Html\HtmlExtension;
use Twig\Extra\Intl\IntlExtension;
use Twig\Extension\StringLoaderExtension;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\TwigFunction;
/**
 * Engine
 */
class Engine
{
	use Singleton;

	public $twig;

	private function __construct()
	{
		$loader = new FilesystemLoader(config('view.path'));
		$this->twig = new Environment($loader, config('view.setting'));
		// ADD EXTENSION
		$this->twig->addExtension(new HtmlExtension());
		$this->twig->addExtension(new IntlExtension());
		$this->twig->addExtension(new StringLoaderExtension());
		$this->twig->addExtension(new CssInlinerExtension());
		$this->twig->addExtension(new MarkdownExtension());
		if (env('DEBUG_MODE', false)) {
			$this->twig->addExtension(new DebugExtension());
		}
		// ADD FUNCTION
		$funUser = get_defined_functions()['user'];
		if ($funUser) {
			foreach ($funUser as $namefn) {
				$this->twig->addFunction(
					new TwigFunction($namefn, $namefn)
				);
			}
		}
	}

	public static function render($tpl, array $data = [])
	{
		if (!self::$instance) {
			self::I();
		}
		$tpl = str_replace('.', '/', $tpl);
		$tpl .= ".". config('view.ext') ?? 'twig';
		return self::$instance->twig->render($tpl, $data);
	}

	public function __call($name, $args) 
	{
		if (method_exists($this->twig, $name)) {
			$this->twig->{$name}(...$args);
		}
	}
}