<?php
namespace Fewlines\Component\Form\Validation\Validator;

class Minsize extends \Fewlines\Component\Form\Validation\Validator
{
    /**
     * @param  array $value
     * @return boolean
     */
    public function validate($value) {
        if (is_array($value)) {
            if (array_key_exists('size', $value)) {
                return (intval($value['size']) / 1000) >= intval($this->content);
            }

            return false;
        }

        return true;
    }
}