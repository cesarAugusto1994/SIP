<?php

use Illuminate\Database\Seeder;
use App\Models\Documents\Type;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
          [
            'name' => 'Admissional',
            'price' => 6.00,
            'can_delivery' => true,
          ],
          [
            'name' => 'Periódico',
            'price' => 5.00,
            'can_delivery' => true,
          ],
          [
            'name' => 'Demissional',
            'price' => 10.00,
            'can_delivery' => true,
          ],
          [
            'name' => 'Nota Fiscal',
            'price' => 0.00,
            'can_delivery' => true,
          ],
          [
            'name' => 'Outros',
            'price' => 1.00,
            'can_delivery' => true,
          ],
          [
            'name' => 'Documento',
            'price' => 0.00,
            'can_delivery' => false,
          ],
          [
            'name' => 'Contrato',
            'price' => 0.00,
            'can_delivery' => false,
          ],
          [
            'name' => 'Contrato Aditivo',
            'price' => 0.00,
            'can_delivery' => false,
          ],
          [
            'name' => 'Boleto',
            'price' => 0.00,
            'can_delivery' => false,
          ],
        ];

        foreach ($list as $item) {
            Type::create([
              'name' => $item['name'],
            ]);
        }
    }
}
