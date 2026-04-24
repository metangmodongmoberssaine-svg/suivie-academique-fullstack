<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Filières</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h2 class="mb-4">Liste des Filières</h2>

    <!-- Bouton Ajouter -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        + Ajouter une Filière
    </button>

    <!-- Tableau -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Libellé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filieres as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>{{ $f->code_filiere }}</td>
                    <td>{{ $f->label_filiere }}</td>
                    <td>
                        <!-- Btn Modifier -->
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $f->id }}">
                                Modifier
                        </button>

                        <!-- Btn Supprimer -->
                        <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $f->id }}">
                                Supprimer
                        </button>
                    </td>
                </tr>

                <!-- Modal Modification -->
                <div class="modal fade" id="editModal{{ $f->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ url('/filieres/'.$f->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier la Filière</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <label>Code Filière</label>
                                    <input type="text" name="code_filiere" class="form-control" value="{{ $f->code_filiere }}">

                                    <label class="mt-2">Libellé</label>
                                    <input type="text" name="label_filiere" class="form-control" value="{{ $f->label_filiere }}">
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn btn-success">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Suppression -->
                <div class="modal fade" id="deleteModal{{ $f->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ url('/filieres/'.$f->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer une Filière</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Voulez-vous vraiment supprimer <b>{{ $f->label_filiere }}</b> ?
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn btn-danger">Supprimer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
