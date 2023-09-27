<?php

declare(strict_types=1);

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
    
    /**
     * setField
     * 
     * Sets the field name to be validated.
     * User has no control over this.
     *
     * @param  mixed $field
     * @return self
     */
    public function setField(string $field): self
    {
        $this->field = $field;
        return $this;
    }
        
    /**
     * setValue
     *
     * Set the field value to be validated and return the instance for method chaining.
     * 
     * @param  mixed $value
     * @return self
     */
    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }
        
    /**
     * checkEmpty
     * 
     * Check if the value is empty and add an error message if it is.
     *
     * @return self
     */
    public function checkEmpty(): self
    {
        if (empty($this->value)) {
            $this->isValid[] = "$this->field cannot be empty!";
        }
        return $this;    
    }
        
    /**
     * sanitizeUsername
     * 
     *  Sanitize the username by allowing only specific characters and add an error message 
     *  if invalid characters are found.
     *
     * @return self
     */
    public function sanitizeUsername(): self
    {
        if (preg_match("/[^A-Za-z ā-ŽĀ-Ž]/u", $this->value)) {
            $this->isValid[] = "$this->field contains restricted symbols!";
        }
        return $this;
    }
        
    /**
     * isInteger
     * 
     * Check if the value is an integer and add an error message if it is not.
     *
     * @return self
     */
    public function isInteger(): self
    {
        if (!is_numeric($this->value)) {
            $this->isValid[] = "$this->field is not a valid integer!";
        }
        return $this;
    }
        
    /**
     * valid
     * 
     * Check if the validation is successful (no errors).
     *
     * @return bool
     */
    public function valid(): bool
    {
        return empty($this->isValid);
    }
        
    /**
     * getErrors
     * 
     * Get a string containing all error messages separated by spaces.
     *
     * @return string
     */
    public function getErrors(): string
    {
        return implode("  ", $this->isValid);
    }
}
