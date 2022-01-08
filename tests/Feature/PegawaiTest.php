<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PegawaiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('api/pegawai');

        $response->assertStatus(200);
    }

    public function test_insert()
    {
        $response = $this->json('POST','api/pegawai',[
                    'nama' => 'Test Nama',
                    'gaji' => 5000000
                ]);

        $response->assertStatus(200);
    }
}
