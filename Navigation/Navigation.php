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
	 * @var string
	 */
	const CLASS_CTAG =  'class';

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
		$class = $config->getChildByName(self::CLASS_CTAG, false, false);
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

		if ($class) {
			$target = $class->getAttribute('target');
			$element = $page;

			if ($target) {
				$target = strtolower($target);

				switch ($target) {
					case self::A_TAG:
						if ($page->getUrl()) {
							$element = $page->getUrl();
						}
						break;

					case self::SPAN_TAG:
						if ($page->getLabel()) {
							$element = $page->getLabel();
						}
						break;
				}
			}

			$element->addAttribute(self::CLASS_CTAG, (string)$class);
		}

		if ($pages) {
			foreach ($pages->getChildren() as $subpage) {
				$wrapper = new Page;
				$subPage = $this->getPageByConfig($subpage);
				$wrapper->setDomTag(self::UL_TAG);
				$wrapper->setDomStr(self::UL_STR);
				$wrapper->addChild($subPage);
				$subPage->setParent($page);

				$page->addChild($wrapper);
			}
		}

		if ($page->isActive()) {
			$page->addAttribute('class', 'active ' . $page->getAttribute('class'));
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