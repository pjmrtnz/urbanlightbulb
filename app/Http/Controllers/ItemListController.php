<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ItemList;
use App\Models\Department;
use App\Models\Item;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ItemListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $item_data = Item::where('user_id', $user->id)->with('department:id,name')->get()->groupBy('department.name');
        $itemList = ItemList::where('user_id', $user->id)->with('department:id,name', 'item:id,name')->get()->groupBy('department.name');
    
        return Inertia::render('ItemList/Index', ['itemList' => $itemList, 'item_data' => $item_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input['user_id'] = Auth::id();
        $input['item_id'] = $request->input('item_id');
        $input['item_qty'] = $request->input('item_qty');

        $item = Item::find($input['item_id']);
        $input['department_id'] = $item->department_id;

        ItemList::create( $input );
        return Redirect::route('list.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $itemList = ItemList::find($id);
        if ($request->has('purchased')) {
            $itemList->purchased = $request->purchased;
        }
        if ($request->has('quantity')) {
            $itemList->quantity = $request->quantity;
        }
        $itemList->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemList = ItemList::find($id);
        $success = $itemList->delete();

        return ['success' => $success];
    }
}
