<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PegawaiService;

class PegawaiController extends Controller
{
    private $pegawaiService;

    public function __construct(PegawaiService $pegawaiService){
        $this->pegawaiService = $pegawaiService;
    }

    public function index(){
       return $this->pegawaiService->data();
    }

    public function create(Request $r){
        return $this->pegawaiService->store($r);
    }

}
