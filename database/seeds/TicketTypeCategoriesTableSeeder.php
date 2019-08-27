<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\Type\Category;
use App\Models\Ticket\Type;
use App\Models\Ticket\Type\Department;

class TicketTypeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $itens = [
        [
          'name' => 'Impressora',
          'types' => [
            [
                'name' => 'A impressão esta saindo manchada',
            ],
            [
                'name' => 'A tinta do toner acabou',
            ],
            [
                'name' => 'Não consigo conectar à impressora',
            ],
          ]
        ]
      ];

      foreach ($itens as $key => $item) {

          $category = Category::create([
            'name' => $item['name']
          ]);

          foreach ($item['types'] as $key2 => $type) {

              $type2 = Type::create([
                  'name' => $type['name'],
                  'category_id' => $category->id,
              ]);

              Department::updateOrcreate([
                'type_id' => $type2->id,
                'department_id' => 1
              ]);

              Department::updateOrcreate([
                'type_id' => $type2->id,
                'department_id' => 2
              ]);
          }

      }
    }
}
