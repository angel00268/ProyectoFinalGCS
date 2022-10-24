@push('title',"Tablero")
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-container title="Bienvenido {{ auth()->user()->is_admin ? 'Super Administrador': (auth()->user()->user_detail->role == 'Administrador' ? 'Administrador' : 'Investigador') }}">
                    <h6>Proyecto Final de Gestión de la Calidad de Software</h6>
                    <ul class="list-decimal">
                        <li>Angel Saravia</li>
                        <li>Edgar Retana</li>
                        <li>Erick Reyes</li>
                        <li>Mario Zelaya</li>
                    </ul>
                </x-container>
            </div>
        </div>
    </div>
</x-app-layout>
