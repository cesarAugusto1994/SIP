<?php

use Illuminate\Database\Seeder;
use App\Models\Configuration\Type;
use App\Models\Configuration;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['text','boolean','file','select','textarea'];

        foreach ($itens as $key => $item) {
            Type::create(['name'=>$item]);
        }

        $itens = [
         [
           'name' => 'Nome Aplicação',
           'description' => 'Nome da aplicação',
           'slug' => str_slug('Nome Aplicacao', '.'),
           'value' => 'SIP',
           'type_id' => 1,
           'can_drop' => false
         ],
         [
           'name' => 'Logo Aplicação',
           'description' => 'Logo da Aplicação',
           'slug' => str_slug('Logo Aplicacao', '.'),
           'value' => '/',
           'type_id' => 3,
           'can_drop' => false
         ],
         [
           'name' => 'Google API KEY',
           'description' => 'Google API KEY',
           'slug' => str_slug('Google API KEY', '.'),
           'value' => 'AIzaSyB9sX1jVroVEP8y4Ng_2d6u9s3YjcrrZco',
           'type_id' => 1,
           'can_drop' => false
         ],
         [
           'name' => 'Mail Driver',
           'description' => 'Driver de Email',
           'slug' => str_slug('Mail Driver', '.'),
           'value' => null,
           'type_id' => 1,
           'can_drop' => false
         ],
         [
           'name' => 'Mail Host',
           'description' => 'Host do Email',
           'slug' => str_slug('Mail Host', '.'),
           'value' => null,
           'type_id' => 1,
           'can_drop' => false
         ],
         [
           'name' => 'Mail Port',
           'description' => 'Porta do Host',
           'slug' => str_slug('Mail Port', '.'),
           'value' => null,
           'type_id' => 1,
           'can_drop' => false
         ],
         [
           'name' => 'Mail Encryption',
           'description' => 'Encriptacao do Host',
           'slug' => str_slug('Mail Encryption', '.'),
           'value' => null,
           'type_id' => 1,
           'can_drop' => false
         ],
       ];

       foreach ($itens as $key => $item) {
           Configuration::create($item);
       }
    }
}
