<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StudentController
 */
final class StudentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $students = Student::factory()->count(3)->create();

        $response = $this->get(route('students.index'));

        $response->assertOk();
        $response->assertViewIs('students.index');
        $response->assertViewHas('students');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('students.create'));

        $response->assertOk();
        $response->assertViewIs('students.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StudentController::class,
            'store',
            \App\Http\Requests\StudentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nombres = fake()->word();
        $correo = fake()->word();
        $cedula = fake()->word();
        $edad = fake()->numberBetween(-10000, 10000);
        $telefono = fake()->word();
        $direccion = fake()->word();
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('students.store'), [
            'nombres' => $nombres,
            'correo' => $correo,
            'cedula' => $cedula,
            'edad' => $edad,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'status' => $status,
        ]);

        $students = Student::query()
            ->where('nombres', $nombres)
            ->where('correo', $correo)
            ->where('cedula', $cedula)
            ->where('edad', $edad)
            ->where('telefono', $telefono)
            ->where('direccion', $direccion)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $students);
        $student = $students->first();

        $response->assertRedirect(route('students.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $student = Student::factory()->create();

        $response = $this->get(route('students.show', $student));

        $response->assertOk();
        $response->assertViewIs('students.show');
        $response->assertViewHas('student');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $student = Student::factory()->create();

        $response = $this->get(route('students.edit', $student));

        $response->assertOk();
        $response->assertViewIs('students.edit');
        $response->assertViewHas('student');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StudentController::class,
            'update',
            \App\Http\Requests\StudentUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $student = Student::factory()->create();
        $nombres = fake()->word();
        $correo = fake()->word();
        $cedula = fake()->word();
        $edad = fake()->numberBetween(-10000, 10000);
        $telefono = fake()->word();
        $direccion = fake()->word();
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('students.update', $student), [
            'nombres' => $nombres,
            'correo' => $correo,
            'cedula' => $cedula,
            'edad' => $edad,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'status' => $status,
        ]);

        $student->refresh();

        $response->assertRedirect(route('students.index'));

        $this->assertEquals($nombres, $student->nombres);
        $this->assertEquals($correo, $student->correo);
        $this->assertEquals($cedula, $student->cedula);
        $this->assertEquals($edad, $student->edad);
        $this->assertEquals($telefono, $student->telefono);
        $this->assertEquals($direccion, $student->direccion);
        $this->assertEquals($status, $student->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $student = Student::factory()->create();

        $response = $this->delete(route('students.destroy', $student));

        $response->assertRedirect(route('students.index'));

        $this->assertSoftDeleted($student);
    }
}
