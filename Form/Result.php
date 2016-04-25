<?php
namespace Fewlines\Component\Form;

class Result
{
    /**
     * Indicates if the whole
     * validation of a formular
     * is valid and without errors
     *
     * @var boolean
     */
    private $success = true;

    /**
     * Alle errors from the
     * elements validations
     *
     * @var array
     */
    private $errors = array();

    /**
     * Some data the user can
     * append to the result
     *
     * @var array
     */
    private $data = array();

    /**
     * @return boolean
     */
    public function isSuccess() {
        return $this->success;
    }

    /**
     * Adds a result to the
     * stack
     *
     * @param string $name
     * @param array  $errors
     */
    public function addError($name, $errors) {
        if (false == empty($errors)) {
            $this->errors[$name] = $errors;

            if ($this->success == true) {
                $this->success = false;
            }
        }
    }

    /**
     * Adds data to the result
     *
     * @param string $name
     * @param * $value
     */
    public function addData($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * Converts all necessary result
     * innformations to a json string
     *
     * @return string
     */
    public function toJSON() {
        return json_encode(
            array(
                'success' => $this->success,
                'errors' => $this->errors,
                'data' => $this->data
            )
        );
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
}
