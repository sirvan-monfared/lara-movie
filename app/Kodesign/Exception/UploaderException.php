<?php
namespace App\Kodesign\Exception;

use Exception;

class UploaderException extends Exception {

    protected $exception_errors;

    public function __construct($errors){
        parent::__construct();

        $this->exception_errors = $errors;
    }

    public function errors()
    {
        return $this->exception_errors;
    }
}
