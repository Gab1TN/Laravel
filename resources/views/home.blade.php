@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Formulaire de recherche -->
            <div class="search-block bg-light p-4 rounded shadow-sm mt-4 mb-4">
                <form method="GET" action="{{ route('annonces.search') }}" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Rechercher des annonces" required>
                        <button class="btn btn-primary" type="submit">Rechercher</button>
                    </div>
                </form>
            </div>

            <!-- Filtres -->
            <div class="bg-light p-4 rounded shadow-sm mt-5">
                <h3 class="text-center">Filtres</h3>
                <form method="GET" action="{{ route('annonces.search') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="min_prix" class="form-label">Prix Min (€)</label>
                        <input type="number" class="form-control" id="min_prix" name="min_prix" placeholder="0" value="{{ request('min_prix') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="max_prix" class="form-label">Prix Max (€)</label>
                        <input type="number" class="form-control" id="max_prix" name="max_prix" placeholder="0" value="{{ request('max_prix') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="etat" class="form-label">État</label>
                        <select class="form-control" id="etat" name="etat">
                            <option value="">Tous</option>
                            <option value="neuf" {{ request('etat') == 'neuf' ? 'selected' : '' }}>Neuf</option>
                            <option value="renové" {{ request('etat') == 'renové' ? 'selected' : '' }}>Rénové</option>
                            <option value="plateau" {{ request('etat') == 'plateau' ? 'selected' : '' }}>Plateau</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="min_chambres" class="form-label">Nombre de chambres Min</label>
                        <input type="number" class="form-control" id="min_chambres" name="min_chambres" placeholder="0" value="{{ request('min_chambres') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="max_chambres" class="form-label">Nombre de chambres Max</label>
                        <input type="number" class="form-control" id="max_chambres" name="max_chambres" placeholder="0" value="{{ request('max_chambres') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville" value="{{ request('ville') }}">
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">Appliquer les filtres</button>
                </form>
            </div>

            <!-- Bloc des annonces -->
            <div class="annonces-block bg-light p-4 rounded shadow-sm mt-5">
                <h2 class="text-center text-uppercase text-secondary mb-4">Toutes les annonces</h2>
                @if($annonces->isEmpty())
                    <p class="text-center">Aucune annonce disponible pour le moment.</p>
                @else
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($annonces as $annonce)
                            <div class="col mb-4">
                                <div class="card h-100 shadow-sm border-light">
                                    @if($annonce->photos->isNotEmpty())
                                        <img src="{{ $annonce->photos->first()->photo }}" class="card-img-top" style="height: 300px; object-fit: cover;" alt="{{ $annonce->libelle }}">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 300px;">
                                            <p class="text-white">Aucune photo disponible</p>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>{{ $annonce->libelle }}</strong></h5>
                                        <p class="card-text"><strong>Ville:</strong> {{ $annonce->ville }}</p>
                                        <p class="card-text"><strong>Prix:</strong> {{ number_format($annonce->prix, 2, ',', ' ') }} €</p>
                                        <p class="card-text"><strong>État:</strong> {{ $annonce->etat }}</p>
                                        <p class="card-text"><strong>Surface:</strong> {{ $annonce->m2 }} m²</p>
                                        <p class="card-text"><strong>Chambres:</strong> {{ $annonce->nb_chambres }}</p>
                                        <p class="card-text"><strong>Salles de bain:</strong> {{ $annonce->nb_salles_bain }}</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <a href="{{ route('annonce.show', ['id' => $annonce->id]) }}" class="btn btn-outline-primary">Voir détails</a>
                                        @if(Auth::check() && Auth::user()->favoris->contains($annonce->id))
                                            <form action="{{ route('favoris.supprimer', ['bienImmoId' => $annonce->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Supprimer des favoris</button>
                                            </form>
                                        @else
                                            <form action="{{ route('favoris.ajouter', ['bienImmoId' => $annonce->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success">Ajouter aux favoris</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<footer class="mt-5 bg-dark text-white text-center p-4 footer-sticky">
    <p>2024 <a class="text-white" href="{{ url('/') }}">{{ config('app.name') }}</a> - Projet Laravel par Gabin - B3 IW</p>
</footer>
@endsection
