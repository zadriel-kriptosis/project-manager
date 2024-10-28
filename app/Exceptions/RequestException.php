<?php

namespace App\Exceptions;

use Exception;

class RequestException extends Exception
{
    public function flashError()
    {
        session()->flash('error_message', $this->getMessage());
    }
}
