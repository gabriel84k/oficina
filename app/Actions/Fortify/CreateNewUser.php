<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Permiso;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            'nombreEmpresa' => 'required'
            ],
            'password' => $this->passwordRules(),
        ])->validate();
        //try {
            
            \DB::beginTransaction();
                $empresa = Empresa::create([
                    'nombre' => $input['nombreempresa'],
                    'direccion' => $input['direccion'],
                    'telefono' => $input['telefono'],
                    'email' => $input['email']
                ]);
                $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                    'tipo_id' => 1,
                    'empresa_id' => $empresa->id,
                ]);
                $permiso = Permiso::create([
                    'menu' => '{"usuario":true,"cliente":true,"ticket":true,"reporte":true,"config":true}', 
                    'ticket' => '{"nuevo":false,"modificar":false,"eliminar":false,"asociar":false,"modificarasociado":false,"pago":false}', 
                    'usuario' => '{"nuevo":false,"modificar":false,"eliminar":false}', 
                    'config' => '{"sistema":false}', 
                    'sistema' => '{"nuevo":false,"modificar":false,"eliminar":false}', 
                    'user_id' => $user->id
                ]);
            \DB::commit();
          
            
            return $user;
        //} catch (\Throwable $th) {
           // \DB::rollback();
             
        //}
    }
}
