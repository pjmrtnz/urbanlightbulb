<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_items_and_departments()
    {
        $item = Item::factory()->create();
        $department = Department::factory()->create();

        $response = $this->get(route('items.index'));

        $response
        ->assertOk()
        ->assertViewIs('Item/Index')
        ->assertViewHas('items', function ($items) use ($item) {
            return $items->contains($item);
        })
        ->assertViewHas('departments', function ($departments) use ($department) {
            return $departments->contains($department);
        })
        ->assertJson([
            'items' => true,
            'departments' => true,
        ]);
    }
}
