<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden poke-card">
                    
                    <div class="bg-dark text-white p-3 border-bottom border-4 border-dark text-center">
                        <h2 class="mb-0 font-pixel text-warning" style="font-size: 18px;">ACERCA DEL EXAMEN</h2>
                    </div>

                    <div class="card-body bg-white p-5">
                        
                        <h3 class="fw-bold font-pixel text-danger mb-4" style="font-size: 14px;">EQUIPO DE DESARROLLO</h3>
                        <ul class="fs-5 mb-5 text-muted fw-bold">
                            <li>Robledo Zuñiga Josue Fernando</li>
                            <li>Cruz Hernandez Juan Carlos</li>
                        </ul>

                        <h3 class="fw-bold font-pixel text-danger mb-4" style="font-size: 14px;">OBJETIVO</h3>
                        <p class="fs-5 text-muted">
                            Construir una Pokédex Web funcional aplicando el patrón MVC en Laravel, integrando herramientas de desarrollo, estilos interactivos y consumiendo la PokéAPI para mostrar información de los Pokémon en tiempo real.
                        </p>

                        <div class="text-center mt-5">
                            <a href="{{ url('/pokemon') }}" class="btn btn-poke px-4 py-2 rounded-pill">
                                &larr; VOLVER
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>