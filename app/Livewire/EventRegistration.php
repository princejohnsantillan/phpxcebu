<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Participant;
use App\Models\EventParticipant;
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
    public array $eventDate = [];

    public ?User $authUser;

    public function mount(): void
    {
        $this->authUser = auth()->user();

        $this->eventDate = [
            'day' => Carbon::parse($this->event->starts_at)->format('l, jS \\of F Y'),
            'time' => Carbon::parse($this->event->starts_at)->format('h:i A') . ' - ' . Carbon::parse($this->event->ends_at)->format('h:i A'),
        ];
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
            'event_id' => $this->event->id,
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

        $this->event->participants()->attach([$participant->id]);

        $this->authUser?->update([
            'participant_id' => $participant->id,
        ]);

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
