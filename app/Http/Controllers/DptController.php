<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use App\Models\Desa;
use App\Models\Tps;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Leader;
use App\Models\User;

class DptController extends Controller
{
    public $componentPath = "dpt";

    public function rules()
    {
        return [
            'nama' => 'required|string',
            'nik' => 'required|integer',
            'kecamatan' => 'required',
            'desa' => 'required',
            'tps' => 'required',
        ];
    }

    public function index()
    {
        $pemilihs = Pemilih::with(['userAdmin', 'leader', 'kapten', 'mayor'])->get()->toArray();
        return view("$this->componentPath/index", [
            'pemilihs' => $pemilihs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("$this->componentPath/create", [
            'kecamatans' => Kecamatan::get()->toArray() ?? [],
            'desas' => Desa::get()->toArray() ?? [],
            'tpss' => Tps::get()->toArray() ?? [],
            'leaders' => Leader::get()->toArray() ?? [],
            'mayors' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'kaptens' => User::where('jabatan_id', 6)->get()->toArray() ?? []
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
        $tps = Tps::where('id', $request->tps)->pluck('nama')->get(0);
        DB::beginTransaction();
        try {
            $category = Pemilih::create([
                'kecamatan_id' => $request->kecamatan,
                'user_id' => Auth::user()->id,
                'leader_id' => $request->leader,
                'mayor_id' => $request->mayor,
                'kapten_id' => $request->kapten,
                'tps_id' => $request->tps,
                'desa_id' => $request->desa,
                'namaDesa' => $desa,
                'namaTps' => $tps,
                'namaKecamatan' => $kecamatan,
                'nama' => $request->nama,
                'nik' => $request->nik,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data DPT Berhasil di Tambahkan');
            return redirect('/dpt');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Pemilih $pemilih)
    {
        return view("$this->componentPath/edit", [
            'pemilih' => $pemilih->toArray() ?? [],
            'kecamatans' => Kecamatan::get()->toArray() ?? [],
            'desas' => Desa::get()->toArray() ?? [],
            'tpss' => Tps::get()->toArray(),
            'leaders' => Leader::get()->toArray() ?? [],
            'mayors' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'kaptens' => User::where('jabatan_id', 6)->get()->toArray() ?? []
        ]);
    }

    public function update(Request $request, Pemilih $pemilih)
    {
        $request->validate($this->rules());
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->pluck('nama')->get(0);
        $desa = Desa::where('id', $request->desa)->pluck('nama')->get(0);
        $tps = Tps::where('id', $request->tps)->pluck('nama')->get(0);
        DB::beginTransaction();
        try {
            $pemilih->update([
                'kecamatan_id' => $request->kecamatan,
                'user_id' => Auth::user()->id,
                'tps_id' => $request->tps,
                'desa_id' => $request->desa,
                'leader_id' => $request->leader,
                'mayor_id' => $request->mayor,
                'kapten_id' => $request->kapten,
                'namaDesa' => $desa,
                'namaTps' => $tps,
                'namaKecamatan' => $kecamatan,
                'nama' => $request->nama,
                'nik' => $request->nik,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data DPT Berhasil di Edit');
            return redirect('/dpt');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Pemilih $pemilih)
    {
        DB::beginTransaction();
        try {
            $pemilih->delete();
            DB::commit();
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
