<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Training\Team;

class TrainingsController extends Controller
{
    public function index(Request $request)
    {
        $start = new \DateTime('2020-01-01');
        $end = new \DateTime('2020-01-31');

        $teams = Team::orderByDesc('id')->take(2)->get();

        $cardCollor = "#1ab394";
        $editable = false;

        $data = [];

        foreach ($teams as $key => $team) {
          /*switch($team->course->type) {
            case 'Treinamento':
              $cardCollor = "#23c6c8";
              $editable = true;
            break;
            case 'Palestra':
              $cardCollor = "#f8ac59";
              $editable = true;
            break;
            default:
              $cardCollor = "#0ac282";
            break;
          }*/

          if($team->start > now()) {
              $editable = true;
          }

          $cardCollor = $team->course->color;

          if($team->status != 'RESERVADO') {
            $editable = false;
          }

          $title = $team->course->type . ' - ' . $team->course->title . ' - Instrutor(a): ' . $team->teacher->person->name;

          $data[$team->start->format('Y-m-d')] = [
              /*'id' => $team->id,
              'uuid' => $team->uuid,
              'course_id' => $team->course_id,
              'title' => $title,*/
              'name' => $title,
              'description' => $team->course->description,
              'start' => $team->start ? $team->start->format('Y-m-d H:i') : null,
              'end' => $team->end ? $team->end->format('Y-m-d H:i') : null,
              /*'color' => $cardCollor,
              'editable' => $editable,
              'route' => route('teams.show', $team->uuid),*/
          ];
        }
        //echo "<pre>";
        return response()->json($data);
    }
}
