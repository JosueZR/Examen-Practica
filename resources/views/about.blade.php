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

                        <h3 class="fw-bold font-pixel text-danger mb-4 mt-5" style="font-size: 14px;">TECNOLOGÍAS UTILIZADAS</h3>
                        
                        <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                            <div class="col">
                                <div class="p-3 border border-dark rounded bg-light shadow-sm h-100">
                                    <h6 class="font-pixel text-primary mb-3" style="font-size: 10px;">BACK-END</h6>
                                    <ul class="text-muted" style="font-size: 14px;">
                                        <li><strong>Laravel (PHP):</strong> Framework MVC.</li>
                                        <li><strong>Laravel Breeze:</strong> Sistema de Autenticación.</li>
                                        <li><strong>SQLite:</strong> Base de datos local (Modo Offline).</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3 border border-dark rounded bg-light shadow-sm h-100">
                                    <h6 class="font-pixel text-success mb-3" style="font-size: 10px;">FRONT-END</h6>
                                    <ul class="text-muted" style="font-size: 14px;">
                                        <li><strong>Bootstrap 5:</strong> Diseño responsivo y grid.</li>
                                        <li><strong>CSS3 & JS:</strong> Animaciones 3D y control de audio.</li>
                                        <li><strong>Google Fonts:</strong> Press Start 2P & Quicksand.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="p-3 border border-dark rounded bg-light shadow-sm">
                                    <h6 class="font-pixel text-warning mb-3" style="font-size: 10px; text-shadow: 1px 1px #000;">🔌 APIs Y RECURSOS</h6>
                                    <ul class="text-muted mb-0" style="font-size: 14px;">
                                        <li><strong>PokéAPI (pokeapi.co):</strong> Consumo de datos en tiempo real (JSON).</li>
                                        <li><strong>Sprites Repository:</strong> Arte oficial HD y gritos (.ogg) de los videojuegos.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

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