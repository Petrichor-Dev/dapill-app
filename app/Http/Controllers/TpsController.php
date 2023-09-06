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
use App\Models\User;

class TpsController extends Controller
{
    public $componentPath = "tps";

    public function rules()
    {
        return [
            'namaTps' => 'required',
            'desa' => 'required',
            'jumlahPemilih' => 'required|integer',
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
        $idAtasan = User::whereIn('jabatan_id', [1,2,3])->with(['jabatan'])->get()->pluck(['id'])->toArray();
        
        //get user lalu lihat id nya
        $uid = Auth::user()->id;
        // lalu lihat rolenya
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];
        // dd($userRoleId);
        //cek apakah idnya mayor atau bukan
        if($userRoleId === 4){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->get()->pluck(['id'])->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);
            // dd($atasanKecamatanId);
            $tpss = Tps::whereIn('desa_id', $arrayResult)->get()->toArray();
        } elseif($userRoleId === 5){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);
            // dd($atasanKecamatanId);
            $tpss = Tps::whereIn('kecamatan_id', $arrayResult)->get()->toArray();
        } elseif($userRoleId === 2 || $userRoleId === 3 || $userRoleId === 1){
            $tpss = Tps::get()->toArray();
        } else{
            $tpss = [];
        }


        return view("$this->componentPath/index", [
         'tpss' =>$tpss ?? [],
         'roleName' => $this->getRole() ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $uid = Auth::user()->id;
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];

        if($userRoleId === 4){
            $idAtasan = User::whereIn('jabatan_id', [1,2,3])->with(['jabatan'])->get()->pluck(['id'])->toArray();
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->get()->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->get()->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);
            // dd($arrayResult);
            $desas = $arrayResult;
        } else {
            $desas = [];
        }
        
        $kecamatans = Kecamatan::get()->toArray();
        return view("$this->componentPath/create", [
            'kecamatans' => $kecamatans ?? [],
            'desas' => $desas ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
       $kecamatan = Desa::with('kecamatan')->where('id', $request->desa)->first()->toArray();
       $desa = Desa::where('id', $request->desa)->pluck('nama')->get(0);
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
        $uid = Auth::user()->id;
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];

        if($userRoleId === 4){
            $idAtasan = User::whereIn('jabatan_id', [1,2,3])->with(['jabatan'])->get()->pluck(['id'])->toArray();
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->get()->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->get()->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);
            // dd($arrayResult);
            $desas = $arrayResult;
        } else {
            $desas = [];
        }
        $kecamatans = Kecamatan::get()->toArray();
    
        return view("$this->componentPath/edit", [
            'tps' => $tps->toArray() ?? [],
            'desas' => $desas ?? [],
            'kecamatans' => $kecamatans ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, Tps $tps)
    {
        // dd($request->all());
        $request->validate($this->rules());
        $kecamatan = Desa::with('kecamatan')->where('id', $request->desa)->first()->toArray();
        $desa = Desa::where('id', $request->desa)->pluck('nama')->get(0);
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
