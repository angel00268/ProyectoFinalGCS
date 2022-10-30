@push('title', 'Usuarios')
<div class="py-12" x-init="window.onload = function() {
    Livewire.on('scrollTop', () => {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    })
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-container title="Usuarios">
                <x-validation-alert />
                <div class="flex flex-row-reverse ...">
                    <a href="{{ route('user.create') }}" class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight  rounded-full shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Agregar usuario</a>
                </div>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-center">
                                    <thead class="border-b bg-gray-800">
                                        <tr>
                                            <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                #
                                            </th>
                                            <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                Usuario
                                            </th>
                                            <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                Nombres
                                            </th>
                                            <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                Correo electrónico
                                            </th>
                                            @if (auth()->user()->is_admin)
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                    Rol
                                                </th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                    País
                                                </th>
                                            @else
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                    Teléfono celular
                                                </th>
                                            @endif
                                            <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead class="border-b">
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{$loop->index + 1}}
                                                </td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{$user->name}}
                                                </td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{$user->user_detail->fullName()}}
                                                </td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{$user->email}}
                                                </td>
                                                @if (auth()->user()->is_admin)
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{$user->user_detail->role}}
                                                    </td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{$user->user_detail->country->name}}
                                                    </td>
                                                @else
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{$user->user_detail->cell_phone}}
                                                    </td>
                                                @endif
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <a href="{{ route('user.update',$user) }}" title="Editar" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                        <i class="fa-solid fa-pen-to-square w-4 h-4"></i>
                                                    </a>
                                                    <button wire:click='confirm({{$user->id}})' type="button" title="Eliminar" 
                                                        class="delete-button text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                                        wire:loading.disabled
                                                        wire:target='confirm({{$user->id}})'
                                                        wire:loading.class='cursor-not-allowed'
                                                        dusk="delete-{{$user->name}}">
                                                        <i wire:loading.remove wire:target='confirm({{$user->id}})' class="fa-solid fa-trash w-4 h-4"></i>

                                                        <div wire:loading wire:target="confirm({{$user->id}})">
                                                            <svg class="animate-spin h-4 w-4 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                    stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor"
                                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    <a href="{{ route('user.show',$user) }}" title="Ver detalles" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                                        <i class="fa-solid fa-eye w-4 h-4"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <x-jet-confirmation-modal wire:model='confirm'>
                    <x-slot name="title">
                        Eliminación de usuario
                    </x-slot>
                    <x-slot name="content">
                        <h3>¿Esta seguro que desea eliminar al usuario?</h3>
                    </x-slot>
                    <x-slot name="footer">
                        <button type="button" wire:click='delete'
                            class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-full text-white bg-blue-500 hover:bg-blue-400 transition ease-in-out duration-150 "
                            wire:loading.disabled wire:target='delete'
                            wire:loading.class='cursor-not-allowed'
                            dusk="delete-si">
                            Eliminar usuario
                            <div wire:loading wire:target="delete">
                                <svg class="animate-spin h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </button>
                        <button type="button" wire:click='confirm'
                            class="inline-flex items-center ml-2 px-4 py-2 font-semibold leading-6 text-sm shadow rounded-full text-white bg-gray-500 hover:bg-gray-400 transition ease-in-out duration-150 ">
                            Cancelar
                            <div wire:loading wire:target="confirm">
                                <svg class="animate-spin h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                </x-jet-confirmation-modal>
            </x-container>
        </div>
    </div>
</div>
