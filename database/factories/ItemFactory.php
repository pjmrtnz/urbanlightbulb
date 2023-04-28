<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->text(128),
            'department_id' => Department::factory(),
            'user_id' => User::factory()
        ];
    }
}
