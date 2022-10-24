@push('title', "Perfil - {$user->user_detail->fullName()}")
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-container title="Perfil del usuario {{ $user->user_detail->fullName() }}">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full">
                                    <tbody>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Usuario
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->name}}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Nombre completo
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->completeName()}}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Correo electrónico
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->email}}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Segundo correo electrónico
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->second_email?: '-'}}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Número de teléfono celular
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->cell_phone}}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Número de teléfono fijo
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->landline?: '-'}}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Rol
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->role}}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                País
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->country->name}}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Lugar de trabajo
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->workplace?:'-'}}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Cargo ocupado
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->position?: '-'}}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Dirección de domicilio
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->address?:'-'}}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th class="text-start px-6 py-4 whitespace-nowrap text-sm font-bolder text-gray-900">
                                                Titular/biografía
                                            </th>
                                            <td class="text-start text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$user->user_detail->description?: '-'}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($option == 1)
                    <div class="flex flex-row-reverse ...">
                        <a href="{{ route('user.index') }}"
                            class="inline-block px-6 py-2.5 bg-gray-500 text-white font-medium text-xs leading-tight  rounded-full shadow-md hover:bg-gray-600 hover:shadow-lg focus:bg-gray-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-lg transition duration-150 ease-in-out">Regresar</a>
                    </div>
                @endif
            </x-container>
        </div>
    </div>
</div>
