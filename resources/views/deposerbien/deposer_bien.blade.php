@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2>Déposer un bien</h2>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('deposer_bien.store') }}">
                        @csrf

                        <!-- Champs du formulaire pour déposer un bien -->
                        <div class="form-group mb-3">
                            <label for="libelle" class="form-label">Titre du bien</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" value="{{ old('libelle') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="localisation" class="form-label">Localisation</label>
                            <input type="text" class="form-control" id="localisation" name="localisation" value="{{ old('localisation') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="m2" class="form-label">Surface (m²)</label>
                            <input type="number" step="0.01" class="form-control" id="m2" name="m2" value="{{ old('m2') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="type" class="form-label">Type de bien</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="Appartement">Appartement</option>
                                <option value="Maison">Maison</option>
                                <option value="Terrain">Terrain</option>
                                <option value="Commerce">Commerce</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="etat" class="form-label">État</label>
                            <select class="form-control" id="etat" name="etat" required>
                                <option value="neuf">Neuf</option>
                                <option value="renové">Rénové</option>
                                <option value="plateau">Plateau</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="{{ old('prix') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nb_chambres" class="form-label">Nombre de chambres</label>
                            <input type="number" class="form-control" id="nb_chambres" name="nb_chambres" value="{{ old('nb_chambres') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nb_salles_bain" class="form-label">Nombre de salles de bain</label>
                            <input type="number" class="form-control" id="nb_salles_bain" name="nb_salles_bain" value="{{ old('nb_salles_bain') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="parking" class="form-label">Parking</label>
                            <select class="form-control" id="parking" name="parking" required>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="garage" class="form-label">Garage</label>
                            <select class="form-control" id="garage" name="garage" required>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="terrain" class="form-label">Terrain</label>
                            <select class="form-control" id="terrain" name="terrain" required>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="ville" name="ville" value="{{ old('ville') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="code_postal" class="form-label">Code Postal</label>
                            <input type="number" class="form-control" id="code_postal" name="code_postal" value="{{ old('code_postal') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo_url" class="form-label">URL de la photo</label>
                            <input type="url" class="form-control" id="photo_url" name="photo_url" value="{{ old('photo_url') }}">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Déposer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
