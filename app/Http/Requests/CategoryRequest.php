<?php

namespace codeFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        $client = \Auth::guard('api')->user()->client; // cliente autenticado
        return [
            'name' => 'required|max:255',
            'parent_id' => Rule::exists('categories', 'id')  // ('tablea_a_procurar', 'campo a procurar')
                ->where(function($query) use($client){
                $query->where('client_id', $client->id);
            })  // validação, para ver se a categoria pertence a um cliente certo
        ];
    }
}
