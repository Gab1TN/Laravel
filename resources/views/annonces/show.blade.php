@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center py-4">
            <h2>{{ $annonce->libelle }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    @if($annonce->photos->isNotEmpty())
                    <div id="carouselExampleControls" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($annonce->photos as $photo)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ $photo->photo }}" class="d-block w-100" alt="{{ $annonce->libelle }}">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </a>
                    </div>
                    @else
                    <div class="text-center mt-4">
                        <p>Aucune photo disponible pour cette annonce.</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <p><strong>Prix :</strong> {{ number_format($annonce->prix, 2, ',', ' ') }} €</p>
                    <p><strong>État :</strong> {{ $annonce->etat }}</p>
                    <p><strong>Description :</strong> {{ $annonce->description }}</p>
                    <p><strong>Adresse :</strong> {{ $annonce->adresse }}, {{ $annonce->ville }} {{ $annonce->code_postal }}</p>
                    <p><strong>Surface (m²) :</strong> {{ $annonce->m2 }}</p>
                    <p><strong>Type :</strong> {{ $annonce->type }}</p>
                    <p><strong>Nombre de chambres :</strong> {{ $annonce->nb_chambres }}</p>
                    <p><strong>Nombre de salles de bain :</strong> {{ $annonce->nb_salles_bain }}</p>
                    <p><strong>Parking :</strong> {{ $annonce->parking }}</p>
                    <p><strong>Garage :</strong> {{ $annonce->garage }}</p>
                    <p><strong>Terrain :</strong> {{ $annonce->terrain }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#carouselExampleControls').carousel();
    });
</script>
@endsection
