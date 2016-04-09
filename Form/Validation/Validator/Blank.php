<?php
namespace Fewlines\Component\Form\Validation\Validator;

class Blank extends \Fewlines\Component\Form\Validation\Validator
{
    /**
     * @param  string $value
     * @return boolean
     */
    public function validate($value) {
        if (true == $this->content && false == is_array($value)) {
            return trim(preg_replace('/ |\t|\r|\r\n/', '', $value)) != '';
        }
        else if (is_array($value)) {
            // Check for uploaded file
            if (array_key_exists('name', $value) && array_key_exists('tmp_name', $value)) {
                return !empty($value['name']) && !empty($value['tmp_name']);
            }
            else {
                return !empty($value);
            }
        }

        return true;
    }
}
