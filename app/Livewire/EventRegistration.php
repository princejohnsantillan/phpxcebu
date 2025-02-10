<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Participant;
use App\Models\EventParticipant;
use App\Notifications\EventRegistered;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class EventRegistration extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];
    public Event $event;
    public bool $participating = false;

    public function mount(): void
    {
        $this->participating = EventParticipant::query()
            ->where('participant_id', auth()->user()?->participant_id)
            ->where('event_id', $this->event->id)
            ->exists();
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
            'participant_id' => auth()->user()->participant_id,
            'event_id' => $this->event->id,
        ]);

        auth()->user()->participant->notify(new EventRegistered($this->event));

        Notification::make()
            ->title('Joined successfully')
            ->success()
            ->send();

        $this->participating = true;
    }

    public function withdraw(): void
    {
        EventParticipant::query()->where([
            'participant_id' => auth()->user()->participant_id,
            'event_id' => $this->event->id,
        ])->delete();

        Notification::make()
            ->title('Withdrawn successfully')
            ->success()
            ->send();

        $this->participating = false;
    }

    public function register(): void
    {
        //save participant for event
        $participant = Participant::create($this->form->getState());

        $this->event->participants()->attach([$participant->id]);

        auth()->user()?->update([
            'participant_id' => $participant->id,
        ]);

        $this->data = [];

        $participant->notify(new EventRegistered($this->event));

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
