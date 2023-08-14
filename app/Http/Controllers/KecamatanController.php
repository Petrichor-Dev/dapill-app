<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KecamatanController extends Controller
{
    public $componentPath = "kecamatan";

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
       $kecamatans = Kecamatan::get()->toArray();
       return view("$this->componentPath/index", [
        'kecamatans' =>$kecamatans
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
            $category = Kecamatan::create([
                'nama' => $request->namaKecamatan,
                'ketua' => $request->namaJendral,
                'jumlah_desa' => $request->jumlahDesa,
                'user_id' => 1,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data Kecamatan Berhasil di Tambahkan');
            return redirect('/kecamatan');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view("$this->componentPath/edit", [
            'kecamatan' => $kecamatan->toArray()
        ]);
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $kecamatan->update([
                'nama' => $request->namaKecamatan,
                'ketua' => $request->namaJendral,
                'jumlah_desa' => $request->jumlahDesa,
                'user_id' => 1,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data Kecamatan Berhasil di Edit');
            return redirect('/kecamatan');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Kecamatan $kecamatan)
    {
        DB::beginTransaction();
        try {
            $kecamatan->delete();
            DB::commit();
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
