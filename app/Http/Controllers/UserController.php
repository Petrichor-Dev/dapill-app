<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $componentPath = "user";

    public function rules()
    {
        return [
            'namaKecamatan' => 'required|string',
            'namaJendral' => 'required|string',
            'jumlahDesa' => 'required|integer',
        ];
    }
    public function index()
    {
        return view("$this->componentPath/index", [
            'Users' =>[]
           ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("$this->componentPath/create", [
            'permissions' => Permission::get()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->module);
        foreach($request->permissions as $item) {
            $permission = Permission::where('name',$item)->first();
            if(!$permission){
                $permission = Permission::create(['name' => $item]);
            }
            $role->givePermissionTo($permission);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
