<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Nouvelle filière</title>
</head>
<body>
  <h1>Nouvelle filière créée</h1>

  <p><strong>Code :</strong> {{ $filiere->code_filiere }}</p>
  <p><strong>Libellé :</strong> {{ $filiere->label_filiere }}</p>
  <p><strong>Description :</strong> {{ $filiere->description_filiere }}</p>

  <p>Cordialement,<br>Équipe Suivi Académique</p>
</body>
</html>
