<?php

namespace Database\Factories;

use App\Models\ItemList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemListFactory extends Factory
{
    protected $model = ItemList::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'quantity' => $this->faker->numberBetween(1, 10),
            'item_id' => $this->faker->numberBetween(1, 20),
            'department_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
