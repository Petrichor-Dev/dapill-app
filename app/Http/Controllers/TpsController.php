<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TpsController extends Controller
{
    public $componentPath = "tps";

    public function rules()
    {
        return [
            'namaTps' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'jumlahPemilih' => 'required|integer',
        ];
    }

    public function index()
    {
        $tpss = Tps::get()->toArray();
        return view("$this->componentPath/index", [
         'tpss' =>$tpss
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatans = Kecamatan::get()->toArray();
        $desas = Desa::get()->toArray();
        return view("$this->componentPath/create", [
            'kecamatans' => $kecamatans,
            'desas' => $desas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
       $kecamatan = Kecamatan::where('id', $request->kecamatan)->pluck('nama')->get(0);
       $desa = Desa::where('id', $request->desa)->pluck('nama')->get(0);
       DB::beginTransaction();
       try {
           $category = Tps::create([
               'kecamatan_id' => $request->kecamatan,
               'user_id' => Auth::user()->id,
               'desa_id' => $request->desa,
               'namaDesa' => $desa,
               'namaKecamatan' => $kecamatan,
               'nama' => $request->namaTps,
               'ketua' => Auth::user()->name,
               'jumlah_pemilih' => $request->jumlahPemilih,
           ]);

           DB::commit();
           $request->session()->flash('success', 'Data Tps Berhasil di Tambahkan');
           return redirect('/tps');
       } catch (Exception $e) {
           return back()->withErrors($e->getMessage());
       }
    }

    public function edit(Tps $tps)
    {
        $kecamatans = Kecamatan::get()->toArray();
        $desas = Desa::get()->toArray();
        return view("$this->componentPath/edit", [
            'tps' => $tps->toArray(),
            'desas' => $desas,
            'kecamatans' => $kecamatans
        ]);
    }

    public function update(Request $request, Tps $tps)
    {
        // dd($request->all());
        $request->validate($this->rules());
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->pluck('nama')->get(0);
        $desa = Desa::where('id', $request->desa)->pluck('nama')->get(0);
        DB::beginTransaction();
        try {
            $tps->update([
                'kecamatan_id' => $request->kecamatan,
               'user_id' => Auth::user()->id,
               'desa_id' => $request->desa,
               'namaDesa' => $desa,
               'namaKecamatan' => $kecamatan,
               'nama' => $request->namaTps,
               'ketua' => Auth::user()->name,
               'jumlah_pemilih' => $request->jumlahPemilih,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data Desa Berhasil di Edit');
            return redirect('/tps');    
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    public function destroy(Tps $tps)
    {
        DB::beginTransaction();
        try {
            $tps->delete();
            DB::commit();
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
