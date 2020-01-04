<?php

namespace App\Http\Controllers;

use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'photo' => 'required',
            'title' => 'required',
            'price' => 'required',
            'condition' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required',
                    ]);
    }
    public function index()
    {
        $items = Items::all();    
        return ($items);
    }

    public function Filtered($item)
    {
        $champions = DB::table('items')->having('category', '=', $item)->get();
        return response()->json($champions);   
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create(array $data)
    {
        return items::create([
            'photo' => $data['photo'],
            'title' => $data['title'],
            'price' => $data['price'],
            'condition' => $data['condition'],
            'description' => $data['description'],
            'location' => $data['location'],
            'category' => $data['category'],
        ]);
    }

    public function PostItem(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);
        if ($validator->passes()) {
            $this->create($input)->toArray();
        }
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy(Items $items)
    {
        //
    }
}
