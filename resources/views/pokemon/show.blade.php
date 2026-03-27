<x-app-layout>
    <div class="text-center py-5">
        <h1 class="display-4 text-capitalize fw-bold mb-4">{{ $name }}</h1>
        
        <div class="mb-5">
            <div class="bg-secondary text-white d-inline-flex justify-content-center align-items-center rounded shadow" style="width: 250px; height: 250px;">
                <span class="fs-5">Imagen Placeholder</span>
            </div>
        </div>

        <a href="{{ url('/pokemon') }}" class="btn btn-outline-danger btn-lg px-4 rounded-pill">
            &larr; Volver al listado
        </a>
    </div>
</x-app-layout>