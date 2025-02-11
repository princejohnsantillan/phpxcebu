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
        $this->participating = auth()->user()?->participant?->isJoining($this->event) ?? false;
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
        $this->event->participants()->attach([auth()->user()->participant_id]);

        auth()->user()->participant->notify(new EventRegistered($this->event));

        $this->participating = true;

        Notification::make()
            ->title('Joined successfully')
            ->success()
            ->send();
    }

    public function withdraw(): void
    {
        $this->event->participants()->detach([auth()->user()->participant_id]);

        $this->participating = false;

        Notification::make()
            ->title('Withdrawn successfully')
            ->success()
            ->send();
    }

    public function register(): void
    {
        $participant = Participant::create($this->form->getState());

        $this->event->participants()->attach([$participant->id]);

        auth()->user()?->update([
            'participant_id' => $participant->id,
        ]);

        $this->participating = true;

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
