<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProdukRequest extends Request
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
        if ($this->method() == 'PATCH'){
        $kodeproduk_rules = 'required|string|max:50|unique:produk,kodeproduk,' . $this->get('id');
        }
        else{
        $kodeproduk_rules = 'required|string|max:50|unique:produk,kodeproduk';
        }
        return [
            'kodeproduk' => $kodeproduk_rules,
            'id_kategoriproduk' => 'required',
            'id_merk' => 'required',
            'namaproduk' => 'required|string|max:50',
            'hargajual' => 'required|numeric|max:99999999', 
            'hargagrosir' => 'required|numeric|max:99999999', 
            'hargadistributor' => 'required|numeric|max:99999999',
            'diskon' => 'required|numeric|max:99999999', 
            'stok' => 'required|numeric',   
            'foto' => 'sometimes|image|max:1024|mimes:jpeg,jpg,bmp,png',         
        ];
    }
}
