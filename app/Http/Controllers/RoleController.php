<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RoleResource;
use Illuminate\Validation\Rule;
use App\Models\User;

class RoleController extends Controller
{
    public $componentPath = "role";

    public function rules()
    {
        return [
            'name' => ['required', 'string',  'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
        ];
    }
    public function getRole(){
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        
        return $roleName;
    }

    public function index()
    {
        $roles = Role::whereNotIn('id', [1])->get()->toArray();
        return view("$this->componentPath/index", [
            'roles' => new RoleResource($roles) ?? [],
            'roleName' => $this->getRole() ?? []
           ]);  
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'permissions' => Permission::get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
            ]);
            foreach($request->permissions as $item) {
                $permission = Permission::where('name',$item)->first();
                
                if(!$permission){
                    $permission = Permission::create(['name' => $item]);
                }
                $role->givePermissionTo($permission);
            }
            DB::commit();
            $request->session()->flash('success', 'Data Role Berhasil di Tambahkan');
           return redirect('/role');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        $dataWithPermissions = Role::with('permissions')->where('id', $role->id)->get()->first()->toArray();
        return view(
            "$this->componentPath/edit",
            [
                'permissions' => Permission::get()->toArray() ?? [],
                'dataWithPermissions' => $dataWithPermissions ?? [],
                'roleName' => $this->getRole() ?? []
            ]
        );
    }
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string',  'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['nullable', 'array'],
        ]);
        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
            ]);
            $role->permissions()->detach();
            foreach($request->permissions as $item) {
                $permission = Permission::where('name',$item)->first();
                
                if(!$permission){
                    $permission = Permission::create(['name' => $item]);
                }
                $role->givePermissionTo($permission);
            }
            DB::commit();
            $request->session()->flash('success', 'Data Role Berhasil di Edit');
           return redirect('/role');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
