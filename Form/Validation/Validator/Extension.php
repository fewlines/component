<?php
namespace Fewlines\Component\Form\Validation\Validator;

class Extension extends \Fewlines\Component\Form\Validation\Validator
{
    /**
     * @param  array $value
     * @return boolean
     */
    public function validate($value) {
        if (is_array($value) && array_key_exists('name', $value)) {
            $extensions = explode(",", $this->content);

            for ($i = 0, $len = count($extensions); $i < $len; $i++) {
                $ext = trim($extensions[$i]);

                if (strtolower(substr($value['name'], -strlen($ext))) == strtolower($ext)) {
                    return true;
                }
            }
        }

        return false;
    }
}