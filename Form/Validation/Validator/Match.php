<?php

namespace Fewlines\Component\Form\Validation\Validator;

class Match extends \Fewlines\Component\Form\Validation\Validator\Relation
{
    /**
     * @param  string $value
     * @return boolean
     */
    public function validate($value) {
        return $this->related == $value;
    }
}
