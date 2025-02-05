<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Participant;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class EventRegistration extends Component implements  HasForms, HasActions
{

    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public Event $event;


    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('phone'),
                TextInput::make('company'),
                TextInput::make('position'),
            ])
            ->statePath('data');
    }


    public function create(): void
    {
        //save participant for event
        $participant = Participant::create($this->form->getState());

        EventParticipant::query()->create([
            'participant_id' => $participant->id,
            'event_id' => $this->event->id
        ]);


        dd($this->form->getState());
    }


    public function render()
    {

        return view('livewire.event-registration');
    }
}
