<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Client\{Address,Employee};
use App\Helpers\TimesAgo;
use App\Helpers\Helper;
use App\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $data = $request->request->all();

        $search = $request->get('q');

        $results = [];

        $records = Client::where('name', 'like', "%$search%")->orWhere('document', 'like', "%$search%")->get();

        foreach ($records as $key => $record) {
            $results[] = [
              'header' => 'Cliente: ' . $record->name,
              'image' => '',
              'content' => '',
              'url' => route('clients.show', $record->uuid),
              'date' => $record->created_at->diffForHumans()
            ];
        }

        $records = Employee::where('name', 'like', "%$search%")->orWhere('cpf', 'like', "%$search%")->get();

        foreach ($records as $key => $record) {
            $results[] = [
              'header' => 'Funcionário: ' . $record->name,
              'image' => '',
              'content' => Helper::actualCompany($record)->name ?? '',
              'url' => route('employees.show', $record->uuid),
              'date' => $record->created_at->diffForHumans()
            ];
        }

        $records = Address::where('zip', 'like', "%$search%")
        ->orWhere('description', 'like', "%$search%")
        ->orWhere('street', 'like', "%$search%")->get();

        foreach ($records as $key => $record) {
            $results[] = [
              'header' => 'Endereço: ' . $record->description . ' - ' . $record->client->name,
              'image' => '',
              'content' => $record->street,
              'url' => route('clients.show', $record->client->uuid),
              'date' => $record->created_at->diffForHumans()
            ];
        }

        return view('search.index', compact('results'));
    }
}
