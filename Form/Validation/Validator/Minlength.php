<?php

namespace Fewlines\Component\Form\Validation\Validator;

class Minlength extends \Fewlines\Component\Form\Validation\Validator
{
    /**
     * @param  string $value
     * @return boolean
     */
    public function validate($value) {
        if (true == is_string($value) && true == is_numeric($this->content)) {
            if (strlen($value) < intval($this->content) && strlen($value) != 0) {
                return false;
            }
            else {
                return true;
            }
        }

        return true;
    }
}
