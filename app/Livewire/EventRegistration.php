<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Participant;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class EventRegistration extends Component implements  HasForms, HasActions
{

    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public Event $event;

    public ?User $authUser;


    public function mount(): void
    {

        $this->authUser = auth()->user();

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


    public function join(): void
    {
        EventParticipant::query()->create([
            'participant_id' => $this->authUser->participant_id,
            'event_id' => $this->event->id
        ]);

        Notification::make()
            ->title('Joined successfully')
            ->success()
            ->send();
    }

    // TODO: add a un-join feature

    public function register(): void
    {
        //save participant for event
        $participant = Participant::create($this->form->getState());

        EventParticipant::query()->create([
            'participant_id' => $participant->id,
            'event_id' => $this->event->id
        ]);


        if(!is_null($this->authUser)){
            $this->authUser->update([
                'participant_id' => $participant->id,
            ]);
        }

        $this->data = [];


        Notification::make()
            ->title('Registered successfully')
            ->success()
            ->send();
    }


    public function render()
    {

        return view('livewire.event-registration');
    }
}
