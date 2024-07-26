@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center py-4">
            <h2>Résultats de la Recherche</h2>
        </div>
        <div class="card-body">
            @if($annonces->isEmpty())
                <p class="text-center">Aucune annonce trouvée pour votre recherche.</p>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($annonces as $annonce)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($annonce->photos->isNotEmpty())
                                    <img src="{{ $annonce->photos->first()->photo }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $annonce->libelle }}">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <p class="text-white mb-0">Aucune photo disponible</p>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title"><strong>{{ $annonce->libelle }}</strong></h5>
                                    <p class="card-text">Lieu : <br><strong>{{ $annonce->ville }}</strong></p>
                                    <p class="card-text">Prix : <br><strong>{{ number_format($annonce->prix, 2, ',', ' ') }} €</strong></p>
                                    <p class="card-text">État : <br><strong>{{ $annonce->etat }}</strong></p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <a href="{{ route('annonce.show', ['id' => $annonce->id]) }}" class="btn btn-outline-primary">Voir détails</a>
                                    @auth
                                        @if(Auth::user()->favoris->contains($annonce->id))
                                            <form action="{{ route('favoris.supprimer', ['bienImmoId' => $annonce->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer des favoris</button>
                                            </form>
                                        @else
                                            <form action="{{ route('favoris.ajouter', ['bienImmoId' => $annonce->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm">Ajouter aux favoris</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
