<!DOCTYPE html>
<html>

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- <title>{{ $reglements->effet->effet_number }} / {{ $reglements->date_reglement }}</title> -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <style>
            body {
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  height: 100vh;
                  margin: 0px;
                  padding-top: 100px;
            }

            .container {
                  /* margin: 0; */
                  padding-top: 100px;
            }

            img {
                  position: absolute;
                  top: 0;
                  left: 0;
                  width: 189px;
                  height: 100px;
            }
      </style>
</head>

<body>
      <img src="{{ public_path('assets/img/logo.png') }}" alt="Logo">
      <!-- <h1>{{ $title }}</h1>    -->

      <div class="container">
            <div class="table-responsive">
                  <table class="table table-bordered border-primary">
                        <tbody>
                              <tr>
                                    <th scope="row">Partenaire Information</th>
                                    <td>John Doe</td>
                              </tr>
                              <tr>
                                    <th scope="row">Date de reglement: </th>
                                    <td>{{ $reglements->date_reglement }}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Effet: </th>
                                    <td>{{$reglements->effet->effet_number }}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Nom de compte: </th>
                                    <td>{{ $reglements->effet_compte->nom }}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Nom de Bénéficiaire: </th>
                                    <td>{{ $reglements->bene->nom }}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Nom de service: </th>
                                    <td>{{ $reglements->service->nom}}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Nom de Référance: </th>
                                    <td>{{ $reglements->referance }}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Nom de echeance: </th>
                                    <td>{{ $reglements->echeance }}</td>
                              </tr>
                              <tr>
                                    <th scope="row">Nom de montant: </th>
                                    <td>{{ number_format($reglements->montant ?? 0.00)  }} Dh</td>
                              </tr>

                        </tbody>
                  </table>
                  <p>{{ $date }}</p>
            </div>
      </div>


</body>


</html>