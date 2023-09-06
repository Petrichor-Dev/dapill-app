<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\User;
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
            'jendral' => 'required',
            'jumlahDesa' => 'required|integer',
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
        if($userRoleId === 5){
            //satukan semua array
            array_push($idAtasan, $uid);
             //kalo mayor, tampilkan hanya data mayor dan data admin serta panglima
            $kecamatans = Kecamatan::with('jendral')->whereIn('user_id', $idAtasan)->get()->toArray();
        } elseif($userRoleId === 2 || $userRoleId === 3 || $userRoleId === 1){
            //jika admin dan panglima, tampilkan semua data
            $kecamatans = Kecamatan::with('jendral')->get()->toArray();
        } else{
            $kecamatans = [];
        }
        
       return view("$this->componentPath/index", [
        'kecamatans' =>$kecamatans ?? [],
        'roleName' => $this->getRole() ?? []
       ]);
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'jendrals' => User::where('jabatan_id', 4)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {   
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $category = Kecamatan::create([
                'nama' => $request->namaKecamatan,
                'jendral_id' => $request->jendral,
                'jumlah_desa' => $request->jumlahDesa,
                'user_id' => Auth::user()->id,
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
            'kecamatan' => $kecamatan->toArray(),
            'jendrals' => User::where('jabatan_id', 4)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
        try {
            $kecamatan->update([
                'nama' => $request->namaKecamatan,
                'jendral_id' => $request->jendral,
                'jumlah_desa' => $request->jumlahDesa,
                'user_id' => Auth::user()->id,
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
