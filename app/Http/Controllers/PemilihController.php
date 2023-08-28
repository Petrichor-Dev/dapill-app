<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use App\Models\Desa;
use App\Models\Tps;
use App\Models\Leader;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\PemilihExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class PemilihController extends Controller
{
    public $componentPath = "pemilih";
    
    public function rules()
    { 
        return [
            'nama' => 'required|string',
            'nik' => 'required|digits:16|integer|unique:pemilih,nik',
            'kecamatan' => 'required',
            'desa' => 'required',
            'tps' => 'required',
            'mayor' => 'required',
            'leader' => 'required',
            'kapten' => 'required',
            'statusMemilih' => 'required'
        ];
    }
    
    public function index()
    {
        $pemilihs = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])->get()->toArray() ?? [];
        // dd($pemilihs);
        return view("$this->componentPath/index",[
            'pemilihs' => $pemilihs
        ]);
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'kecamatans' => Kecamatan::get()->toArray() ?? [],
            'desas' => Desa::get()->toArray() ?? [],
            'tpss' => Tps::get()->toArray() ?? [],
            'leaders' => Leader::get()->toArray() ?? [],
            'mayors' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'kaptens' => User::where('jabatan_id', 6)->get()->toArray() ?? [],
            'statusMemilih' => ['Memilih', 'Ragu-Ragu', 'Tidak-Memilih']
        ]);
    }

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
               'status_memilih' => $request->statusMemilih,
           ]);

           DB::commit();
           $request->session()->flash('success', 'Data Pemilih Berhasil di Tambahkan');
           return redirect('/pemilih');
       } catch (Exception $e) {
           return back()->withErrors($e->getMessage());
       }
    }

    public function edit(Pemilih $pemilih)
    {        return view("$this->componentPath/edit", [
            'pemilih' => $pemilih->toArray() ?? [],
            'kecamatans' => Kecamatan::get()->toArray() ?? [],
            'desas' => Desa::get()->toArray() ?? [],
            'tpss' => Tps::get()->toArray() ?? [],
            'leaders' => Leader::get()->toArray() ?? [],
            'mayors' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'kaptens' => User::where('jabatan_id', 6)->get()->toArray() ?? []
        ]);
    }

    public function update(Request $request, Pemilih $pemilih)
    {

        $request->validate([
                'nama' => ['required','string'],
                'nik' => ['required','digits:16','integer', Rule::unique('pemilih')->ignore($pemilih->id)]
            ]);

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
                        'status_memilih' => $request->statusMemilih,
                    ]);
    
                    DB::commit();
                    $request->session()->flash('success', 'Data Pemilih Berhasil di Edit');
                    return redirect('/pemilih');    
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

    public function export()
	{   
		return Excel::download(new PemilihExport, 'dataPemilih.xlsx');
	}
}
