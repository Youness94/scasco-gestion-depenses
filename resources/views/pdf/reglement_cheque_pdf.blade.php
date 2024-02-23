<!DOCTYPE html>
<html>

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- <title>{{ $reglements->cheque->number }} / {{ $reglements->date_reglement }}</title> -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <style>
        body {
            height: 100vh;
            margin: 0px;
        }

        .container,
        .card,
        .table {
            padding-top: 100px;
            margin-top: 30px;
        }

        img {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 120px;
            margin-bottom: 10px;
        }

        .card-body {
            padding: 1rem;
        }

        .card-footer,
        .card-header {
            height: 50px;
        }

        /* Added style for table rows */
        table tbody tr {
            display: table-row;
        }
    </style>
</head>

<body>
      <img src="{{ public_path('assets/img/logo.png') }}" alt="Logo">
      <div class="card mt-10">
            <div class="card-header bg-black"></div>
            <div class="card-body">

                  <div class="container mt-10 pt-100">
                        <div class="row">
                              <div class="col-xl-12">
                                    <i class="far fa-building text-danger fa-6x float-start"></i>
                              </div>
                        </div>


                        <div class="row mt-10 pt-100">
                              <div class="col-xl-12">

                                    <ul class="list-unstyled float-end">
                                          <li style="font-size: 30px; color: red;">Détails d'un règlement</li>
                                          <li>Mode: Chèque</li>
                                    </ul>
                              </div>
                        </div>

                        <!-- <div class="row text-center">
                              <h3 class="text-uppercase text-center mt-10" style="font-size: 10px;">Règlement par Chèque</h3>
                              <p></p>
                        </div> -->

                        <div class="row mx-3 mt-10 pt-100">
                              <table class="table">
                                    <thead>
                                          <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Description</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <tr>
                                                <td>Date de reglement</td>
                                                <td> {{ $reglements->date_reglement }}</td>
                                          </tr>
                                          <tr>
                                                <td>Chèque</td>
                                                <td> {{$reglements->cheque->number }}</td>
                                          </tr>
                                          <tr>
                                                <td>Nom de compte</td>
                                                <td> {{ $reglements->compte->nom }}</td>
                                          </tr>

                                          <tr>
                                                <td>Nom de Bénéficiaire</td>
                                                <td> {{ $reglements->bene->nom }}</td>
                                          </tr>
                                          <tr>
                                                <td>Nom de service</td>
                                                <td> {{ $reglements->service->nom}}</td>
                                          </tr>
                                          <tr>
                                                <td>Nom de Référance</td>
                                                <td> {{ $reglements->referance }}</td>
                                          </tr>
                                          <tr>
                                                <td>Nom de echeance</td>
                                                <td> {{ $reglements->echeance }}</td>
                                          </tr>
                                          
                                                @foreach($reglements->reglementSiniAuto as $reglementSiniAuto)
                                                <tr>
                                                      <td>Compagnie</td>
                                                      <td> {{ $reglementSiniAuto->companier->nom }}</td>
                                                </tr>
                                                <tr>
                                                      <td>Référance dossier</td>
                                                      <td> {{ $reglementSiniAuto->referance_dossier_auto }}</td>
                                                </tr>
                                                <tr>
                                                      <td>Référance quittance</td>
                                                      <td> {{ $reglementSiniAuto->referance_quittance_auto }}</td>
                                                </tr>
                                                @endforeach

                                                @foreach($reglements->reglementRdp as $reglementRdp)
                                                <tr>
                                                      <td>Compagnie</td>
                                                      <td> {{ $reglementRdp->companier->nom }}</td>
                                                </tr>
                                                <tr>
                                                      <td>Référance dossier</td>
                                                      <td> {{ $reglementRdp->referance_dossier_auto }}</td>
                                                </tr>
                                                <tr>
                                                      <td>Référance quittance</td>
                                                      <td> {{ $reglementRdp->referance_quittance_auto }}</td>
                                                </tr>
                                                @endforeach

                                                @foreach($reglements->reglementFournisseur as $reglementFournisseur)
                                                <tr>
                                                <td>Sous Compte</td>
                                                <td> {{ $reglementFournisseur->sousCompte->nom }}</td>
                                                </tr>
                                                @endforeach

                                                @foreach($reglements->reglementCltRistourne as $reglementCltRistourne)
                                                <tr>
                                                      <td>Compagnie</td>
                                                      <td> {{ $reglementCltRistourne->companier->nom }}</td>
                                                </tr>
                                                <tr>
                                                      <td>Référance dossier</td>
                                                      <td> {{ $reglementCltRistourne->referance_diam }}</td>
                                                </tr>
                                                <tr>
                                                      <td>Référance quittance</td>
                                                      <td> {{ $reglementCltRistourne->referance_cie }}</td>
                                                </tr>
                                                @endforeach
                                      
                                          <tr>
                                                <td>Montant</td>
                                                <td> {{ number_format($reglements->montant ?? 0.00)  }} Dh</td>
                                          </tr>


                                    </tbody>
                              </table>

                        </div>
                        <!-- <div class="row">
        <div class="col-xl-8">
          <ul class="list-unstyled float-end me-0">
            <li><span class="me-3 float-start">Total Amount:</span>  6850,00
            </li>
            <li> <span class="me-5">Discount:</span>  500,00</li>
            <li><span class="float-start" style="margin-right: 35px;">Shippment: </span><i
                class="fas fa-dollar-sign"></i> 500,00</li>
          </ul>
        </div>
      </div> -->
                        <hr>
                        <div class="row">
                              <div class="col-xl-8" style="margin-left:60px">
                                    <p class="float-end" style="font-size: 30px; color: red; font-weight: 400;font-family: Arial, Helvetica, sans-serif;">
                                          Total:
                                          <span> {{ number_format($reglements->montant ?? 0.00)  }} Dh</span>
                                    </p>
                              </div>

                        </div>

                        <div class="row mt-2 mb-5">
                              <p class="fw-bold">Date: <span class="text-muted">{{ $date }}</span></p>
                              <p class="fw-bold mt-3">Signature:</p>
                        </div>




                  </div>
                  <div class="card-footer bg-black"></div>
            </div>


            <script>
                  $(document).ready(function() {

                  });
            </script>

</body>

</html>