<?php

namespace App\Modules\Core\Livewire\Feedback;

use Livewire\Component;

class FeedbackMessage extends Component
{

    public $message;



    protected $listeners = [
        "setFeedbackMessageEvent" => "setFeedbackMessage",
        "clearFeedbackMessageEvent" => "clearFeedbackMessage",
    ];


    public function setFeedbackMessage($message) {
        $this->message[$message["type"]] = $message["message"];
    }

    public function clearFeedbackMessage() {
        $this->message = [];
    }



    public function render() {
        return view('core::feedback.feedback-messages');
    }


}