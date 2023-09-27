<?php

/**
 * Validator class @author Roberts Ivanovs
 * Used for validating user input
 */
class Validator 
{
    public function __construct(
        private mixed $field = null,
        private mixed $value = null,
        private array $isValid = [] // Array containing validation error messages
    ) {}

    // Set the field name for validation and return the instance for method chaining.
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    // Set the value to be validated and return the instance for method chaining.
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    // Check if the value is empty and add an error message if it is.
    public function checkEmpty()
    {
        if (empty($this->value)) {
            $this->isValid[] = "$this->field cannot be empty!";
        }
        return $this;    
    }

    // Sanitize the username by allowing only specific characters and add an error message if invalid characters are found.
    public function sanitizeUsername()
    {
        if (preg_match("/[^A-Za-z ā-ŽĀ-Ž]/u", $this->value)) {
            $this->isValid[] = "$this->field contains restricted symbols!";
        }
        return $this;
    }

    // Check if the value is an integer and add an error message if it is not.
    public function isInteger()
    {
        if (!is_numeric($this->value)) {
            $this->isValid[] = "$this->field is not a valid integer!";
        }
        return $this;
    }

    // Check if the validation is successful (no errors).
    public function valid()
    {
        return empty($this->isValid);
    }

    // Get a string containing all error messages separated by spaces.
    public function getErrors()
    {
        return implode("  ", $this->isValid);
    }
}
