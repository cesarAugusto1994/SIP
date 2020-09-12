<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Tickets extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
      'count' => 5,
    ];

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = 60;

    public function placeholder()
    {
        return 'Carregando...';
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.tickets', [
            'config' => $this->config,
        ]);
    }
}
