<x-mail::message>
# Hello, {{ $participant->name }}!

Thank you for registering for <b>{{ $event->name }}</b>. We are excited to have you join us!

The event will be held at <b>{{ $event->address }}</b> on <b>{{ $event->date['day'] }}</b> at <b>{{ $event->date['time'] }}</b>.

We look forward to seeing you there!


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
