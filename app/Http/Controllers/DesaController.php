<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    public $componentPath = "desa";

    public function rules()
    {
        return [
            'kecamatan' => 'required',
            'namaDesa' => 'required|string',
            'namaMayor' => 'required|string',
            'jumlahTps' => 'required|integer',
        ];
    }

    public function index()
    {
        $desas = Desa::get()->toArray();
        return view("$this->componentPath/index", [
         'desas' =>$desas
        ]);
    }

    public function create()
    {
        $kecamatans = Kecamatan::get()->toArray();
        return view("$this->componentPath/create", [
            'kecamatans' => $kecamatans
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $category = Desa::create([
                'nama' => $request->namaDesa,
                'ketua' => $request->namaMayor,
                'jumlah_tps' => $request->jumlahTps,
                'kecamatan_id' => $request->kecamatan,
                'user_id' => 1,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data Desa Berhasil di Tambahkan');
            return redirect('/desa');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Desa $desa)
    {
        $kecamatans = Kecamatan::get()->toArray();
        return view("$this->componentPath/edit", [
            'desa' => $desa->toArray(),
            'kecamatans' => $kecamatans
        ]);
    }

    public function update(Request $request, Desa $desa)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $desa->update([
                'nama' => $request->namaDesa,
                'ketua' => $request->namaMayor,
                'jumlah_tps' => $request->jumlahTps,
                'kecamatan_id' => $request->kecamatan,
                'user_id' => 1,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data Desa Berhasil di Edit');
            return redirect('/desa');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Desa $desa)
    {
        DB::beginTransaction();
        try {
            $desa->delete();
            DB::commit();
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
