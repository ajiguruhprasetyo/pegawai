<?php

namespace App\Services;

use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PegawaiService
{

   private $pegawaiModel;

   public function __construct(Pegawai $pegawaiModel)
   {
       $this->pegawaiModel = $pegawaiModel;
   }

   public function data()
   {
       try {
           $data =  $this->pegawaiModel::select(DB::raw("UPPER(SUBSTRING_INDEX( nama, ' ', 1 )) as nama"), DB::raw("FORMAT(gaji,0, 'id_ID') as gaji"))->paginate(10);;
           $response = response()->json(['success' => true, 'data' => $data], 200);
       } catch (\Throwable $e){
           $response = response()->json(['success' => false, 'data' => $e->getMessage()], 401);
       }
        return $response;
   }

   public function store($request){

       $rules = [
           'nama' => 'required|max:10',
           'gaji' => 'required'
       ];

       $messages = [
           'nama.required' => 'Please enter a nama.',
           'gaji.required' => 'Please enter a gaji.',
            ];

       $validator= Validator::make($request->all(), $rules, $messages);

       if($validator->fails()){
           $messages = $validator->messages();
           $errors = $messages->all();
           return  response()->json(['success' => false, 'data' => $errors], 401);;
       }

       try {
           $validasiNama = $this->validateName($request->nama) > 0;
           $validasiGaji =  $this->validateGajiMin((int)$request->gaji) == $this->validateGajiMax((int)$request->gaji);

           if (!$validasiNama & $validasiGaji){
               $data = new  $this->pegawaiModel;
               $data->nama = $request->nama;
               $data->gaji = $request->gaji;
               $data->save();
               $response = response()->json(['success' => true, 'data' => $data], 200);
           } elseif ($validasiNama) {
               $response = response()->json(['success' => false, 'data' => 'nama sudah ada'], 200);
           } elseif ($validasiGaji) {
               $response = response()->json(['success' => false, 'data' => 'gaji harus minimal 4.000.000 dan maksimal 10.000.000'], 200);
           } else  {
               $response = response()->json(['success' => false, 'data' => 'data gagal disimpan'], 200);
           }

       } catch (\Throwable $e){
           $response = response()->json(['success' => false, 'data' => $e->getMessage()], 401);
       }
       return $response;
   }

   public function validateName($name){
       return $this->pegawaiModel::where('nama',$name)->count();
   }

    public function validateGajiMin($amount){
        return 4000000 <= $amount;
    }

    public function validateGajiMax($amount){
        return 10000000 >= $amount;
    }
}
