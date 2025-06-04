<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;

class BookValidator
{
    public static function validate(array $data)
    {
        return Validator::make($data, [
            'title'           => 'required|string|max:40',
            'publisher'       => 'required|string|max:40',
            'edition'         => 'required|integer|min:1',
            'published_year'  => 'required|digits:4',
        ]);
    }
}
