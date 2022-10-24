@push('title', $title)
<div class="py-12" x-init="window.onload = function() {
    Livewire.on('scrollTop', () => {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    })
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-container title="{{ $title }}">
                <x-validation-alert />
                <form wire:submit.prevent="{{ $action }}">
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="first_name" value="Primer nombre:*" />
                            <x-jet-input id="first_name" type="text"
                                class="{{ $errors->has('state.first_name') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.first_name" />
                            <x-jet-input-error for="state.first_name" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="second_name" value="Segundo nombre:" />
                            <x-jet-input id="second_name" type="text"
                                class="{{ $errors->has('state.second_name') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.second_name" />
                            <x-jet-input-error for="state.second_name" />
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="first_surname" value="Primer apellido:*" />
                            <x-jet-input id="first_surname" type="text"
                                class="{{ $errors->has('state.first_surname') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.first_surname" />
                            <x-jet-input-error for="state.first_surname" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="second_surname" value="Segundo apellido:" />
                            <x-jet-input id="second_surname" type="text"
                                class="{{ $errors->has('state.second_surname') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.second_surname" />
                            <x-jet-input-error for="state.second_surname" />
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="email" value="Correo electrónico:*" />
                            <x-jet-input id="email" type="text"
                                class="{{ $errors->has('user_state.email') ? 'border-red-500' : '' }}"
                                wire:model.defer="user_state.email" />
                            <x-jet-input-error for="user_state.email" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="email_confirm" value="Confirme el correo electrónico:*" />
                            <x-jet-input id="email_confirm" type="text"
                                class="{{ $errors->has('email_confirm') ? 'border-red-500' : '' }}"
                                wire:model.defer="email_confirm" />
                            <x-jet-input-error for="email_confirm" />
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="name" value="Nombre de usuario:*" />
                            <x-jet-input id="name" type="text"
                                class="{{ $errors->has('user_state.name') ? 'border-red-500' : '' }}"
                                wire:model.defer="user_state.name" />
                            <x-jet-input-error for="user_state.name" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="second_email" value="Segundo correo electrónico:" />
                            <x-jet-input id="second_email" type="text"
                                class="{{ $errors->has('state.second_email') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.second_email" />
                            <x-jet-input-error for="state.second_email" />
                        </div>
                    </div>
                    @if ($action == "create")
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 mb-6 w-full group">
                                <x-jet-label for="password" value="Contraseña:*" />
                                <x-jet-input id="password" type="password"
                                    class="{{ $errors->has('password') ? 'border-red-500' : '' }}"
                                    wire:model.defer="password" />
                                <x-jet-input-error for="password" />
                            </div>
                            <div class="relative z-0 mb-6 w-full group">
                                <x-jet-label for="password_confirm" value="Confirme la contraseña:*" />
                                <x-jet-input id="password_confirm" type="password"
                                    class="{{ $errors->has('password_confirm') ? 'border-red-500' : '' }}"
                                    wire:model.defer="password_confirm" />
                                <x-jet-input-error for="password_confirm" />
                            </div>
                        </div>
                    @endif
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group" x-data="{ mask: '0000-0000' }" x-init="IMask($refs.cell, { mask })">
                            <x-jet-label for="cell_phone" value="Teléfono celular:*" />
                            <x-jet-input id="cell_phone" type="text"
                                class="{{ $errors->has('state.cell_phone') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.cell_phone" x-ref="cell"/>
                            <x-jet-input-error for="state.cell_phone" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group" x-data="{ mask: '0000-0000' }" x-init="IMask($refs.land, { mask })">
                            <x-jet-label for="landline" value="Teléfono fijo:" />
                            <x-jet-input id="landline" type="text"
                                class="{{ $errors->has('state.landline') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.landline" x-ref="land"/>
                            <x-jet-input-error for="state.landline" />
                        </div>
                    </div>
                    @if (auth()->user()->is_admin)
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 mb-6 w-full group">
                                <x-jet-label for="role" value="Rol:*" />
                                <select wire:model.defer="state.role"
                                    class="{{ $errors->has('state.role') ? 'border-red-500' : '' }}
                                    block w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm ">
                                    <option>-- Seleccione --</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Investigador">Investigador</option>
                                </select>
                                <x-jet-input-error for="state.role" />
                            </div>
                            <div class="relative z-0 mb-6 w-full group">
                                <x-jet-label for="country_id" value="País:*" />
                                <select wire:model.defer="state.country_id"
                                    class="{{ $errors->has('state.country_id') ? 'border-red-500' : '' }}
                                    block w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm ">
                                    <option>-- Seleccione --</option>
                                    @foreach ($countries as $key => $country)
                                        <option value="{{ $key }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                                <x-jet-input-error for="state.country_id" />
                            </div>
                        </div>
                    @endif
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="address" value="Dirección:" />
                            <textarea wire:model.defer="state.address" id="address" cols="2" class="{{ $errors->has('state.address') ? 'border-red-500' : '' }}
                                block w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm "></textarea>
                            <x-jet-input-error for="state.address" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="description" value="Titular/biografía:" />
                            <textarea wire:model.defer="state.description" id="description" cols="2" class="{{ $errors->has('state.description') ? 'border-red-500' : '' }}
                                block w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm "></textarea>
                            <x-jet-input-error for="state.description" />
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="workplace" value="Lugar de trabajo:" />
                            <x-jet-input id="workplace" type="text"
                                class="{{ $errors->has('state.workplace') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.workplace" />
                            <x-jet-input-error for="state.workplace" />
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <x-jet-label for="position" value="Cargo:" />
                            <x-jet-input id="position" type="text"
                                class="{{ $errors->has('state.position') ? 'border-red-500' : '' }}"
                                wire:model.defer="state.position" />
                            <x-jet-input-error for="state.position" />
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-full text-white bg-blue-500 hover:bg-blue-400 transition ease-in-out duration-150 "
                            wire:loading.disabled wire:target='{{ $action }}'
                            wire:loading.class='cursor-not-allowed'>
                            {{ $action == 'create' ? 'Crear' : 'Actualizar' }} usuario
                            <div wire:loading wire:target="{{ $action }}">
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
                        <a href="{{ route('user.index') }}"
                        class="inline-flex items-center ml-2 px-4 py-2 font-semibold leading-6 text-sm shadow rounded-full text-white bg-gray-500 hover:bg-gray-400 transition ease-in-out duration-150 ">Regresar</a>
                    </div>
                </form>
            </x-container>
        </div>
    </div>
</div>
