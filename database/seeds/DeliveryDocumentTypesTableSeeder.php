<?php

use Illuminate\Database\Seeder;
use App\Models\Delivery\Document\Type;

class DeliveryDocumentTypesTableSeeder extends Seeder
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
          'price' => 2.00,
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
          'price' => 5.00,
          'can_delivery' => true,
        ],
        [
          'name' => 'Outros',
          'price' => 1.00,
          'can_delivery' => true,
        ],
        [
          'name' => 'Documento',
          'price' => 5.00,
          'can_delivery' => false,
        ],
        [
          'name' => 'Contrato',
          'price' => 7.00,
          'can_delivery' => false,
        ],
        [
          'name' => 'Contrato Aditivo',
          'price' => 15.00,
          'can_delivery' => false,
        ],
        [
          'name' => 'Boleto',
          'price' => 20.00,
          'can_delivery' => false,
        ],
      ];

        foreach ($list as $item) {
          Type::create([
            'name' => $item['name'],
            'price' => $item['price']
          ]);
        }
    }
}
