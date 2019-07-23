<?php

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Unit\Phone;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$itens = ['Vitória', 'Vila Velha Centro', 'Vila Velha Ibes', 'Serra', 'Cariacica', 'Baixo Guandú'];

        $itens = [
          [
            'name' => 'Vitória',
            'address' => 'Av. Paulino Muller, 885 - Ilha de Santa Maria, Vitória - ES, 29051-035',
            'workload' => '',
            'phones' => [
              '(27) 3223-3130','(27) 3322-0030'
            ],
          ],
          [
            'name' => 'Vila Velha Centro',
            'address' => 'R. Araribóia, 719, Centro, Vila Velha - ES, 29100-970',
            'workload' => '',
            'phones' => [
              '(27) 3223-3130','(27) 3322-0030'
            ],
          ],
          [
            'name' => 'Vila Velha Ibes',
            'address' => 'R. Rejente Feijó, 04, Nossa Senhora da Penha, Vila Velha, ES',
            'workload' => '',
            'phones' => [
              '(27) 3223-3130','(27) 3322-0030'
            ],
          ],
          [
            'name' => 'Serra',
            'address' => 'R. Isaac Newton, 154 - Parque Res. Laranjeiras, Serra - ES, 29165-180',
            'workload' => '',
            'phones' => [
              '(27) 3223-3130','(27) 3322-0030'
            ],
          ],
          [
            'name' => 'Cariacica',
            'address' => 'Av. Espírito Santo, 13 - Morada de Campo Grande, Cariacica - ES',
            'workload' => '',
            'phones' => [
              '(27) 3091-6866'
            ],
          ],
          [
            'name' => 'Baixo Guandú',
            'address' => 'R. Sebastião Cândido de Oliveira, 507, 3º andar, Sl 303, Centro, Baixo Guandu - ES',
            'workload' => '',
            'phones' => [
              '(27) 3732-3742'
            ],
          ]
        ];

        foreach ($itens as $key => $item) {
            $unit = Unit::create([
              'name' => $item['name'],
              'address' => $item['address'],
              'workload' => $item['workload'],
            ]);

            foreach ($item['phones'] as $keyw => $phone) {
                Phone::create([
                  'unit_id' => $unit->id,
                  'number' => $phone,
                ]);
            }

        }
    }
}
