<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    public $componentPath = "desa";

    public function rules()
    {
        return [
            'kecamatan' => 'required',
            'namaDesa' => 'required|string',
            'mayor' => 'required',
            'jumlahTps' => 'required|integer',
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
            //satukan semua array
            array_push($idAtasan, $uid);
             //kalo mayor, tampilkan hanya data mayor dan data admin serta panglima
            $desas = Desa::with(['mayor', 'kecamatan'])->whereIn('user_id', $idAtasan)->get()->toArray();
        } elseif($userRoleId === 5){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);
            // dd($atasanKecamatanId);
            $desas = Desa::with(['mayor', 'kecamatan'])->whereIn('kecamatan_id', $arrayResult)->get()->toArray();
        } elseif($userRoleId === 2 || $userRoleId === 3 || $userRoleId === 1){
            $desas = Desa::with(['mayor', 'kecamatan'])->get()->toArray();
        } else{
            $desas = [];
        }
    
        return view("$this->componentPath/index", [
         'desas' => $desas ?? [],
         'roleName' => $this->getRole() ?? []
        ]);
    }

    public function create()
    {
        $kecamatans = Kecamatan::get()->toArray();
        return view("$this->componentPath/create", [
            'kecamatans' => $kecamatans ?? [],
            'mayors' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $category = Desa::create([
                'nama' => $request->namaDesa,
                'mayor_id' => $request->mayor,
                'jumlah_tps' => $request->jumlahTps,
                'kecamatan_id' => $request->kecamatan,
                'user_id' => Auth::user()->id,
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
            'kecamatans' => $kecamatans,
            'mayors' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, Desa $desa)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $desa->update([
                'nama' => $request->namaDesa,
                'mayor_id' => $request->mayor,
                'jumlah_tps' => $request->jumlahTps,
                'kecamatan_id' => $request->kecamatan,
                'user_id' => Auth::user()->id,
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
