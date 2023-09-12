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
use App\Exports\TpsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Str;

class TpsController extends Controller
{
    public $componentPath = "tps";

    public function rules()
    {
        return [
            'namaTps' => 'required',
            'desa' => 'required',
        ];
    }

    public function getRole(){
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        
        return $roleName;
    }

    public function index()
    {
        //get data panglima, admin dan super admin
        $idAtasan = User::whereIn('jabatan_id', [1,2])->with(['jabatan'])->get()->pluck(['id'])->toArray();
        
        //get user lalu lihat id nya
        $uid = Auth::user()->id;
        // lalu lihat rolenya
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];
        // dd($userRoleId);
        //cek apakah idnya mayor atau bukan
        if($userRoleId === 4){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);
            // dd($atasanKecamatanId);
            $tpss = Tps::with(['pemilih'])->whereIn('desa_id', $arrayResult)->where('is_active', 1)->get()->toArray();
        } elseif($userRoleId === 3){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);
            // dd($atasanKecamatanId);
            $tpss = Tps::with(['pemilih'])->whereIn('kecamatan_id', $arrayResult)->where('is_active', 1)->get()->toArray();
        } elseif($userRoleId === 1 || $userRoleId === 2){
            $tpss = Tps::with(['pemilih'])->where('is_active', 1)->get()->toArray();
        } else{
            $tpss = [];
        }


        return view("$this->componentPath/index", [
         'tpss' =>$tpss ?? [],
         'roleName' => $this->getRole() ?? []
        ]);
    }

    public function create()
    {
        $uid = Auth::user()->id;
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];

        if($userRoleId === 4){
            $idAtasan = User::whereIn('jabatan_id', [1,2])->with(['jabatan'])->get()->pluck(['id'])->toArray();
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->where('is_active', 1)->get()->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);
            // dd($arrayResult);
            $desas = $arrayResult;
        } else {
            $desas = Desa::where('is_active', 1)->get()->toArray();
        }
        
        $kecamatans = Kecamatan::get()->toArray();
        return view("$this->componentPath/create", [
            'kecamatans' => $kecamatans ?? [],
            'desas' => $desas ?? [],
            'roleName' => $this->getRole() ?? [],
            'userRoleId' => $userRoleId ?? []

        ]);
    }

    public function store(Request $request)
    {
        //kalo yang input bukan jendral
       if($this->getRole()['jabatan_id'] !== 4){
        $request->validate($this->rules());
        $kecamatan = Kecamatan::where('id', $request->kecamatan)->where('is_active', 1)->pluck('nama')->get(0);
        $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
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
            ]);

            DB::commit();
            $request->session()->flash('success', 'Data Tps Berhasil di Tambahkan');
            return redirect('/tps');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
       } 
            $request->validate($this->rules());
            $kecamatan = Desa::with('kecamatan')->where('id', $request->desa)->where('is_active', 1)->first()->toArray();
            $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
            DB::beginTransaction();
            try {
                $category = Tps::create([
                    'kecamatan_id' => $kecamatan['kecamatan_id'],
                    'user_id' => Auth::user()->id,
                    'desa_id' => $request->desa,
                    'namaDesa' => $desa,
                    'namaKecamatan' => $kecamatan['kecamatan']['nama'],
                    'nama' => $request->namaTps,
                    'ketua' => Auth::user()->name,
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
        $uid = Auth::user()->id;
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];

        if($userRoleId === 4){
            $idAtasan = User::whereIn('jabatan_id', [1,2])->where('is_active', 1)->with(['jabatan'])->get()->pluck(['id'])->toArray();
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->where('is_active', 1)->get()->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);
            // dd($arrayResult);
            $desas = $arrayResult;
        } else {
            $desas = Desa::get()->toArray();
        }
        $kecamatans = Kecamatan::where('is_active', 1)->get()->toArray();
    
        return view("$this->componentPath/edit", [
            'tps' => $tps->toArray() ?? [],
            'desas' => $desas ?? [],
            'kecamatans' => $kecamatans ?? [],
            'roleName' => $this->getRole() ?? [],
            'userRoleId' => $userRoleId
        ]);
    }

    public function update(Request $request, Tps $tps)
    {
        if($this->getRole()['jabatan_id'] !== 4){
            $request->validate($this->rules());
            $kecamatan = Kecamatan::where('id', $request->kecamatan)->where('is_active', 1)->pluck('nama')->get(0);
            $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
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
                
                ]);

                DB::commit();
                $request->session()->flash('success', 'Data Desa Berhasil di Edit');
                return redirect('/tps');    
            } catch (Exception $e) {
                return back()->withErrors($e->getMessage());
            }
        }
        $request->validate($this->rules());
        $kecamatan = Desa::with('kecamatan')->where('id', $request->desa)->where('is_active', 1)->first()->toArray();
        $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
        DB::beginTransaction();
        try {
            $tps->update([
                'kecamatan_id' => $kecamatan['kecamatan_id'],
               'user_id' => Auth::user()->id,
               'desa_id' => $request->desa,
               'namaDesa' => $desa,
               'namaKecamatan' => $kecamatan['kecamatan']['nama'],
               'nama' => $request->namaTps,
               'ketua' => Auth::user()->name,
               
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
            $tps->update([
                'is_update' => 0
            ]);
            DB::commit();
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function export($tps)
	{   
        $tpsExport = new TpsExport($tps);
        $tpsName = Tps::where('id', $tps)->where('is_active', 1)->get()->pluck(['nama'])->first();
        $resultName = Str::slug($tpsName, '-');
		return Excel::download($tpsExport, 'data-'.$resultName.'.xlsx');
	}
}
