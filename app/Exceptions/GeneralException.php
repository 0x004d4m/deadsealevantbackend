<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GeneralException extends Exception
{
    public function __construct(public array $errors, public string $text = 'Validation errors')
    {
        parent::__construct('Validation errors');
    }

    public function render()
    {
        Log::debug($this->errors);
        return response()->json([
            'message' => $this->text,
            'errors' => $this->errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
