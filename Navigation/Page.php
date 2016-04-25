<?php

namespace Fewlines\Component\Navigation;

use Fewlines\Core\Dom\Element as DomElement;
use Fewlines\Core\Dom\Dom as DomHelper;
use Fewlines\Core\Http\Router;

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

    /**
     * @var DomElement
     */
    private $parent;

    /**
     * @var boolean
     */
    private $active = false;

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
        if ($this->url && $this->url->hasAttribute('href')) {
            $this->active = Router::getInstance()->getRequest()->getUrl() == $this->url->getAttribute('href');
        }

        return $this->url;
    }

    /**
     * Sets the parent page
     *
     * @param DomElement $parent
     */
    public function setParent($parent) {
        $this->parent = $parent;

        if ($this->isActive()) {
            $parent->setActive(true);
        }
    }

    /**
     * Gets the parent page
     *
     * @return DomElement
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Determines if this page is currently active.
     * This checks the url
     *
     * @return boolean
     */
    public function isActive() {
        return $this->active;
    }

    /**
     * @param booelan $active
     */
    public function setActive($active) {
        $this->active = $active;
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