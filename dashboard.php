<?php
session_start();

require_once('database/db.php');
$conn = connectDB();

if (isset($_POST['id_vehicule_supprimer'])) {
    $query = "DELETE FROM vehicules WHERE vehicules.id = ?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST['id_vehicule_supprimer']);
    $stmt->execute();
}

if (isset($_POST['gestion-vehicule'])) {
    // $query = "";
    // if ($_POST['gestion-vehicule'] == "ajout") {
    //     $query = "INSERT INTO vehicules(marque, modele, annee, client_id) VALUES ('?','?','?','?')";
    // }
    // else {
    //     $query = "UPDATE vehicules SET marque='?',modele='?',annee='?',client_id='?' WHERE vehicules.id=?";
    // }
    // $stmt = $conn->prepare($query);
    // $stmt->bind_param(1, $_POST['marque-vehicule'], PDO::PARAM_STR);
    // $stmt->bind_param(2, $_POST['marque-vehicule'], PDO::PARAM_STR);
    // $stmt->bind_param(3, $_POST['annee-vehicule'], PDO::PARAM_STR);
    // $stmt->bind_param(4, $_POST['id-client'], PDO::PARAM_INT);
    // if ($_POST['gestion-vehicule'] != "ajout") { $stmt->bind_param(5, $_POST['id-vehicule'], PDO::PARAM_INT); }

    // $stmt->execute();
}


$result = $conn->query("SELECT COUNT(*) AS total_clients FROM clients");
$row = $result->fetch_assoc();
$totalClients = $row['total_clients'];

$result = $conn->query("SELECT COUNT(*) AS total_vehicules FROM vehicules");
$row = $result->fetch_assoc();
$totalVehicules = $row['total_vehicules'];

$result = $conn->query("SELECT COUNT(*) AS total_rendezvous FROM rendezvous");
$row = $result->fetch_assoc();
$totalRendezvous = $row['total_rendezvous'];

$result = $conn->query("SELECT vehicules.id as vehicule_id,marque,modele,annee,client_id,nom,email,telephone FROM vehicules LEFT JOIN clients on client_id=clients.id");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/settings.css">
    <link rel="stylesheet" href="assets/css/gestionnaire.css">
    <script src="javascript/gestion-vehicule.js"></script>
    <title>Tableau de Bord Garage Train</title>
</head>
<body>
    <h1>Tableau de Bord Garage Train</h1>
    <div>
        <h2>Clients</h2>
        <p>Total Clients: <?= $totalClients ?></p>
    </div>
    <div>
        <h2>Véhicules</h2>
        <p>Total Véhicules: <?= $totalVehicules ?></p>
    </div>
    <div>
        <h2>Rendez-vous</h2>
        <p>Total Rendez-vous: <?= $totalRendezvous ?></p>
    </div>

    <section id="gestionnaire">
        <section id="liste-vehicules">
            <button class="ajout-vehicule" onclick="openForm('ajout')">Ajouter un véhicule</button> 

            <?php foreach ($result as $row) { ?>
                
            <div class="vehicule" onclick="openDetails(this)">
                <nav>
                    <div>
                        <p class="vehicule_id">Immatriculation : <?php echo $row["vehicule_id"] ?></p>
                        <p class="client_id">Client : <?php echo $row["client_id"] != NULL ? $row["client_id"] : "Aucun"; ?></p>
                    </div>

                    <div>
                        <button class="modifier" onclick="openForm('modification')">Modifier</button>
                        <button class="supprimer" id="<?php echo $row["vehicule_id"] ?>" onclick="deleteVehicule(this)">Supprimer</button>
                    </div>
                </nav>
                <section class="details">
                    <div>
                        <h2>Véhicule</h2>
                        <div>
                            <p><?php echo $row["marque"] ?></p>
                            <p><?php echo $row["modele"] ?></p>
                            <p><?php echo $row["annee"] ?></p>
                        </div>
                    </div>

                    <div>
                        <h2>Client</h2>
                        <?php if ($row["client_id"] != NULL) { ?>
                        <div>
                            <p><?php echo $row["nom"] ?></p>
                            <p><?php echo $row["email"] ?></p>
                            <p><?php echo $row["telephone"] ?></p>
                        </div>
                        <?php } else { ?>
                        <div>
                            <p>Aucun</p>
                        </div>
                        <?php } ?>
                    </div>
                </section>
            </div>

            <?php } ?>
        </section>

        <section id="gestion-vehicule" class="">
                <form  action="" method="post" class="formulaire-gestion details open">
                    <input type="hidden" name="gestion-vehicule">
                    <h1>Modifier le véhicule</h1>
                    <div>
                        <h2>Véhicule</h2>
                        <div>
                            <input type="text" name="id-vehicule" placeholder="ID VEHICULE">
                            <input type="text" name="marque-vehicule" placeholder="MARQUE">
                            <input type="text" name="modele-vehicule" placeholder="MODELE">
                            <input type="text" name="annee-vehicule" placeholder="ANNEE">
                        </div>
                        <div>
                            <label for="commentaire">Commentaire</label>
                            <textarea name="commentaire"></textarea>
                        </div>
                    </div>

                    <div>
                        <h2>Client associé à ce véhicule</h2>
                        <div>
                            <input type="text" name="id-client" placeholder="ID CLIENT" disabled>
                            <input type="text" name="nom-client" placeholder="NOM" disabled>
                            <input type="text" name="email-client" placeholder="EMAIL" disabled>
                            <input type="text" name="telephone-client" placeholder="TELEPHONE" disabled>
                        </div>

                        <div>
                            <label for="choix-client">Nouveau client à associé</label>
                            <select name="choix-client">
                                <option value="">Associer un autre client</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" value="Modifier le véhicule">
                    <div style="cursor:pointer" onclick="openForm('fermer')">Annuler</div>
                </form>
        </section>
    </section>

    <form action="" method="post" id="supprimer-vehicule">
        <input type="number" name="id_vehicule_supprimer">
    </form>
</body>
</html>
