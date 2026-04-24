<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Filières</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Liste des Filières</h1>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Libellé</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($filieres as $filiere)
            <tr>
                <td>{{ $filiere->code_filiere }}</td>
                <td>{{ $filiere->label_filiere }}</td>
                <td>{{ $filiere->description_filiere }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
