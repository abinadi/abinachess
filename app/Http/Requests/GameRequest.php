<?php

namespace AbinaChess\Http\Requests;

use AbinaChess\Http\Requests\Request;

/**
 * Class GameRequest
 * @package AbinaChess\Http\Requests
 *
 * @property string $name
 * @property string $opponent
 * @property string $color
 */
class GameRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required',
            'opponent' => 'required',
            'color'    => 'required|in:white,black,random'
        ];
    }
}
