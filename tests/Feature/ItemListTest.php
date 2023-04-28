<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Department;
use App\Models\Item;
use App\Models\ItemList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ItemListControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_inertia_page()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $item1 = Item::factory()->create(['user_id' => $user->id]);
        $item2 = Item::factory()->create(['user_id' => $user->id]);

        $department1 = Department::factory()->create(['name' => 'Department 1']);
        $department2 = Department::factory()->create(['name' => 'Department 2']);

        $itemList1 = ItemList::factory()->create(['user_id' => $user->id, 'item_id' => $item1->id, 'department_id' => $department1->id]);
        $itemList2 = ItemList::factory()->create(['user_id' => $user->id, 'item_id' => $item2->id, 'department_id' => $department2->id]);

        $response = $this->actingAs($user)->get(route('lists.index'));

        $response->assertInertiaViewIs('ItemList/Index');
    }

    public function test_can_update_item_list()
    {
        $itemList = ItemList::factory()->create();

        $purchased = $this->faker->boolean;
        $quantity = $this->faker->numberBetween(1, 10);

        $response = $this->put(route('item-lists.update', $itemList->id), [
            'purchased' => $purchased,
            'quantity' => $quantity,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('item_lists', [
            'id' => $itemList->id,
            'purchased' => $purchased,
            'quantity' => $quantity,
        ]);
    }
}
