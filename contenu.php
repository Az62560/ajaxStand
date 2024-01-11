<?php
// echo "Test";
include("connexion_bdd.php");
$mot=$_POST["mot"];
$req=$db->prepare("select emplacement, stand, nom, prenom from emplacements inner join identitee on emplacements.id_user = identitee.id where nom like ?");
$req->setFetchMode(PDO::FETCH_ASSOC);
$req->execute(array(trim($mot)."%"));
$tab=$req->fetchAll();
for ($i=0; $i < count($tab) ; $i++) { 
    echo '<div>' . $tab[$i]["nom"] . '</div>';
}
?>