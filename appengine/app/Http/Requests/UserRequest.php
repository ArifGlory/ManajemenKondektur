<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UserRequest extends FormRequest
{
    protected $rules = [
        'email' => 'required|email',
        'name' => 'required|string|max:50',
        'password' => 'max:50',
        'username' => 'required|max:12',
        'photo' => 'mimes:jpeg,bmp,png'
    ];

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
        'email' => 'required|email',
        'nama_lengkap' => 'required|string|max:50',
        'password' => 'max:50',
        'username' => 'required|max:12',
        'photo' => 'mimes:jpeg,bmp,png'
        ];
    }
     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email dibutuhkan!',
            'nama_lengkap.required' => 'Nama Lengkap dibutuhkan!',
            'username.required' => 'Username dibutuhkan!',
            'password.required' => 'Password dibutuhkan',
            'name.max' => 'Tidak boleh melebihi batas'
        ];
    }
}
