<div class="relative flex w-full flex-col min-h-screen py-6 justify-between text-white/50">
    <div class="absolute top-0 z-[-2] h-full w-full bg-black bg-[radial-gradient(#ffffff33_1px,#000000_1px)] bg-[size:40px_40px]"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="flex flex-col gap-y-4 mx-auto max-w-3xl">
            <div class="overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium dark:text-gray-50">Event Registration</h3>
                    <p class="mt-1 text-sm">Please fill out the form below to register for the event.</p>
                </div>
            </div>

            <div class="flex flex-col gap-y-4 px-4 text-center">
                <h1 class="text-3xl dark:text-gray-50 font-bold tracking-tight text-balance sm:text-4xl">
                    {{$event->name}}
                </h1>
                <section class="flex flex-col gap-y-4 justify-center items-center">
                    <p class="text-lg font-medium text-pretty sm:text-xl/8 w-96">
                        {{$event->address}}
                    </p>
                    <div class="flex flex-col items-center justify-center gap-x-6">
                        <p class="text-base/7 font-semibold">
                            {{$eventDate['day']}}
                        </p>
                        <p class="text-base/7 font-semibold">
                            {{$eventDate['time']}}
                        </p>
                    </div>
                </section>
            </div>


            <div class="overflow-hidden rounded-lg bg-black/50 backdrop-blur-md shadow mt-5 p-4">
                <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
                    <div class="relative left-1/2 -z-10 aspect-1155/678 w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                  </div>

                @if(!is_null(auth()->user()?->participant_id))
                    <button wire:click="join" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Join
                    </button>
                @else
                    <div class="dark:text-gray-50 px-4 py-5 sm:p-6">
                        <form wire:submit="register" class="flex flex-col gap-y-8">
                            {{ $this->form }}

                            <div class="flex">
                                <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:focus-visible:outline-gray-600 dark:bg-gray-700">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <x-filament-actions::modals />
</div>
