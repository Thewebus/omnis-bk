<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiche d'inscription</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;   
        }
        .container {
            padding: 50px;
        }
        .titre {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-top: 50px;
        }
        .text-small {
            font-size: 0.8rem;
        }
        .bloc-header {
            display: flex;
            justify-content: space-between; /* Espacer les éléments à l'intérieur */
            align-items: center; /* Centrer verticalement, si nécessaire */
        }
        .element-hearder {
            font-size: 0.9rem;
            width: 50%;
            text-align: center;
        }
        .rep {
            margin-left: 60%;
            margin-top: -150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bloc-header">
            <div class="element-hearder">
                MINISTERE DE L'ENSEIGNEMENT SUPERIEURE <br>
                ET DE LA RECHERCHE SCIENTIFIQUE <br>
                {{-- <img src="{{ asset('assets/images/logo/ministere_enseignement.png') }}" alt=""> --}}
                <img src="https://www.enseignement.gouv.ci/images/commun/logo.png" alt=""> <br>
                --------------------------------- <br>
                BP V 151 ABIDJAN / TEL : 20 33 54 64 FAX : 20 21 22 25
            </div>
            <div class="element-hearder rep">
                REPUBLIQUE DE CÔTE D'IVOIRE <br>
                Union - Discipline - Travail
            </div>
        </div>
        <div class="titre">
            <h2>FICHE DE PAIMENT</h2>
            DH012364DGSDG <br>
            ANNEE UNIERVERSITAIRE : {{ $anneeAcademique->debut }} - {{ $anneeAcademique->fin }}
        </div>
        <div class="rubrique mb-3">
            <h4>Identité</h4>
            <hr>
            <div class="row">
                <div class="col-md-8 text-small">
                    <table>
                        <tr>
                            <td><b>Numéro de dossier</b></td>
                            <td>: </td>
                            <td>N°1258DGRGGFDS</td>
                        </tr>
                        <tr>
                            <td><b>Identité permanent</b></td>
                            <td>: </td>
                            <td> N°1258DGRGGFDS</td>
                        </tr>
                        <tr>
                            <td><b>M. (Mme/Mlle)</b></td>
                            <td>: </td>
                            <td> {{ $etudiant->fullname }}</td>
                        </tr>
                        <tr>
                            <td><b>Date de naissance</b></td>
                            <td>: </td>
                            <td> {{ $etudiant->date_naissance->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><b>Lieu de naissance</b></td>
                            <td>: </td>
                            <td> {{ $etudiant->lieu_naissance }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="rubrique mb-3">
            <h4>Formation</h4>
            <hr>
            <div class="row">
                <div class="col-md-8 text-small">
                    <table>
                        <tr>
                            <td><b>Etablissement</b></td>
                            <td>:</td>
                            <td>Université de l'Atlantique - UA</td>
                        </tr>
                        <tr>
                            <td><b>Parcours</b></td>
                            <td>:</td>
                            <td>{{ $inscription->classe->nom }}</td>
                        </tr>
                        <tr>
                            <td><b>Niveau</b></td>
                            <td>:</td>
                            <td>{{ $inscription->classe->niveauFaculte->nom }}</td>
                        </tr>
                        <tr>
                            <td><b>Date d'inscription</b></td>
                            <td>:</td>
                            <td>{{ $inscription->created_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="rubrique mb-3">
            <h4>Informations Quittance</h4>
            <hr>
            <div class="row">
                <div class="col-md-8 text-small">
                    <table>
                        <tr>
                            <td><b>Montant à Payer</b></td>
                            <td>:</td>
                            <td>5 000</td>
                        </tr>
                        <tr>
                            <td><b>Date Paiement</b></td>
                            <td>:</td>
                            <td>20/20/20</td>
                        </tr>
                        <tr>
                            <td><b>Opérateur</b></td>
                            <td>:</td>
                            <td>MTN</td>
                        </tr>
                        <tr>
                            <td><b>Code de Paiement</b></td>
                            <td>:</td>
                            <td>ME20/20/2023</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Merci de Couper cette partie</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4"></div>
                <div class="row mb-5">
                    <div class="col-md-4">
                        ============================================================================
                    </div>
                </div>
            </div>
        </div>
        <div class="rubrique mb-3">
            <h4>Paramètre de connexion à votre espace</h4>
            <hr>
            <div class="row">
                <div class="col-md-12 text-small">
                    <b>NB :</b> Modifier votre mot de passse à votre première connexion <br>
                    <b>Mot De Passe :</b> <span class="ml-5">AZERTY1478523</span><br>
                    <p>
                        Vous avez droit à un espace étudiant, pour vous connecter à cet espace rendez-vous sur <b>www.inscriptionsup.net/espace/etudiant</b>  avec vos paramètre de connexion 
                        (Identifiant Permanent ANGA596481 et votre mot de passe <b>DIFH589641</b>) que vous pourrez changer une fois une fois connecté.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>