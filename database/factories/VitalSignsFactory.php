<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vital_Signs>
 */
class VitalSignsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),

            'body_temperature'        => $this->faker->randomFloat(1, 35.0, 40.0),
            'heart_rate'              => $this->faker->numberBetween(60, 120),
            'pulse_rate'              => $this->faker->numberBetween(60, 120),

            'blood_pressure_systolic' => $this->faker->numberBetween(90, 140),
            'blood_pressure_diastolic'=> $this->faker->numberBetween(60, 90),

            'respiratory_rate'        => $this->faker->numberBetween(12, 25),

            'bp_measurement_assessment' => $this->faker->randomElement([
                'Normal',
                'Elevated',
                'Stage 1 Hypertension',
                'Stage 2 Hypertension',
                'Hypotension'
            ]),

            'administered_by'         => $this->faker->name(),
            'remarks'                 => $this->faker->sentence(),
        ];
    }
}
