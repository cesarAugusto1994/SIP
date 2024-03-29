<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\Type;
use App\Models\Ticket\Type\Category;
use App\Models\Ticket\Type\Department;

class TicketTypesTableSeeder extends Seeder
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
            'name' => 'Problemas no SOC',
            'types' => [
              [
                  'name' => 'Esqueci minha senha',
              ],
              [
                  'name' => 'Bloqueio por errar minha senha',
              ],
              [
                  'name' => 'Minhas Permissões estão erradas',
              ],
              [
                  'name' => 'Dúvidas',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],
          [
            'name' => 'Problemas no Computador',
            'types' => [
              [
                  'name' => 'Não Liga',
              ],
              [
                  'name' => 'Não consigo acessar os programas',
              ],
              [
                  'name' => 'Problemas com mouse',
              ],
              [
                  'name' => 'Problemas com teclado',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],

          [
            'name' => 'Problemas com a Internet',
            'types' => [
              [
                  'name' => 'Não Acessa a internet',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],

          [
            'name' => 'Problemas no Ramal',
            'types' => [
              [
                  'name' => 'Está mudo',
              ],
              [
                  'name' => 'Com defeito',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],

          [
            'name' => 'Problemas no E-mail',
            'types' => [
              [
                  'name' => 'Não Consigo Acessar',
              ],
              [
                  'name' => 'Esqueci a Senha',
              ],
              [
                  'name' => 'Não consigo enviar e-mails',
              ],
              [
                  'name' => 'Não consigo receber e-mails',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],

          [
            'name' => 'Problemas no Alterdata',
            'types' => [
              [
                  'name' => 'Não Abre',
              ],
              [
                  'name' => 'Estou sem acesso',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],

          [
            'name' => 'Problemas no Servidor de Arquivos',
            'types' => [
              [
                  'name' => 'Não encontro uma pasta',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
          ],

          [
            'name' => 'Solicitações',
            'types' => [
              [
                  'name' => 'Solicitação de suporte SOC',
              ],
              [
                  'name' => 'Solicitação de Computador',
              ],
              [
                  'name' => 'Solicitação de Notebook',
              ],
              [
                  'name' => 'Novo Prestador',
              ],
              [
                  'name' => 'Solicitação de acesso ao E-mail',
              ],
              [
                  'name' => 'Solicitação de acesso à Rede',
              ],
              [
                  'name' => 'Solicitação de acesso ao Alterdata',
              ],
              [
                  'name' => 'Solicitação de Cartão de Transporte',
              ],
              [
                  'name' => 'Solicitação de Cartão de Abastecimento',
              ],
              [
                  'name' => 'Outros',
              ],
            ],
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
