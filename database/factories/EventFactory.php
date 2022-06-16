<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeThisYear("-30 days");
        $endDate = (clone $startDate)->modify("+1 day");
        $is_completed = false;

        $today = Carbon::now();
        if ($today > $endDate) {
            $is_completed = true;
        }

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_completed' => $is_completed
        ];
    }
}
