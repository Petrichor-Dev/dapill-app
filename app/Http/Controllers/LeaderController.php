<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Pemilih;
use App\Models\Dpt;
use App\Models\Desa;
use App\Models\Tps;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderController extends Controller
{
    public $componentPath = "leader";

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:leaders,name'],
        ];
    }

    public function getRole(){
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        
        return $roleName;
    }

    public function index()
    {
        return view("$this->componentPath/index", [
            'leaders' => Leader::with(['pemilih'])->where('is_active', 1)->get()->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
           ]);
    }

    public function create()
    {
        return view("$this->componentPath/create", [
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
            try {
                $user = Leader::create([
                    'name' => $request->name,
                    'is_active' => 1
                ]);
                DB::commit();
                $request->session()->flash('success', 'Data Leader Berhasil di Tambahkan');
                return redirect('/leader');
            } catch (\Exception $e) {
                return back()->withErrors(['message' => $e->getMessage()]);
            }
    }

    public function edit(leader $leader)
    {
        return view("$this->componentPath/edit", [
            'leader' => $leader->toArray() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function show($leader)
    {
        //get data panglima, admin dan super admin
        $idAtasan = User::whereIn('jabatan_id', [1,2])->with(['jabatan'])->get()->pluck(['id'])->toArray();
        
        //get user lalu lihat id nya
        $uid = Auth::user()->id;
        // lalu lihat rolenya
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];
        //cek apakah idnya mayor atau bukan
        if($userRoleId === 5){
            array_push($idAtasan, $uid);
            $pemilihs = Pemilih::whereIn('user_id', $idAtasan)->where('leader_id', $leader)->where('is_active', 1)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get()
                ->toArray() ?? [];
                // dd($pemilihs);
        } elseif($userRoleId === 4){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);

            $pemilihs = Pemilih::whereIn('desa_id', $arrayResult)->where('is_active', 1)->where('leader_id', $leader)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get()
                ->toArray() ?? [];
        } elseif($userRoleId === 3){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);

            $pemilihs = Pemilih::whereIn('kecamatan_id', $arrayResult)->where('is_active', 1)->where('leader_id', $leader)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get()
                ->toArray() ?? [];
        } elseif($userRoleId === 1 || $userRoleId === 2){
            $pemilihs = Pemilih::where('leader_id', $leader)->where('is_active', 1)->with(['admin', 'leader', 'kapten', 'mayor'])->get()->toArray() ?? [];
        } else{
            $pemilihs = [];
        }

        
        return view("$this->componentPath/show", [
            'pemilihs' => $pemilihs ?? [],
            'leader' => Leader::where('id', $leader)->where('is_active', 1)->with(['pemilih'])->get()->pluck('name')->first() ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function update(Request $request, leader $leader)
    {
        $request->validate($this->rules());
        DB::beginTransaction();
            try {
                $leader->update([
                    'name' => $request->name,
                    'is_active' => 1
                ]);
                DB::commit();
                $request->session()->flash('success', 'Data Leader Berhasil di Update');
                return redirect('/leader');
            } catch (\Exception $e) {
                return back()->withErrors(['message' => $e->getMessage()]);
            }
    }

    public function destroy(Request $request, leader $leader)
    {
        DB::beginTransaction();
            try {
                $leader->update([
                    'is_active' => 0
                ]);
                DB::commit();
                $request->session()->flash('success', 'Data Leader ('.$leader->name.') Berhasil di Hapus');
                return back();
            } catch (\Exception $e) {
                return back()->withErrors(['message' => $e->getMessage()]);
            }
    }
}
