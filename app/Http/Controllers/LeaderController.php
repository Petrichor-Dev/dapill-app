<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeaderController extends Controller
{
    public $componentPath = "leader";

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:leaders,name'],
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
            'leaders' => Leader::get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
           ]);
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
            try {
                $user = Leader::create([
                    'name' => $request->name,
                ]);
                DB::commit();
                $request->session()->flash('success', 'Data Leader Berhasil di Tambahkan');
                return redirect('/leader');
            } catch (\Exception $e) {
                return back()->withErrors(['message' => $e->getMessage()]);
            }
    }

    public function edit(leader $leader)
    {
        return view("$this->componentPath/edit", [
            'leader' => $leader->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, leader $leader)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
            try {
                $leader->update([
                    'name' => $request->name,
                ]);
                DB::commit();
                $request->session()->flash('success', 'Data Leader Berhasil di Update');
                return redirect('/leader');
            } catch (\Exception $e) {
                return back()->withErrors(['message' => $e->getMessage()]);
            }
    }

    public function destroy(leader $leader)
    {
        DB::beginTransaction();
            try {
                $leader->delete();
                DB::commit();
                return back();
            } catch (\Exception $e) {
                return back()->withErrors(['message' => $e->getMessage()]);
            }
    }
}
