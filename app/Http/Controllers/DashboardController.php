<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;

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

    public function index(){
        $memilih = Pemilih::where('status_memilih', "Memilih")->get()->toArray();
        $raguRagu = Pemilih::where('status_memilih', "Ragu-Ragu")->get()->toArray();
        $tidakMemilih = Pemilih::where('status_memilih', "Tidak-Memilih")->get()->toArray();
        $totalDpt = Pemilih::get()->toArray();
        $uid = Auth::user()->id;
        $roleName =  User::where('id', $uid)->with(['jabatan'])->first()->toArray();
        $leaders = Pemilih::with('leader')->get()->pluck('leader')->toArray();
        return view("$this->componentPath/index", [
            'jumlahMemilih' => count($memilih) ?? [],
            'jumlahRaguRagu' => count($raguRagu) ?? [],
            'jumlahTidakMemilih' => count($tidakMemilih) ?? [],
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
                    $datas = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])
                    ->where('status_memilih', "Memilih")->get()->toArray();
                    $status = "Memilih";
                    break;
    
                case 'Ragu-Ragu':
                    $datas = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])
                    ->where('status_memilih', "Ragu-Ragu")->get()->toArray();
                    $status = "Ragu-Ragu";
                    break;
    
                case 'Tidak-Memilih':
                    $datas = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])
                    ->where('status_memilih', "Tidak-Memilih")->get()->toArray();
                    $status = "Tidak-Memilih";
                    break;
                
                default:
                    $datas = [];
                    $status = "Data Tidak di Temukan";
                    break;
            }
        } else{
            $datas = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])->get()->toArray();
            $status = "DPT";
        }

        return view("$this->componentPath/detail", [
            "datas" => $datas ?? [],
            "status" => $status ?? [],
            'roleName' => $this->getRole() ?? []
        ]);
    }
}
