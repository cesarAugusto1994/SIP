<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Client\Address;
use App\Helpers\TimesAgo;
use App\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $data = $request->request->all();

        $search = $request->get('q');

        $results = [];

        $records = Client::where('name', 'like', "%$search%")->get();

        foreach ($records as $key => $record) {
            $results[] = [
              'header' => 'Cliente: ' . $record->name,
              'image' => '',
              'content' => '',
              'url' => route('clients.show', $record->uuid),
              'date' => TimesAgo::render($record->created_at)
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
              'date' => TimesAgo::render($record->created_at)
            ];
        }

        return view('search.index', compact('results'));
    }
}
