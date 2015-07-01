<?php

namespace Fewlines\Component\Navigation;

use Fewlines\Core\Dom\Element as DomElement;
use Fewlines\Core\Dom\Dom as DomHelper;

class Page extends DomElement
{
	/**
	 * @var DomElement
	 */
	private $label;

	/**
	 * @var DomElement
	 */
	private $url;

	public function __construct() {
		self::setDomTag(self::LI_TAG);
		self::setDomStr(self::LI_STR);
	}

    /**
     * Gets the value of label.
     *
     * @return DomElement
     */
  	public function getLabel() {
        return $this->label;
    }

    /**
     * Sets the value of label.
     *
     * @param string $label the label
     * @return self
     */
    public function setLabel($label) {
        $this->label = DomHelper::createElement(self::SPAN_TAG, array(), $label);
        return $this;
    }

    /**
     * Gets the value of url.
     *
     * @return DomElement
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Sets the value of url.
     *
     * @param string $url the url
     * @return self
     */
    public function setUrl($url, $target = '') {
        $this->url = DomHelper::createElement(self::A_TAG, array(), '',  $this->label ? array($this->label) : array());
        $this->url->addAttribute('href', $url);

        if ( ! empty($target)) {
        	$this->url->addAttribute('target', $target);
        }

        return $this;
    }
}