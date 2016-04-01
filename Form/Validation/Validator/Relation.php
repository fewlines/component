<?php

namespace Fewlines\Component\Form\Validation\Validator;

abstract class Relation extends \Fewlines\Component\Form\Validation\Validator
{
	/**
	 * @var string
	 */
	protected $related = "";

    /**
     * @return string
     */
    public function getContent() {
    	return $this->content;
    }

    /**
     * @param string $element
     */
    public function setRelated($value) {
    	$this->related = $value;
    }

    /**
     * @param  string $value
     * @return boolean
     */
    public function validate($value) {
    	return false;
    }
}
