<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para modificar cuentas.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Limpia y normaliza los campos enviados antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $data = [];
        if ($this->has('email')) {
            $data['email'] = strtolower(trim((string) $this->email));
        }
        if ($this->has('name')) {
            $data['name'] = trim((string) $this->name);
        }
        if ($this->has('is_active')) {
            $data['is_active'] = filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        if (!empty($data)) {
            $this->merge($data);
        }
    }

    /**
     * Reglas de validación para actualizar un usuario existente.
     */
    public function rules(): array
    {
        // Obtener el ID del usuario actual para ignorarlo en la unicidad del correo
        $userId = $this->route('user') instanceof \App\Models\User
            ? $this->route('user')->id
            : $this->route('user');

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'string',
                'email',
                'max:254',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            // Contraseña opcional al editar (solo se actualiza si se proporciona)
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'string', 'in:admin,technician'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre completo es obligatorio.',
            'name.max' => 'El nombre no debe exceder los 150 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese una dirección de correo válida.',
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
            'password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'role.required' => 'El rol del usuario es obligatorio.',
            'role.in' => 'El rol seleccionado no es válido (debe ser admin o technician).',
        ];
    }
}
