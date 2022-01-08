<?php

namespace App\Services;

use App\Models\GajiPegawai;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class GajiPegawaiService
{

   private $gajiPegawaiModel;

   public function __construct(GajiPegawai $gajiPegawaiModel)
   {
       $this->gajiPegawaiModel = $gajiPegawaiModel;
   }

   public function data($filter)
   {
       try {
           $data = $this->gajiPegawaiModel::select(DB::raw("DATE_FORMAT(gaji_pegawais.waktu, '%m/%d/%Y %H:%i') as waktu"),DB::raw("UPPER(pegawais.nama) as nama"), DB::raw("FORMAT(total,0, 'id_ID') as total"));
           $data = $data->leftJoin('pegawais','pegawais.id','gaji_pegawais.pegawai_id');
           if (!empty($filter)) {
               $data =  $data->where(DB::raw("DATE_FORMAT(gaji_pegawais.waktu, '%Y-%m')"), $filter);
           }
           $data = $data->paginate(10);
           $response = response()->json(['success' => true, 'data' => $data], 200);
       } catch (\Throwable $e){
           $response = response()->json(['success' => false, 'data' => $e->getMessage()], 401);
       }
        return $response;
   }

   public function store($request){

       $dataPegawai = Pegawai::find($request->pegawaiId);
       try {
           if (!empty($dataPegawai)){
               $data = new  $this->gajiPegawaiModel;
               $data->waktu = now();
               $data->pegawai_id = $dataPegawai->id;
               $data->total = $dataPegawai->gaji;
               $data->save();
               $response = response()->json(['success' => true, 'data' => $data], 200);
           } else {
               $response = response()->json(['success' => false, 'data' => 'data pegawai tidak di temukan'], 401);
           }

       } catch (\Throwable $e){
           $response = response()->json(['success' => false, 'data' => $e->getMessage()], 401);
       }
       return $response;
   }

    public function batch($request){
       $data = $request->data;
        try {
            DB::beginTransaction();

            $data  = collect($data);
            $chunks = $data->chunk(500);
            foreach ($chunks as $chunk)
            {
                $this->gajiPegawaiModel::insert($chunk->toArray());
            }

            DB::commit();
            $response = response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Throwable $e){
            DB::rollBack();
            $response = response()->json(['success' => false, 'data' => $e->getMessage()], 401);
        }
        return $response;
    }


}
