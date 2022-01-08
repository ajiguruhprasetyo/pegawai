<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GajiPegawaiService;

class GajiPegawaiController extends Controller
{
    private $gajiPegawaiService;

    public function __construct(GajiPegawaiService $gajiPegawaiService){
        $this->gajiPegawaiService = $gajiPegawaiService;
    }

    public function index($filter){
        return $this->gajiPegawaiService->data($filter);
    }

    public function create(Request $r){
        return $this->gajiPegawaiService->store($r);
    }

    public function batch(Request $r){
        return $this->gajiPegawaiService->batch($r);
    }
}
