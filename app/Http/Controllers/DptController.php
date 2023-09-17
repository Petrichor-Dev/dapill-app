<?php

namespace App\Http\Controllers;

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
use Illuminate\Validation\Rule;
use App\Exports\DptExport;
use App\Models\Dpt;
use Maatwebsite\Excel\Facades\Excel;

class DptController extends Controller
{
    public $componentPath = "dpt";

    public function rules()
    {
        return [
            'nama' => 'required|string',
            // 'nik' => 'required|digits:16|integer|unique:dpt,nik',
            'kecamatan' => 'required',
            'desa' => 'required',
            'tps' => 'required',
        ];
    }

    public function getRole(){
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        
        return $roleName; 
    }

    public function index()
    {
        $dpts = Dpt::where('is_active', 1)->with(['admin'])->get()->toArray();
        return view("$this->componentPath/index", [
            'dpts' => $dpts,
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'kecamatans' => Kecamatan::where('is_active', 1)->get()->toArray() ?? [],
            'desas' => Desa::where('is_active', 1)->get()->toArray() ?? [],
            'tpss' => Tps::where('is_active', 1)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {   
        $request->validate($this->rules());
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->where('is_active', 1)->pluck('nama')->get(0);
        $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
        $tps = Tps::where('id', $request->tps)->where('is_active', 1)->pluck('nama')->get(0);
        DB::beginTransaction();
        try {
            $category = Dpt::create([
                'kecamatan_id' => $request->kecamatan,
                'user_id' => Auth::user()->id,
                'tps_id' => $request->tps,
                'desa_id' => $request->desa,
                'namaDesa' => $desa,
                'namaTps' => $tps,
                'namaKecamatan' => $kecamatan,
                'nama' => $request->nama,
                'is_active' => 1
                // 'nik' => $request->nik,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data DPT Berhasil di Tambahkan');
            return redirect('/dpt');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Dpt $dpt)
    {   
        return view("$this->componentPath/edit", [
            'dpt' => $dpt->toArray() ?? [],
            'kecamatans' => Kecamatan::where('is_active', 1)->get()->toArray() ?? [],
            'desas' => Desa::where('is_active', 1)->get()->toArray() ?? [],
            'tpss' => Tps::where('is_active', 1)->get()->toArray(),
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, Dpt $dpt)
    {
        $request->validate([
            'nama' => ['required', 'string'],
            // 'nik' => ['required', 'digits:16', 'integer', Rule::unique('dpt')->ignore($dpt->id)],
        ]);
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->where('is_active', 1)->pluck('nama')->get(0);
        $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
        $tps = Tps::where('id', $request->tps)->where('is_active', 1)->pluck('nama')->get(0);
        DB::beginTransaction();
        try {
            $dpt->update([
                'kecamatan_id' => $request->kecamatan,
                'user_id' => Auth::user()->id,
                'tps_id' => $request->tps,
                'desa_id' => $request->desa,
                'namaDesa' => $desa,
                'namaTps' => $tps,
                'namaKecamatan' => $kecamatan,
                'nama' => $request->nama,
                'is_active' => 1
                // 'nik' => $request->nik,
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data DPT Berhasil di Edit');
            return redirect('/dpt');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Dpt $dpt)
    {
        DB::beginTransaction();
        try {
            $dpt->update([
                'is_active' => 0
            ]);
            DB::commit();
            $request->session()->flash('success', 'Data DPT Berhasil di Hapus');
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function export()
	{   
		return Excel::download(new DptExport, 'data-dpt.xlsx');
	}
}