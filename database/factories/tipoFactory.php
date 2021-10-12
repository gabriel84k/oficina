<?php

namespace Database\Factories;

use App\Models\tipo;
use Illuminate\Database\Eloquent\Factories\Factory;

class tipoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = tipo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            [   'id' => 1,
                'nombre' => 'Root',
                'estado' => 1,
            ],
            [   'id' => 2,
                'nombre' => 'Administrador',
                'estado' => 1,
            ],
            [   'id' => 3,
                'nombre' => 'Cliente',
                'estado' => 1,
            ],
            
            [   'id' => 4,
                'nombre' => 'Técnico',
                'estado' => 1,
            ],


        ];
    }
}
