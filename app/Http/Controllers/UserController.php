<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public $componentPath = "user";

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => 'required|integer',
        ];
    }
    public function getRole(){
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        
        return $roleName;
    }
    public function index()
    {
        return view("$this->componentPath/index", [
            'users' => User::with('jabatan')->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
           ]);
    }

    public function create()
    {   
        return view("$this->componentPath/create", [
            'roles' => Role::get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jabatan_id' => (int)$request->role
            ]);
            // dd((int)$request->role);
            $user->assignRole($request->role);
            DB::commit();
            $request->session()->flash('success', 'Data User Berhasil di Tambahkan');
            return redirect('/user');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {

        $userData = new UserResource($user->load(['roles'])->toArray());
        return view(
            "$this->componentPath/edit",
            [
                'user' => $userData->resource ?? [],
                'userRoleName' => $user->getRoleNames()->toArray(),
                'roles' => Role::get()->toArray() ?? [],
                'roleName' => $this->getRole() ?? []
            ]
        );
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255',  Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'jabatan_id' => (int)$request->role
            ]);
            $user->syncRoles($request->role);
            DB::commit();
            $request->session()->flash('success', 'Data User Berhasil di Update');
            return redirect('/user');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->syncRoles([]);
            $user->delete();
            DB::commit();
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
