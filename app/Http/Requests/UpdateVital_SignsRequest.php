<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVital_SignsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // allow updating
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'body_temperature'        => 'nullable|numeric|min:30|max:45',
            'heart_rate'              => 'required|numeric|min:30|max:200',
            'pulse_rate'              => 'nullable|numeric|min:30|max:200',
            'blood_pressure_systolic' => 'required|numeric|min:70|max:250',
            'blood_pressure_diastolic'=> 'required|numeric|min:40|max:150',
            'respiratory_rate'        => 'nullable|numeric|min:5|max:60',
            'bp_measurement_assessment' => 'required|string|max:255',
            'administered_by'         => 'required|string|max:255',
            'remarks'                 => 'nullable|string',
        ];
    }
}
