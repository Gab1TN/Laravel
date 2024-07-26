@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">{{ Auth::user()->name }}</h1>

        <!-- Section Mes annonces Favorites -->
        <div class="mt-5">
            <h2 class="text-secondary">Mes favoris</h2>
            
            @if ($favoris->count() > 0)
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($favoris as $favori)
                        <div class="col mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($favori->photos->isNotEmpty())
                                    <img src="{{ $favori->photos->first()->photo }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $favori->libelle }}">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <p class="text-white">Aucune photo disponible</p>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $favori->libelle }}</h5>
                                    <p class="card-text">Prix : {{ number_format($favori->prix, 2, ',', ' ') }} €</p>
                                    <p class="card-text">État : {{ $favori->etat }}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <a href="{{ route('annonce.show', ['id' => $favori->id]) }}" class="btn btn-outline-primary">Voir détails</a>
                                    <form action="{{ route('favoris.supprimer', ['bienImmoId' => $favori->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Retirer des favoris</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Vous n'avez pas encore de favoris.</p>
            @endif
        </div>
        
        <!-- Informations personnelles de l'utilisateur -->
        <div class="mt-5">
            <h2 class="text-secondary">Mes informations personnelles</h2>

            <form action="{{ route('moncompte.update', Auth::user()->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection
