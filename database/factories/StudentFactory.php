<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Student;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombres' => fake()->regexify('[A-Za-z0-9]{100}'),
            'correo' => fake()->regexify('[A-Za-z0-9]{100}'),
            'cedula' => fake()->regexify('[A-Za-z0-9]{20}'),
            'edad' => fake()->numberBetween(-10000, 10000),
            'telefono' => fake()->regexify('[A-Za-z0-9]{20}'),
            'direccion' => fake()->word(),
            'status' => fake()->randomElement(["activo","inactivo","graduado"]),
        ];
    }
}
