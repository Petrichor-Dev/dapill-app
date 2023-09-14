<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;
use App\Models\Dpt;
use App\Models\Kecamatan;
use App\Models\Desa;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $componentPath = "dashboard";

    public function getRole(){
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        
        return $roleName;
    }

    public function getPemilih($status)
    {
        $idAtasan = User::whereIn('jabatan_id', [1,2])->with(['jabatan'])->get()->pluck(['id'])->toArray();
        
        $uid = Auth::user()->id;
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];
        if($userRoleId === 5){   
            $pemilihs = Pemilih::where('user_id', $uid)->where('is_active', 1)->where('status_memilih', $status)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get()
                ->toArray() ?? [];

            return $pemilihs;
        } elseif($userRoleId === 4){
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);

            $pemilihs = Pemilih::whereIn('desa_id', $arrayResult)->where('is_active', 1)->where('status_memilih', $status)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get()
                ->toArray() ?? [];
                
            return $pemilihs;
        } elseif($userRoleId === 3){
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->where('is_active', 1)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->get()->where('is_active', 1)->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);

            $pemilihs = Pemilih::whereIn('kecamatan_id', $arrayResult)->where('is_active', 1)->where('status_memilih', $status)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get()
                ->toArray() ?? [];

            return $pemilihs;
        } elseif($userRoleId === 1 || $userRoleId === 2){
            $pemilihs = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])->where('is_active', 1)
            ->where('status_memilih', $status)
            ->get()->toArray() ?? [];

            return $pemilihs;
        } else{
            $pemilihs = [];

            return $pemilihs;
        }
    }

    public function index(){
        $memilih = Pemilih::where('status_memilih', "Memilih")->where('is_active', 1)->get()->toArray();
        $raguRagu = Pemilih::where('status_memilih', "Ragu-Ragu")->where('is_active', 1)->get()->toArray();
        $tidakMemilih = Pemilih::where('status_memilih', "Tidak-Memilih")->where('is_active', 1)->get()->toArray();
        $totalDpt = Dpt::where('is_active', 1)->get()->toArray();
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        $leaders = Pemilih::with('leader')->where('is_active', 1)->get()->pluck('leader')->toArray();
        return view("$this->componentPath/index", [
            'jumlahMemilih' => count($this->getPemilih('Memilih')) ?? [],
            'jumlahRaguRagu' => count($this->getPemilih('Ragu-Ragu')) ?? [],
            'jumlahTidakMemilih' => count($this->getPemilih('Tidak-Memilih')) ?? [],
            'totalDpt' => count($totalDpt) ?? [],
            'leaders' => $leaders ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }

    public function show(string $status = null)
    {   
        
        if($status !== null){
            switch ($status) {
                case 'Memilih':
                    $datas = $this->getPemilih('Memilih');
                    $status = "Memilih";
                    break;
    
                case 'Ragu-Ragu':
                    $datas = $this->getPemilih('Ragu-Ragu');
                    $status = "Ragu-Ragu";
                    break;
    
                case 'Tidak-Memilih':
                    $datas = $this->getPemilih('Tidak-Memilih');
                    $status = "Tidak-Memilih";
                    break;
                
                default:
                    $datas = [];
                    $status = "Data Tidak di Temukan";
                    break;
            }
        } else{
            $datas = Dpt::with(['admin'])->where('is_active', 1)->get()->toArray();
            $status = "DPT";
        }

        return view("$this->componentPath/detail", [
            "datas" => $datas ?? [],
            "status" => $status ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }
}
