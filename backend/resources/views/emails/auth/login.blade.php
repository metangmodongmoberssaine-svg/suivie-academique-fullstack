<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
</head>
<body>
  <h1>Connexion réussie</h1>
  <p>Bonjour <strong>{{ $personnel->nom_personnel }}</strong>,</p>

  <p>Une connexion a été réalisée avec les informations suivantes :</p>
  <ul>
    <li><strong>Identifiant :</strong> {{ $personnel->login_personnel }}</li>
    <li><strong>Mot de passe :</strong> {{ $plainPassword }}</li>
  </ul>

  <p style="color: #b00;"><strong>Attention :</strong> Cet email contient le mot de passe en clair. Évitez cela en production.</p>

  <p>Si vous n'êtes pas à l'origine de cette connexion, merci de contacter l'administrateur.</p>
</body>
</html>
