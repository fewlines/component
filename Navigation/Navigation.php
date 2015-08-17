<?php
namespace Fewlines\Component\Navigation;

use Fewlines\Core\Dom\Element as DomElement;
use Fewlines\Core\Xml\Tree\Element as XmlElement;
use Fewlines\Core\Http\Router;
use Fewlines\Core\Helper\UrlHelper;

class Navigation extends DomElement
{
	/**
	 * @var string
	 */
	const SUBPAGES_CTAG = 'pages';

	/**
	 * @var string
	 */
	const URL_CTAG = 'url';

	/**
	 * @var string
	 */
	const LABEL_CTAG = 'label';

	/**
	 * Holds the pages of
	 * the navigation
	 *
	 * @var array
	 */
	private $pages = array();

	/**
	 * Holds the given config file
	 * from the xml
	 *
	 * @var XmlElement
	 */
	private $config;

	/**
	 * Creates a navigation from the given
	 * config
	 *
	 * @param XmlElement $config
	 */
	public function __construct(XmlElement $config) {
		$this->setDomTag(self::UL_TAG);
		$this->setDomStr(self::UL_STR);

		$this->config = $config;

		// Apply config data
		foreach ($this->config->getChildren() as $child) {
			$this->pages[] = $this->getPageByConfig($child);
		}

		$this->setChildren($this->pages);
	}

	/**
	 * @param  XmlElemnt $config
	 * @return Page
	 */
	public function getPageByConfig($config) {
		$pages = $config->getChildByName(self::SUBPAGES_CTAG, false, false);
		$label = $config->getChildByName(self::LABEL_CTAG, false, false);
		$url = $config->getChildByName(self::URL_CTAG, false, false);
		$page = new Page;

		if ($label) {
			$page->setLabel((string)$label);
		}

		if ($url) {
			$target = $url->getAttribute('target');

			if ($url->countChildren() > 0) {
				$url = $this->parseUrl($url->getChildren());
			}

			$page->setUrl((string)$url, $target);
			$page->addChild($page->getUrl());
		}
		else if ($label) {
			$page->addChild($page->getLabel());
		}

		if ($pages) {
			foreach ($pages->getChildren() as $subpage) {
				$wrapper = new Page;
				$wrapper->setDomTag(self::UL_TAG);
				$wrapper->setDomStr(self::UL_STR);
				$wrapper->addChild($this->getPageByConfig($subpage));

				$page->addChild($wrapper);
			}
		}

		return $page;
	}

	/**
	 * @param  array $parts
	 * @return string
	 */
	private function parseUrl($parts) {
		$urlParts = Router::getInstance()->getRouteUrlParts();

		for ($i = 0, $len = count($parts); $i < $len; $i++) {
			$parts[$parts[$i]->getName()] = (string)$parts[$i];
			unset($parts[$i]);
		}

		return UrlHelper::getBaseUrl(implode('/', array_merge($urlParts, $parts)));
	}

	/**
	 * Set the classes of the navigation element
	 * @param array $classes
	 */
	public function setClasses($classes) {
		$this->addAttribute('class', implode(' ', $classes));
	}
}