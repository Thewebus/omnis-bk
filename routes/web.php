<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\institutController;
use App\Http\Controllers\ComptableController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EcheancierController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\SignataireController;
use App\Http\Controllers\CahierTexteController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\InformatiqueController;
use App\Http\Controllers\NiveauFaculteController;
use App\Http\Controllers\RattrapageNoteController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\PersonnelDefaultController;
use App\Http\Controllers\ProfesseurDefaultController;
use App\Http\Controllers\ScolariteScheduleController;
use App\Http\Controllers\UniteEnseignementController;
use App\Http\Controllers\PersonnelAuthenticationController;
use App\Http\Controllers\ProfesseurAuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [DefaultController::class, 'home'])->name('index');
Route::get('/test', [DefaultController::class, 'test'])->name('test')->middleware('auth');
Route::view('sample-page', 'admin.pages.sample-page')->name('sample-page');
Route::get('annee-academique/{annee_academique_id}', [DefaultController::class, 'setAnneeAcademique'])->name('admin.set-annee-academique');

Route::get('login-parent', [LoginController::class, 'parentLoginPage'])->name('login-parent-page');
Route::post('login-parent', [LoginController::class, 'loginParent'])->name('login-parent');

Route::group(['prefix' => 'etudiant', 'middleware' => ['auth', 'etudiant']], function() {
    Route::get('/', [EtudiantController::class, 'dashboard'])->name('user.dashboard-etudiant');
    Route::get('/profile', [EtudiantController::class, 'profile'])->name('user.profile');
    Route::get('/recepice', [EtudiantController::class, 'recepice'])->name('user.recepice');
    Route::get('/liste-matieres', [EtudiantController::class, 'listeMatiere'])->middleware('showNotes')->name('user.liste-matiere');
    // Route::get('/note/{matiere_id}', [EtudiantController::class, 'notes'])->name('user.notes');
    Route::get('download-echeancier', [EcheancierController::class, 'echeancierDownload'])->name('echeancier-download');
    Route::resource('echeancier', EcheancierController::class, ['as' => 'user']);
    Route::get('scolarite', [EtudiantController::class, 'scolarite'])->name('user.scolarite');
    Route::get('scolarite/download', [EtudiantController::class, 'scolaritePDF'])->name('user.scolarite-pdf');
    Route::get('emploi-du-temps', [EtudiantController::class, 'schedule'])->name('user.schedule');
    Route::get('/incription-old', [EtudiantController::class, 'inscriptionOld'])->name('user.inscription-old');
    // Route::post('/incription', [EtudiantController::class, 'storeInscription'])->name('user.post-inscription');
    Route::post('/change-password', [EtudiantController::class, 'changePassword'])->name('user.change-password');
    Route::resource('reclamations', ReclamationController::class, ['as' => 'user']);
    Route::get('chat-app', [EtudiantController::class, 'chat'])->name('user.chat-app');
});

Route::group(['prefix' => 'etudiant/incription', 'middleware' => ['auth', 'etudiant']], function() {
    Route::get('/', [EtudiantController::class, 'inscription'])->name('user.inscription');
    Route::post('/', [EtudiantController::class, 'storeInscription'])->name('user.store-inscription');
    Route::get('/fiche-inscription', [EtudiantController::class, 'ficheInscription'])->name('user.fiche-inscription');
    Route::get('/modification-inscription', [EtudiantController::class, 'ModifFicheInscription'])->name('user.modif-fiche-inscription');
    Route::post('/modification-inscription', [EtudiantController::class, 'updateInscription'])->name('user.update-inscription');
    // Route::get('/resultat-test', [EtudiantController::class, 'resultatTest'])->name('user.resultat-test');
});

Route::group(['prefix' => 'etudiant/ressources', 'middleware' => ['auth', 'etudiant']], function() {
    Route::get('/', [EtudiantController::class, 'ressourcesIndex'])->name('user.ressource-index');
    Route::get('/show/{mateire_id}', [EtudiantController::class, 'ressourceShow'])->name('user.ressource-show');
});

Route::group(['prefix' => 'personnel'], function() {
    Route::get('login', [PersonnelAuthenticationController::class, 'signIn'])->name('admin.login');
    Route::post('login', [PersonnelAuthenticationController::class, 'authenticate'])->name('admin.signin-post');
});

Route::group(['prefix' => 'informaticien', 'middleware' => ['auth:admins', 'informaticien']], function() {
    Route::get('/', [InformatiqueController::class, 'informatiqueDash'])->name('admin.dashboard-informatique');
    Route::get('/profil', [InformatiqueController::class, 'profil'])->name('admin.profil-informaticien');
    Route::post('/information-post', [InformatiqueController::class, 'changeInformationsPost'])->name('admin.informaticien-change-informations-post');
    Route::post('/change-password', [InformatiqueController::class, 'changePassword'])->name('admin.informaticien-change-password');
    Route::resource('niveau-faculte', NiveauFaculteController::class, ['as' => 'admin'])->only('store', 'update', 'destroy');
    Route::post('/logout', [PersonnelAuthenticationController::class, 'logout'])->name('admin.logout');
    Route::resource('services', ServiceController::class, ['as' => 'admin']);
    Route::resource('personnels', PersonnelController::class, ['as' => 'admin']);
    Route::get('professeur-liste-pdf', [ProfesseurController::class, 'indexDownload'])->name('admin.professeur-liste-pdf');
    Route::resource('professeurs', ProfesseurController::class, ['as' => 'admin']);
    Route::resource('institut', institutController::class, ['as' => 'admin']);
    Route::resource('unite-enseignement', UniteEnseignementController::class, ['as' => 'admin']);
    Route::get('liste-etudiants', [InformatiqueController::class, 'listEtudiants'])->name('admin.liste-etudiants');
    Route::get('emploi-du-temps/maquette/{classe_id}', [CoursController::class, 'maquette'])->name('admin.emploi-du-temps.maquette');
    Route::get('emploi-du-temps/classe/create/{classe_id}', [CoursController::class, 'create'])->name('admin.emploi-du-temps.create');
    Route::post('emploi-du-temps/classe/create', [CoursController::class, 'store'])->name('admin.emploi-du-temps.store');
    Route::get('emploi-du-temps/classe', [CoursController::class, 'index'])->name('admin.emploi-du-temps.index');
    Route::get('emploi-du-temps/cours/{classe_id}', [CoursController::class, 'indexCours'])->name('admin.emploi-du-temps.index-cours');
    Route::put('emploi-du-temps/cours/{classe_id}', [CoursController::class, 'update'])->name('admin.emploi-du-temps.update');
    Route::delete('emploi-du-temps/cours/{classe_id}', [CoursController::class, 'destroy'])->name('admin.emploi-du-temps.destroy');
    Route::get('import-matiere', [MatiereController::class, 'importMatiere'])->name('admin.import-matiere');
    Route::post('import-matiere', [MatiereController::class, 'StoreimportedMatiere'])->name('admin.store-import-matiere');
    Route::resource('matiere', MatiereController::class, ['as' => 'admin']);

    Route::get('liste-classe-pv/{semestre}', [InformatiqueController::class, 'listeClassesPV'])->name('admin.liste-classe-pv');
    Route::post('pv/{classe_id}', [InformatiqueController::class, 'pv'])->name('admin.pv');
    Route::post('pv-download/{classe_id}', [InformatiqueController::class, 'downloadPV'])->name('admin.pv-download');
    Route::post('pv-download-word/{classe_id}', [InformatiqueController::class, 'pvWord'])->name('admin.pv-word-download');
    
    Route::get('liste-classe-butlletin/{session}', [InformatiqueController::class, 'listeClassesBulletin'])->name('admin.liste-classe-bulletins');
    Route::get('liste-classe-butlletin-bts/{session}', [InformatiqueController::class, 'listeClasseBulletinBTS'])->name('admin.liste-classe-bulletins-bts');
    Route::post('butlletin/{classe_id}', [InformatiqueController::class, 'bulletin'])->name('admin.bulletins');
    Route::post('butlletin-bts/{classe_id}', [InformatiqueController::class, 'bulletin'])->name('admin.bulletins-bts');
    Route::post('bulletin-etudiant/{etudiant_id}', [InformatiqueController::class, 'oneBulletinDownload'])->name('admin.one-bulletin-download');
    Route::post('bulletin-classe/{classe_id}', [InformatiqueController::class, 'allBulletinDownload'])->name('admin.all-bulletin-download');

    Route::get('etudiant-export', [InformatiqueController::class, 'export'])->name('admin.etudiant-export');
    Route::get('etudiant-import', [InformatiqueController::class, 'import'])->name('admin.etudiant-import');
    Route::post('etudiant-import', [InformatiqueController::class, 'postImport'])->name('admin.etudiant-postImport');
    Route::delete('suppression-etudiant/{etudiant_id}', [InformatiqueController::class, 'suppressionEtudiant'])->name('admin.etudiant-suppression');

    Route::get('/recalcul-notes', [InformatiqueController::class, 'noteRecalculate'])->name('admin.recalcule-note');
    Route::get('/deliberation', [InformatiqueController::class, 'deliberation'])->name('admin.deliberation');

    Route::group(['prefix' => 'session-2'], function() {
        Route::get('/deliberation-session-2', [InformatiqueController::class, 'deliberationSession2'])->name('admin.deliberation-sesson2');
        Route::get('nouvelles-notes', [InformatiqueController::class, 'secondSession'])->name('admin.sesson-2-nouvelles-note');
        Route::get('notes', [InformatiqueController::class, 'listNoteSecondSession'])->name('admin.session-2-note');
        Route::get('notes-modification', [InformatiqueController::class, 'modifNoteSession2'])->name('admin.session-2-note-modification');
    });

    Route::get('/session-2', [InformatiqueController::class, 'secondSession'])->name('admin.sesson-2');

    Route::get('pure-notes', [InformatiqueController::class, 'pureNotes']);
    Route::get('add-noteSelectionnee', [InformatiqueController::class, 'addNoteSelectionnee']);
    Route::get('transfert-classeid-to-inscription', [InformatiqueController::class, 'transfereClasseIdInInscription']);
    Route::get('create-identifiant-bulletin', [InformatiqueController::class, 'createIdentifiantBulletin']);

    // Route::get('statistiques', [InformatiqueController::class, 'statistiques'])->name('admin.statistiques');

    Route::group(['prefix' => 'statistiques'], function() {
        // Route::get('session', [InformatiqueController::class, 'statistiquesSession'])->name('admin.statistiques-session');
        Route::get('facultes', [InformatiqueController::class, 'satistiqueFaculteListe'])->name('admin.statisques-facultes');
        Route::post('statistiques', [InformatiqueController::class, 'statistiquePost'])->name('admin.statisques-facultes-post');
    });
    Route::post('notes-show', [InformatiqueController::class, 'showNotes'])->name('admin.show-notes');

    Route::group(['prefix' => 'rattrapage'], function() {
        Route::get('list', [RattrapageNoteController::class, 'index'])->name('admin.rattrapage.index');
        Route::get('modification/{rattrage_id}', [RattrapageNoteController::class, 'modifNote'])->name('admin.rattrapage.modification');
        Route::post('modification/{rattrage_id}', [RattrapageNoteController::class, 'postModifNote'])->name('admin.rattrapage.post-modification');
        Route::post('suppression/{rattrage_id}', [RattrapageNoteController::class, 'destroy'])->name('admin.rattrapage.suppression-rattrapage');
        Route::get('inscrit', [RattrapageNoteController::class, 'inscrit'])->name('admin.rattrapage.inscrit');
        Route::post('inscrit', [RattrapageNoteController::class, 'storeInscrit'])->name('admin.rattrapage.store-inscrit');
        Route::get('non-inscrit', [RattrapageNoteController::class, 'nonInscrit'])->name('admin.rattrapage.non-inscrit');
        Route::post('non-inscrit', [RattrapageNoteController::class, 'storeNonInscrit'])->name('admin.rattrapage.store-non-inscrit');
    });

    Route::resource('signataires', SignataireController::class, ['as' => 'admin']);
    Route::get('attestation-admission', [InformatiqueController::class, 'attestationAdmission'])->name('admin.attestation-admission');
    Route::post('attestation-admission-pdf', [InformatiqueController::class, 'attestationAdmissionPdf'])->name('admin.attestation-admission-pdf');
});

Route::group(['prefix' => 'informaticien/notes', 'middleware' => ['auth:admins', 'informaticien']], function() {
    Route::get('liste-classe', [InformatiqueController::class, 'listeClassesNotes'])->name('admin.liste-classes-notes');
    Route::get('liste-matieres/{classe_id}', [InformatiqueController::class, 'listeMatiereNote'])->name('admin.liste-matiere-notes');
    Route::get('liste-notes/{matiere_id}', [InformatiqueController::class, 'notesMatiere'])->name('admin.notes-matiere');
    Route::get('liste-etudiant-session-2/{matiere_id}', [InformatiqueController::class, 'listeEtudiantSession2'])->name('admin.liste-etudiant-session-2');
    
    Route::get('/liste-note/{inscription_id}', [InformatiqueController::class, 'listeMatiere'])->name('admin.liste-note-etudiant');
    
    // Route::get('/notes-partiel/{matiere_id}', [InformatiqueController::class, 'addPartiel'])->name('admin.notes-partiel');
    // Route::post('/notes-partiel/{matiere_id}', [InformatiqueController::class, 'postPartiel'])->name('admin.post-notes-partiel');
    Route::post('/notes-session-2/{matiere_id}', [InformatiqueController::class, 'postSession2'])->name('admin.notes-session-2');

    Route::get('/nouvelles-notes/{matiere_id}', [InformatiqueController::class, 'addNote'])->name('admin.add-notes');
    Route::post('/nouvelles-notes/{matiere_id}', [InformatiqueController::class, 'postNote'])->name('admin.post-notes');
    Route::delete('/suppression-notes/{matiere_id}', [InformatiqueController::class, 'suppressionNotes'])->name('admin.suppression-notes');
    Route::post('/partiels/{classe_id}', [InformatiqueController::class, 'postPartiel'])->name('admin.post-partiels');
});

Route::group(['prefix' => 'informaticien/professeurs', 'middleware' => ['auth:admins', 'informaticien']], function() {
    Route::post('valide-enregistrement/{professeur_id}', [ProfesseurController::class, 'valideEnregistrement'])->name('admin.valide-enregistrement');
    Route::post('refus-enregistrement/{professeur_id}', [ProfesseurController::class, 'refusEnregistrement'])->name('admin.refus-enregistrement');
});

Route::group(['prefix' => 'informaticien/inscription', 'middleware' => ['auth:admins', 'informaticien']], function() {
    Route::get('/nouvelles-inscriptions', [InformatiqueController::class, 'inscriptionEtudiant'])->name('admin.inscription-etudiant');
    Route::post('/nouvelles-inscriptions', [InformatiqueController::class, 'inscriptionEtudiantPost'])->name('admin.inscription-etudiant-post');
    Route::get('/inscriptions-etudiant-existant', [InformatiqueController::class, 'inscriptionEtudiantExistant'])->name('admin.inscription-etudiant-existant');
    Route::post('/inscriptions-etudiant-existant', [InformatiqueController::class, 'postInscriptionEtudiantExistant'])->name('admin.inscription-etudiant-existant-post');
    Route::get('/inscriptions-validees', [InformatiqueController::class, 'inscriptionValideeListeEtudiant'])->name('admin.inscription-validee-liste-etudiant');
    Route::get('/etudiant/{etudiant_id}', [InformatiqueController::class, 'inscriptionDetails'])->name('admin.inscritpion-detail');
    Route::get('/fiche/{inscription_id}', [InformatiqueController::class, 'ficheInscriptionPdf'])->name('admin.inscritpion-fiche-pdf');
    Route::get('/modification/{etudiant_id}', [InformatiqueController::class, 'modifInscriptionForm'])->name('admin.inscritpion-modif-form');
    Route::post('/modification/{etudiant_id}', [InformatiqueController::class, 'modifInscriptionFormPost'])->name('admin.inscritpion-modif-form-post');
});

Route::group(['prefix' => 'informaticien/affectations', 'middleware' => ['auth:admins', 'informaticien']], function() {
    Route::get('affectation-etudiant', [InformatiqueController::class, 'affectationEtudiant'])->name('admin.affectation-edutiant');
    Route::post('affectation-etudiant/', [InformatiqueController::class, 'postaffectationEtudiant'])->name('admin.post-affectation-etudiant');
    Route::get('affectation-liste-professeur', [InformatiqueController::class, 'affectationListeProf'])->name('admin.affectation-liste-professeur');
    Route::get('affectation-professeur/{professeur_id}', [InformatiqueController::class, 'affectationProf'])->name('admin.affectation-professeur');
    Route::post('affectation-professeur/{professeur_id}', [InformatiqueController::class, 'postaffectationProfesseur'])->name('admin.post-affectation-professeur');
});

Route::group(['prefix' => 'scolarite', 'middleware' => ['auth:admins', 'scolarite']], function() {
    Route::get('/', [PersonnelDefaultController::class, 'personnelDash'])->name('admin.dashboard');
    Route::get('/profil', [PersonnelDefaultController::class, 'profil'])->name('admin.personnel-profil');
    Route::post('/information-post', [PersonnelDefaultController::class, 'changeInformationsPost'])->name('admin.personnel-change-informations-post');
    Route::post('/change-password', [PersonnelDefaultController::class, 'changePassword'])->name('admin.personnel-change-password');
    Route::post('/logout', [PersonnelAuthenticationController::class, 'logout'])->name('admin.logout');

    Route::get('liste-classe-etudiants/{classe_id}', [PersonnelDefaultController::class, 'listClasseEtudiants'])->name('admin.scolarite-liste-classe-etudiants');

    Route::get('liste-classe-pv/{semestre}', [PersonnelDefaultController::class, 'listeClassesPV'])->name('admin.scolarite-liste-classe-pv');
    Route::post('pv/{classe_id}', [PersonnelDefaultController::class, 'pv'])->name('admin.scolarite-pv');

    Route::get('emploi-du-temps/maquette/{classe_id}', [ScolariteScheduleController::class, 'maquette'])->name('admin.scolarite.emploi-du-temps.maquette');
    Route::get('emploi-du-temps/classe/create/{classe_id}', [ScolariteScheduleController::class, 'create'])->name('admin.scolarite.emploi-du-temps.create');
    Route::post('emploi-du-temps/classe/create', [ScolariteScheduleController::class, 'store'])->name('admin.scolarite.emploi-du-temps.store');
    Route::get('emploi-du-temps/classe', [ScolariteScheduleController::class, 'index'])->name('admin.scolarite.emploi-du-temps.index');
    Route::get('emploi-du-temps/cours/{classe_id}', [ScolariteScheduleController::class, 'indexCours'])->name('admin.scolarite.emploi-du-temps.index-cours');
    Route::put('emploi-du-temps/cours/{classe_id}', [ScolariteScheduleController::class, 'update'])->name('admin.scolarite.emploi-du-temps.update');
    Route::delete('emploi-du-temps/cours/{classe_id}', [ScolariteScheduleController::class, 'destroy'])->name('admin.scolarite.emploi-du-temps.destroy');

    Route::resource('annee-academique', AnneeAcademiqueController::class, ['as' => 'admin']);
    Route::get('liste-professeur', [PersonnelDefaultController::class, 'professeurListe'])->name('admin.professeurs-liste');
    Route::get('professeur-details/{professeur_id}', [PersonnelDefaultController::class, 'professeurDetails'])->name('admin.professeur-details');
});

Route::group(['prefix' => 'scolarite/notes', 'middleware' => ['auth:admins', 'scolarite']], function() {
    Route::get('liste-classe', [PersonnelDefaultController::class, 'listeClassesNotes'])->name('admin.scolarite-liste-classes-notes');
    Route::get('liste-matieres/{classe_id}', [PersonnelDefaultController::class, 'listeMatiereNote'])->name('admin.scolarite-liste-matiere-notes');
    Route::get('liste-notes/{matiere_id}', [PersonnelDefaultController::class, 'notesMatiere'])->name('admin.scolarite-notes-matiere');

    Route::get('/nouvelles-notes/{matiere_id}', [PersonnelDefaultController::class, 'addNote'])->name('admin.scolarite-add-notes');
    Route::post('/nouvelles-notes/{matiere_id}', [PersonnelDefaultController::class, 'postNote'])->name('admin.scolarite-post-notes');
    Route::post('/partiels/{classe_id}', [PersonnelDefaultController::class, 'postPartiel'])->name('admin.scolarite-post-partiels');

    Route::get('/notes-partiel/{matiere_id}', [PersonnelDefaultController::class, 'addPartiel'])->name('admin.scolarite-notes-partiel');
    Route::post('/notes-partiel/{matiere_id}', [PersonnelDefaultController::class, 'postPartiel'])->name('admin.scolarite-post-notes-partiel');

    Route::delete('/suppression-notes/{matiere_id}', [PersonnelDefaultController::class, 'suppressionNotes'])->name('admin.scolarite-suppression-notes');
});

Route::group(['prefix' => 'scolarite/inscription', 'middleware' => ['auth:admins', 'scolarite']], function() {
    Route::get('/nouvelles-inscriptions', [PersonnelDefaultController::class, 'inscriptionEtudiant'])->name('admin.scolarite-inscription-etudiant');
    Route::post('/nouvelles-inscriptions', [PersonnelDefaultController::class, 'inscriptionEtudiantPost'])->name('admin.scolarite-inscription-etudiant-post');
    Route::get('/inscriptions-validees', [PersonnelDefaultController::class, 'inscriptionValideeListeEtudiant'])->name('admin.scolarite-inscription-validee-liste-etudiant');
    Route::get('/etudiant/{etudiant_id}', [PersonnelDefaultController::class, 'inscriptionDetails'])->name('admin.scolarite-inscritpion-detail');
    Route::get('/modification/{etudiant_id}', [PersonnelDefaultController::class, 'modifInscriptionForm'])->name('admin.scolarite-inscritpion-modif-form');
    Route::post('/modification/{etudiant_id}', [PersonnelDefaultController::class, 'modifInscriptionFormPost'])->name('admin.scolarite-inscritpion-modif-form-post');
});

Route::group(['prefix' => 'scolarite/affectations', 'middleware' => ['auth:admins', 'scolarite']], function() {
    Route::get('affectation-etudiant', [PersonnelDefaultController::class, 'affectationEtudiant'])->name('admin.scolarite.affectation-edutiant');
    Route::post('affectation-etudiant/', [PersonnelDefaultController::class, 'postaffectationEtudiant'])->name('admin.scolarite.post-affectation-etudiant');
    Route::get('affectation-liste-professeur', [PersonnelDefaultController::class, 'affectationListeProf'])->name('admin.scolarite.affectation-liste-professeur');
    Route::get('affectation-professeur/{professeur_id}', [PersonnelDefaultController::class, 'affectationProf'])->name('admin.scolarite.affectation-professeur');
    Route::post('affectation-professeur/{professeur_id}', [PersonnelDefaultController::class, 'postaffectationProfesseur'])->name('admin.scolarite.post-affectation-professeur');
});

// Route::group(['prefix' => 'scolarite/resultats', 'middleware' => ['auth:admins']], function() {
//     Route::get('/nouveaux-resultats', [PersonnelDefaultController::class, 'listEtudiants'])->name('admin.nouveaux-resultats');
//     Route::get('/resultats', [PersonnelDefaultController::class, 'resultats'])->name('admin.resultats');
//     Route::get('/nouvelles-notes/{etudiant_id}', [PersonnelDefaultController::class, 'nouvellesNotes'])->name('admin.nouvelles-notes');
//     Route::post('/nouvelles-notes/{etudiant_id}', [PersonnelDefaultController::class, 'insertionNotes'])->name('admin.insertion-notes');
// });

Route::group(['prefix' => 'scolarite/cahier-text', 'middleware' => ['auth:admins', 'scolarite']], function() {
    Route::get('/', [PersonnelDefaultController::class, 'cahierTexteClasse'])->name('admin.cahier-text');
    Route::get('/{classe_id}', [PersonnelDefaultController::class, 'cahierTexte'])->name('admin.cahier-text.show');
});

Route::group(['prefix' => 'comptable', 'middleware' => ['auth:admins', 'comptable']], function() {
    Route::get('/', [ComptableController::class, 'dashboard'])->name('admin.dashboard-comptable');
    Route::get('/details-scolarite-classe', [ComptableController::class, 'detailsTotalScolarite'])->name('admin.details-scolarite-classe');
    Route::get('/details-scolarite-payee-classe', [ComptableController::class, 'detailsScolaritePaye'])->name('admin.details-scolarite-payee-classe');
    Route::get('/details-scolarite-restante-classe', [ComptableController::class, 'detailsScolariteRestante'])->name('admin.details-scolarite-restante-classe');

    Route::get('/profil', [ComptableController::class, 'profil'])->name('admin.comptable-profil');
    Route::post('/information-post', [ComptableController::class, 'changeInformationsPost'])->name('admin.comptable-change-informations-post');
    Route::post('/change-password', [ComptableController::class, 'changePassword'])->name('admin.comptable-change-password');

    Route::get('/liste-etudiant-scolarite', [ComptableController::class, 'listeEtudiantScolarite'])->name('admin.liste-etudiant-scolarite');
    Route::get('/scolarite/{etudiant_id}', [ComptableController::class, 'etudiantScolarite'])->name('admin.etudiant-scolarite');
    Route::post('/scolarite/{etudiant_id}', [ComptableController::class, 'postScolarite'])->name('admin.post-scolarite');
    Route::get('/recu-scolarite', [ComptableController::class, 'recuScolarite'])->name('admin.recu-scolarite');

    Route::get('/attestation-inscription/{etudiant_id}', [ComptableController::class, 'attestionInscription'])->name('admin.attestation-inscription');
    Route::get('/dossier-individuel/{etudiant_id}', [ComptableController::class, 'dossierIndividuel'])->name('admin.dossier-individuel');

    Route::get('/liste-etudiant-inscription', [ComptableController::class, 'listeEtudiantInscription'])->name('admin.liste-etudiant-inscription');
    Route::get('/inscription/{inscription_id}', [ComptableController::class, 'etudiantInscription'])->name('admin.etudiant-inscription');
    Route::post('/inscription/{inscription_id}', [ComptableController::class, 'etudiantInscriptionPost'])->name('admin.etudiant-inscription-post');
    
    Route::post('/valider-inscription/{inscription_id}', [ComptableController::class, 'validerInscription'])->name('admin.valider-inscription');
    Route::post('/refuser-inscription/{inscription_id}', [ComptableController::class, 'refusInscription'])->name('admin.refuser-inscription');

    Route::get('/liste-etudiant', [ComptableController::class, 'listeEtudiants'])->name('admin.liste-etudiant-echeancier');
    Route::get('/echeancier/{etudiant_id}', [ComptableController::class, 'echeancier'])->name('admin.etudiant-echeancier');
    Route::post('/valide-echeancier/{echeancier_id}', [ComptableController::class, 'valideEcheancier'])->name('admin.valide-echeancier');
    Route::post('/refus-echeancier/{echeancier_id}', [ComptableController::class, 'refusEcheancier'])->name('admin.refus-echeancier');
    Route::get('/modifier-echeancier/{etudaint_id}', [ComptableController::class, 'modifierEcheancier'])->name('admin.modifier-echeancier');
    Route::post('/modifier-echeancier/{etudaint_id}', [ComptableController::class, 'postModifierEcheancier'])->name('admin.post-modifier-echeancier');
    Route::get('fiche-vacation', [ComptableController::class, 'vacation'])->name('admin.fiche-vacation');
});

Route::group(['prefix' => 'comptable/professeurs', 'middleware' => ['auth:admins', 'comptable']], function() {
    Route::get('/', [ComptableController::class, 'professeurs'])->name('admin.comptable-liste-professeurs');
    Route::get('/details/{professeur_id}', [ComptableController::class, 'detailsProfesseur'])->name('admin.comptable-details-professeurs');
    Route::post('/details/{professeur_id}', [ComptableController::class, 'tauxHoraireProfesseur'])->name('admin.comptable-post-taux-horaire');

    Route::get('/liste', [ComptableController::class, 'listeProfesseurRecu'])->name('admin.liste-professeur-recu');
    Route::get('/liste-recu/{professeur_id}', [ComptableController::class, 'listeRecu'])->name('admin.liste-recu');
    Route::post('/paiement/{professeur_id}', [ComptableController::class, 'paiementProfesseurPost'])->name('admin.paiement-professeur-post');
    Route::get('/recu-pdf/{paiement_id}', [ComptableController::class, 'professeurRecuPdf'])->name('admin.professeur-recu-pdf');
});

Route::group(['prefix' => 'professeur'], function() {
    Route::get('login', [ProfesseurAuthenticationController::class, 'signIn'])->name('prof.login');
    Route::post('login', [ProfesseurAuthenticationController::class, 'authenticate'])->name('prof.signin-post');
});

Route::group(['prefix' => 'professeur/', 'middleware' => ['auth:profs', 'professeur']], function() {
    Route::get('/', [ProfesseurDefaultController::class, 'profDashboard'])->name('prof.dashboard');
    Route::get('/classe-liste-presence/{classe_id}', [ProfesseurDefaultController::class, 'classeDetailsPresence'])->name('prof.classe-details-presence');
    Route::get('/liste-presence/{matiere_id}', [ProfesseurDefaultController::class, 'listePresence'])->name('prof.liste-presence');
    Route::get('/classe-liste-presence-consultation/{matiere_id}', [ProfesseurDefaultController::class, 'classeDetailsPresenceConsultation'])->name('prof.classe-details-presence-consultation');
    Route::post('/post-liste-presence/{matiere_id}', [ProfesseurDefaultController::class, 'postListePresence'])->name('prof.poste-liste-presence');
    Route::get('/consultation-presence/{matiere_id}', [ProfesseurDefaultController::class, 'consultationListePresence'])->name('prof.consultation-liste-presence');
    Route::get('/classe-notes/{classe_id}', [ProfesseurDefaultController::class, 'classeNote'])->name('prof.classe-notes');
    // Route::get('/liste-notes/{matiere_id}', [ProfesseurDefaultController::class, 'note'])->name('prof.notes');
    Route::get('/nouvelle-notes/{matiere_id}', [ProfesseurDefaultController::class, 'addNote'])->name('prof.add-notes');
    Route::post('/notes/{matiere_id}', [ProfesseurDefaultController::class, 'postNote'])->name('prof.post-notes');
    Route::get('/emploi-du-temps', [ProfesseurDefaultController::class, 'schedule'])->name('prof.schedule');
    Route::get('/enregistrement', [ProfesseurDefaultController::class, 'enregistrement'])->name('prof.enregistrement');
    Route::post('/enregistrement', [ProfesseurDefaultController::class, 'postEnregistrement'])->name('prof.post-enregistrement');
    Route::get('/profil', [ProfesseurDefaultController::class, 'profil'])->name('prof.profil');
    Route::post('/information-post', [InformatiqueController::class, 'changeInformationsPost'])->name('prof.change-informations-post');
    Route::post('/change-password', [ProfesseurDefaultController::class, 'changePassword'])->name('prof.change-password');
});

Route::group(['prefix' => 'professeur/cahier-texte', 'middleware' => ['auth:profs', 'professeur']], function() {
    Route::get('/{classe_id}', [CahierTexteController::class, 'index'])->name('prof.cahier-texte-index');
    Route::get('/create/{classe_id}', [CahierTexteController::class, 'create'])->name('prof.cahier-texte-create');
    Route::post('/create', [CahierTexteController::class, 'store'])->name('prof.cahier-texte-store');
});

Route::group(['prefix' => 'professeur/ressources', 'middleware' => ['auth:profs', 'professeur']], function() {
    Route::get('/', [ProfesseurDefaultController::class, 'ressourcesIndex'])->name('prof.ressource-index');
    Route::post('/show', [ProfesseurDefaultController::class, 'ressourcesShow'])->name('prof.ressource-show');
    Route::get('/upload-form', [ProfesseurDefaultController::class, 'ressourcesUploadForm'])->name('prof.ressource-upload-form');
    Route::post('/upload-form', [ProfesseurDefaultController::class, 'ressourcesUploadFormPost'])->name('prof.ressource-upload-form-post');
});

Route::get('corbeille-classe/', [ClasseController::class, 'corbeilleClasses'])->name('admin.corbeille-classe')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::post('corbeille-classe/{classe_id}', [ClasseController::class, 'postCorbeilleClasse'])->name('admin.post-corbeille-classe')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::post('restoration-classe/{classe_id}', [ClasseController::class, 'restorationClasse'])->name('admin.restoration-classe')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::resource('classe', ClasseController::class, ['as' => 'admin'])->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::resource('facultes', FaculteController::class, ['as' => 'admin'])->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::resource('salle', SalleController::class, ['as' => 'admin'])->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::get('liste-classe-etudiants/{classe_id}', [InformatiqueController::class, 'listClasseEtudiants'])->name('admin.liste-classe-etudiants')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::get('liste-classe-pdf/{classe_id}', [InformatiqueController::class, 'listeClasseDownlaod'])->name('admin.liste-classe-pdf')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::get('corbeille-etudiants/', [InformatiqueController::class, 'corbeilleEtudiants'])->name('admin.corbeille-etudiant')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::post('corbeille-etudiants/{etudiant_id}', [InformatiqueController::class, 'postCorbeilleEtudiants'])->name('admin.post-corbeille-etudiant')->middleware(['auth:admins', 'informtiqueAndScolarite']);
Route::post('restoration-etudiants/{etudiant_id}', [InformatiqueController::class, 'restorationEtudiants'])->name('admin.restoration-etudiant')->middleware(['auth:admins', 'informtiqueAndScolarite']);

Route::group(['prefix' => 'progression/', 'middleware' => ['auth:admins', 'informtiqueAndScolarite']], function() {
    Route::get('liste-classe-progression', [PersonnelDefaultController::class, 'listeClasseProgression'])->name('admin.liste-classe-progression');
    Route::get('classe-progression/{classe_id}', [PersonnelDefaultController::class, 'coursClasseProgression'])->name('admin.classe-progression');
    // Route::get('chat-app/chat', [InformatiqueController::class, 'chat'])->name('admin.chat');
});

Route::get('chat-app', [InformatiqueController::class, 'chat'])->middleware(['auth:admins', 'informtiqueAndScolarite'])->name('admin.chat');

Auth::routes();
