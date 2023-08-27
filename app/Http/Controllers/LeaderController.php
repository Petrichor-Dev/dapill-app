<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public $componentPath = "leader";

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:leaders,name'],
        ];
    }

    public function index()
    {
        return view("$this->componentPath/index", [
            'leaders' => Leader::get()->toArray() ?? []
           ]);
    }

    public function create()
    {
        return view("$this->componentPath/create");
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
            'leader' => $leader->toArray()
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
