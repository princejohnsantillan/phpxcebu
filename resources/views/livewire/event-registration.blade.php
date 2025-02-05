<div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-3xl">

            <h1>{{$event->name}}</h1>
            <section>
                <p>{{$event->address}}</p>
                <p>{{$event->starts_at}}</p>
                <p>{{$event->ends_at}}</p>
            </section>


            <div class="overflow-hidden rounded-lg bg-white shadow mt-5">
                @if(!is_null($authUser->participant_id))
                    <button wire:click="join" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Join
                    </button>
                @else
                    <div class="px-4 py-5 sm:p-6">
                        <form wire:submit="register" >
                            {{ $this->form }}

                            <br />

                            <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Submit
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <x-filament-actions::modals />
</div>
