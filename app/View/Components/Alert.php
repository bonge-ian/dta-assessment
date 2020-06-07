<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;

    /**
     * Create a new component instance.
     *
     * @param $type
     * @param $message
     */
    public function __construct($type, $message)
    {

        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }

    public function setClass() {
        switch ($this->type) {
            case 'error':
                return 'uk-alert-danger';
                break;
            case 'success':
                return 'uk-alert-success';
                break;
            case 'warning':
                return 'uk-alert-warning';
                break;
            default:
                return 'uk-alert-primary';
        }
    }
}
