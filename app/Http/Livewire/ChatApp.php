<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatApp extends Component
{
    public $messages;
    public $message;

    public function mount() {
        \Carbon\Carbon::setLocale('fr');
        $this->messages = ChatMessage::orderBy('created_at', 'ASC')->get();
    }

    public function refreshMessage() {
        \Carbon\Carbon::setLocale('fr');
        $this->messages = ChatMessage::orderBy('created_at', 'ASC')->get();
    }

    public function postMessage() {
        if(trim($this->message) !== "" && !is_null($this->message)) {
            ChatMessage::create([
                'message' => trim($this->message),
                'chat_messageable_id' => Auth::id(),
                'chat_messageable_type' => get_class(Auth::user())
            ]);
        }
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.chat-app');
    }
}
