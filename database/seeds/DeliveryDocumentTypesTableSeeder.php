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
            'price' => 6.00,

          ],
          [
            'name' => 'Periódico',
            'price' => 5.00,

          ],
          [
            'name' => 'Demissional',
            'price' => 10.00,

          ],
          [
            'name' => 'Nota Fiscal',
            'price' => 0.00,

          ],
          [
            'name' => 'Outros',
            'price' => 1.00,

          ],
          [
            'name' => 'Documento',
            'price' => 0.00,

          ],
          [
            'name' => 'Contrato',
            'price' => 0.00,

          ],
          [
            'name' => 'Contrato Aditivo',
            'price' => 0.00,

          ],
          [
            'name' => 'Boleto',
            'price' => 0.00,

          ],
        ];

        foreach ($list as $item) {
            Type::create([
              'name' => $item['name'],
            ]);
        }
    }
}
