<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GajiPegawaiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('api/gaji-pegawai/2022-01');

        $response->assertStatus(200);
    }

    public function test_insert()
    {
        $response = $this->json('POST','api/gaji-pegawai',[
                    'pegawaiId' => 1
                ]);

        $response->assertStatus(200);
    }

    public function test_insert_batch()
    {
        $response = $this->json('POST','api/gaji-pegawai/batch',[
            'data' => [
                ["waktu"=> "2022-01-08 09:58:36",
                "pegawai_id"=> 1,
                "total" => 7000
                ]
            ]
        ]);

        $response->assertStatus(200);
    }
}
