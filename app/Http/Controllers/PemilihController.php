<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use App\Models\Dpt;
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
use App\Rules\UniqueActiveName;
use Illuminate\Validation\Rule;

class PemilihController extends Controller
{
    public $componentPath = "pemilih";
    
    public function rules()
    { 
        return [
            'nama' => ['required', 'string', new UniqueActiveName],
            // 'nik' => 'required|digits:16|integer|unique:pemilih,nik',
            'kecamatan' => 'required',
            'desa' => 'required',
            'tps' => 'required',
            'mayor' => 'required',
            'leader' => 'required',
            'kapten' => 'required',
            'statusMemilih' => 'required'
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
        //cek apakah idnya mayor atau bukan
        if($userRoleId === 5){
            // array_push($idAtasan, $uid);
            // $pemilihs = Pemilih::whereIn('user_id', $idAtasan)
            //     ->with(['admin', 'leader', 'kapten', 'mayor'])
            //     ->get()
            //     ->toArray() ?? [];   
            $pemilihs = Pemilih::where('user_id', $uid)->where('is_active', 1)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->paginate(100) ?? [];
        } elseif($userRoleId === 4){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);

            $pemilihs = Pemilih::whereIn('desa_id', $arrayResult)->where('is_active', 1)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->paginate(100) ?? [];
        } elseif($userRoleId === 3){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->get()->where('is_active', 1)->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);

            $pemilihs = Pemilih::whereIn('kecamatan_id', $arrayResult)->where('is_active', 1)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->paginate(100) ?? [];
        } elseif($userRoleId === 1 || $userRoleId === 2){
            $pemilihs = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])->where('is_active', 1)->paginate(100) ?? [];
        } else{
            $pemilihs = [];
        }

        return view("$this->componentPath/index",[
            'pemilihs' => $pemilihs ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'kecamatans' => Kecamatan::where('is_active', 1)->get()->toArray() ?? [],
            'desas' => Desa::where('is_active', 1)->get()->toArray() ?? [],
            'tpss' => Tps::where('is_active', 1)->get()->toArray() ?? [],
            'leaders' => Leader::where('is_active', 1)->get()->toArray() ?? [],
            'mayors' => User::where('jabatan_id', 3)->get()->toArray() ?? [],
            'kaptens' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'statusMemilih' => ['Memilih', 'Ragu-Ragu', 'Tidak-Memilih'],
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
           $cekDpt = Dpt::where('nama', $request->nama)->where('is_active', 1)->first();
           $cekDpt ? $is_dpt = 1 : $is_dpt = 0;
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
            //    'nik' => $request->nik,
               'status_memilih' => $request->statusMemilih,
               'is_dpt' => $is_dpt,
               'is_active' => 1
           ]);

           if($is_dpt === 1){
            $cekDpt->update([
                'is_pemilih' => 1
            ]);
           }

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
            'kecamatans' => Kecamatan::where('is_active', 1)->get()->toArray() ?? [],
            'desas' => Desa::where('is_active', 1)->get()->toArray() ?? [],
            'tpss' => Tps::where('is_active', 1)->get()->toArray() ?? [],
            'leaders' => Leader::where('is_active', 1)->get()->toArray() ?? [],
            'mayors' => User::where('jabatan_id', 3)->get()->toArray() ?? [],
            'kaptens' => User::where('jabatan_id', 5)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, Pemilih $pemilih)
    {

        $request->validate([
                'nama' => ['required','string', Rule::unique('pemilih')->ignore($pemilih->id)],
                'kecamatan' => 'required',
                'desa' => 'required',
                'tps' => 'required',
                'mayor' => 'required',
                'leader' => 'required',
                'kapten' => 'required',
                'statusMemilih' => 'required'
            ]);

                $kecamatan = Kecamatan::where('id', $request->kecamatan)->where('is_active', 1)->pluck('nama')->get(0);
                $desa = Desa::where('id', $request->desa)->where('is_active', 1)->pluck('nama')->get(0);
                $tps = Tps::where('id', $request->tps)->where('is_active', 1)->pluck('nama')->get(0);
                DB::beginTransaction();
                try {
                    $cekDpt = Dpt::where('nama', $request->nama)->where('is_active', 1)->first();
                    $cekDpt ? $is_dpt = 1 : $is_dpt = 0;
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
                        // 'nik' => $request->nik,
                        'status_memilih' => $request->statusMemilih,
                        'is_dpt' => $is_dpt,
                        'is_active' => 1
                    ]);

                    if($is_dpt === 1){
                        $cekDpt->update([
                            'is_pemilih' => 1
                        ]);
                       }
    
                    DB::commit();
                    $request->session()->flash('success', 'Data Pemilih Berhasil di Edit');
                    return redirect('/pemilih');    
                } catch (Exception $e) {
                    return back()->withErrors($e->getMessage());
                    // dd($e->getMessage());
                }
    }

    public function destroy(Request $request, Pemilih $pemilih)
    {
        DB::beginTransaction();
        try {
            $pemilih->update([
                'is_active' => 0
            ]);
            DB::commit();
            $request->session()->flash('success', 'Data Pemilih ('.$pemilih->nama.') Berhasil di Hapus');
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function export()
	{   
		return Excel::download(new PemilihExport, 'data-pemilih.xlsx');
	}
}
