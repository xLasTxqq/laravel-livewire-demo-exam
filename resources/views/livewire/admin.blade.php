<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Административная панель') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-center font-bold text-3xl">Заказы</h2>
                <div class="flex sm:flex-row flex-col items-center justify-between w-full sm:px-4 mx-0 sm:my-0 my-4 border-b">
                    <h2 class="flex items-center font-semibold text-xl sm:py-8 sm:px-4 px-0">Фильтр по статусу:</h2>
                    <select class="sm:my-0 my-4" wire:model="status">
                        <option value="null" selected>Все</option>
                        @foreach($statuses as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 grid 2xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
                    @if($orders->count()<1) <h2 class="font-bold text-xl sm:px-8">Заказов не найдено</h2>
                        @endif
                        @foreach($orders as $order)
                        <!-- <div wire:key="session-field-{{ $order->id }}"> -->
                        <div class="p-4 rounded-lg bg-gray-100 shadow justify-between flex flex-col border">
                            <div>
                                <h2 class="italic text-sm text-right">{{Carbon\Carbon::parse($order->created_at)->isoFormat('llll')}}</h2>
                                <h2 class="text-lg font-semibold mt-4">{{sprintf ("%s %s %s",$order->user->name,$order->user->surname,$order->user->patronymic??'') }}</h2>
                                <div class="my-4 border-y border-black">
                                    @foreach($order->tickets as $ticket)
                                    <div class="flex justify-between items-center">
                                        <h2 class="my-2">{{$ticket->session->name}}</h2>
                                        <h2 class="my-2">{{$ticket->amount.'шт.'}}</h2>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @if($order->status->id==1)
                            <div>
                                @if ($errors->has('changeableOrders.'.$order->id.'.cause')||$errors->has('changeableOrders.'.$order->id.'.status'))
                                <div class="mb-4">
                                    <div class="font-medium text-red-600">
                                        {{ __('Упс! Что-то пошло не так.') }}
                                    </div>
                                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="mt-4">
                                    <x-label for="status" :value="__('Статус *')" />
                                    <select wire:model="changeableOrders.{{ $order->id }}.status">
                                        <option value="null" hidden selected>Выберите статус</option>
                                        @foreach($statuses as $status)
                                        @if($status->id!=1)
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4 {{($changeableOrders[$order->id]['status']??0)==3?'':'hidden'}}">
                                    <x-label for="cause" :value="__('Комментарий *')" />
                                    <x-input wire:model="changeableOrders.{{ $order->id }}.cause" id="cause" class="block mt-1 w-full" type="text" name="cause" :value="old('cause')" />
                                </div>
                                <x-button class="mt-4" wire:click="changeStatus({{$order->id}})">Изменить статус</x-button>
                            </div>
                            @else
                            <div>
                                <div class="mt-4">
                                    <x-label for="status" :value="__('Статус')" />
                                    <select>
                                        <option selected>{{$order->status->name}}</option>
                                    </select>
                                </div>
                                <x-button class="mt-4 invisible">Изменить статус</x-button>
                            </div>
                            @endif

                        </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="border-b border-gray-200">
                    <h2 class="text-center font-bold text-3xl">Жанры</h2>
                    <form wire:submit.prevent="createGenre" class="flex justify-center flex-col mx-auto lg:max-w-[50%]">
                        @if ($errors->has(['genre_name']))
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Упс! Что-то пошло не так.') }}
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->get('genre_name') as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="mt-4">
                            <x-label for="genre_name" :value="__('Название жанра *')" />
                            <x-input wire:model="genre_name" id="genre_name" class="block mt-1 w-full" type="text" name="genre_name" :value="old('genre_name')" />
                        </div>
                        @if (session()->has('createdGenre'))
                            <div class="text-green-500 text-md mt-2">
                                {{ session('createdGenre') }}
                            </div>
                        @endif
                        <x-button class="flex justify-center items-center my-8 sm:w-2/5">Создать</x-button>
                    </form>
                </div>
                <div class="my-8">
                    @foreach($genres as $genre)
                    <div class="flex my-4 sm:flex-row bg-gray-100 flex-col items-center justify-between shadow rounded-lg sm:px-8 px-0">
                        <h2 class="my-2 text-xl">{{$genre->name}}</h2>
                        <x-button class="my-2" wire:click="deleteGenre({{$genre->id}})">Удалить жанр</x-button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="border-b border-gray-200">
                    <h2 class="text-center font-bold text-3xl">Сеансы</h2>
                    <form wire:submit.prevent="createSession" class="flex justify-center flex-col mx-auto lg:max-w-[50%]">
                        @if($errors->has('session_name')||
                        $errors->has('session_age')||
                        $errors->has('session_image')||
                        $errors->has('session_price')||
                        $errors->has('session_genres_id')||
                        $errors->has('session_show_date')||
                        $errors->has('session_amount'))
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Упс! Что-то пошло не так.') }}
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <div class="mt-4">
                            <x-label for="session_name" :value="__('Название *')" />
                            <x-input wire:model="session_name" class="block mt-1 w-full" type="text" name="session_name"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="session_age" :value="__('Возростное ограничение *')" />
                            <x-input wire:model="session_age" class="block mt-1 w-full" type="text" name="session_age"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="image" :value="__('Картинка *')" />
                            @if($session_image)
                            <img src="{{$session_image->temporaryUrl()}}" class="w-2/3 aspect-video rounded-lg my-2">
                            @endif
                            <x-input wire:model="session_image" class="block mt-1 w-full" type="file" name="image" />
                        </div>
                        <div class="mt-4">
                            <x-label for="price" :value="__('Цена *')" />
                            <x-input wire:model="session_price" class="block mt-1 w-full" type="text" name="price" />
                        </div>
                        <div class="mt-4">
                            <x-label for="genres_id" :value="__('Жанр *')" />
                            <select wire:model="session_genres_id">
                                <option value="null" hidden selected>Выберите жанр</option>
                                @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-label for="show_date" :value="__('Дата показа *')" />
                            <x-input wire:model="session_show_date" class="block mt-1 w-full" type="datetime-local" name="show_date" :value="old('show_date')" />
                        </div>
                        <div class="mt-4">
                            <x-label for="amount" :value="__('Количество билетов *')" />
                            <x-input wire:model="session_amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')" />
                        </div>
                        @if (session()->has('createdSession'))
                            <div class="text-green-500 text-md mt-2">
                                {{ session('createdSession') }}
                            </div>
                        @endif
                        <div class="w-full flex justify-start items-center">
                            <x-button wire:loading.attr="disabled" wire:target="session_image" class="flex justify-center items-center my-8 sm:w-2/5">Создать</x-button>
                        </div>
                    </form>
                </div>
                <div class="grid md:grid-cols-2 xl:grid-cols-3 grid-cols-1 gap-8 my-8">
                    @foreach($sessions as $i=>$session)
                    <div class="flex justify-between flex-col rounded-lg bg-gray-300/50 p-4 border shadow">
                        <div>
                        <div class="mt-4">
                            <x-label for="session_name" :value="__('Название')" />
                            <x-input wire:model="sessions.{{ $i }}.name" class="block mt-1 w-full" type="text" name="session_name"  />
                        </div>
                        <div class="mt-4">
                            <x-label for="session_age" :value="__('Возростное ограничение')" />                            
                            <x-input wire:model="sessions.{{ $i }}.age" class="block mt-1 w-full" type="text" name="session_age" />
                        </div>
                        <div class="mt-4">
                            <x-label for="image" :value="__('Картинка')" />
                            @if(isset($files[$session['id']]))
                            <img src="{{$files[$session['id']]->temporaryUrl()}}" class="aspect-video w-full rounded-md">
                            @else
                            <img class="aspect-video w-full rounded-md" src="{{sprintf('%s/storage/images/%s',route('about'),$sessions[$i]['image'])}}">
                            @endif
                            <x-input wire:model="files.{{$session['id']}}" class="block mt-1 w-full" type="file" name="image"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="price" :value="__('Цена')" />
                            <x-input wire:model="sessions.{{ $i }}.price" class="block mt-1 w-full" type="text" name="price" />
                        </div>
                        <div class="mt-4">
                            <x-label for="genres_id" :value="__('Жанр')" />
                            <select wire:model="sessions.{{ $i }}.genres_id">
                                @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-label for="show_date" :value="__('Дата показа')" />
                            <x-input wire:model="sessions.{{ $i }}.show_date" class="block mt-1 w-full" type="datetime-local" name="show_date" />
                        </div>
                        <div class="mt-4">
                            <x-label for="amount" :value="__('Количество билетов')" />
                            <x-input wire:model="sessions.{{ $i }}.amount" class="block mt-1 w-full" type="text" name="amount" />
                        </div>
                        @if($errors->has('sessions.'.$i.'.name')||
                        $errors->has('sessions.'.$i.'.age')||
                        $errors->has('files.'.$session['id'])||
                        $errors->has('sessions.'.$i.'.price')||
                        $errors->has('sessions.'.$i.'.genres_id')||
                        $errors->has('sessions.'.$i.'.show_date')||
                        $errors->has('sessions.'.$i.'.amount'))
                        <div class="my-4">
                            <div class="font-medium text-red-600">
                                {{ __('Упс! Что-то пошло не так.') }}
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session()->has($session['id']))
                            <div class="text-green-500 text-md mt-2">
                                {{ session($session['id']) }}
                            </div>
                        @endif
                        </div>
                        <div class="grid gap-2 mt-4">
                            <x-button wire:loading.attr="disabled" wire:target="files.{{$session['id']}}" class="justify-center" wire:click="updateSession({{$session['id']}})">Изменить сеанс</x-button>
                            <x-button class="justify-center" wire:click="deleteSession({{$session['id']}})">Удалить сеанс</x-button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>