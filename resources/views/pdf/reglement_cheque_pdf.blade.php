<!DOCTYPE html>
<html>

<head>
      <title>{{ $reglements->cheque->number }} / {{ $reglements->date_reglement }}</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>

      <h1>{{ $title }}</h1>
      <p>{{ $date }}</p>
      <br />
      <br />

    <h2>Partenaire Information</h2>
    <p>Name: {{ $reglements->date_reglement }}</p>
    <!-- Add more partenaire information as needed -->

    <h2>Date de reglement: {{ $reglements->date_reglement }}</h2> 
    <br />
    <p>Cheque: {{$reglements->cheque->number }}</p>
    <br />
    <p>Nom de compte: {{ $reglements->compte->nom }}</p>
    <br />
    <p>Nom de Bénéficiaire: {{ $reglements->bene->nom }}</p>
    <br />
    <p>Nom de service: {{ $reglements->service->nom}}</p>
    <br />
    <p>Nom de Référance: {{ $reglements->referance }}</p>
    <br />
    <p>Nom de echeance: {{  $reglements->echeance }}</p>
    <br />
    <p>Nom de montant: {{ number_format($reglements->montant ?? 0.00)  }} Dh</p>
    <br/>
    <br/>
    <!-- <img src="{{ asset('public/reglement_cheque_images/' . $reglements->RelChequeImages[0]->images) }}" alt="Image" style="width: 50px; height: 50px; border: 1px solid #3498db; border-radius:50%;"> -->

</body>

</html>