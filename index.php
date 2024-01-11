<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connexion_bdd.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Où se situe le stand</title>
    <script>
        function getxhr(){
            try{xhr=new XMLHttpRequest();}
            catch(e){
                try{xhr=new ActiveXObjetct("Microsoft.XMLHTTP");}
                catch(e1){
                    alert("Erreur!");
                }
            }
            return xhr;
        }
        function ajaxing(){
            if(document.getElementById("mot").value=="")
                document.getElementById("sugg").style.visibility="hidden";
            else{
            xhr=getxhr();
            xhr.onreadystatechange=function(){
                if(xhr.readyState==4 && xhr.status==200){
                    if(xhr.responseText=="")
                        document.getElementById("sugg").style.visibility="hidden";
                    else{
                        document.getElementById("sugg").style.visibility="visible";
                        document.getElementById("sugg").innerHTML=xhr.responseText;
                    }                    
                } 
                else
                    document.getElementById("sugg").innertHTML="Pas de correspondance";
            }
            xhr.open("post","contenu.php",true);
            xhr.setRequestHeader("content-type","application/x-www-form-urlencoded")
            xhr.send("mot="+document.getElementById("mot").value);
        }
    }
        </script>
    
</head>
<body>
    <h1 align="center">Bienvenue au salon du livre.</h1><br>
    <p>Cette borne vous permet de chercher un stand dans le salon.<br>
    Si vous ne savez pas quoi chercher exactement, vous pouvez demander à Lycos de tout vous trouver.</p><br>
    <form action="" method="post">
        
        <input type="text" name="search" id="mot" onKeyUp="ajaxing()" autocomplete="off" placeholder="Veuillez saisir votre recherche"> 
        <div id="sugg"></div>
        <br><button type="submit">Aller Lycos, va chercher !</button>
        
               
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        $recherche = $_POST['search'];
    
        $sql = "SELECT emplacement, stand, nom, prenom FROM emplacements INNER JOIN identitee ON emplacements.id_user = identitee.id WHERE nom LIKE :search";
        $query = $db->prepare($sql);
        $query->bindValue(':search', $recherche, PDO::PARAM_STR);
        $query->execute();
        $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
        // echo json_encode($resultats);
        // var_dump($resultats);
        
        
    
        if ($resultats) {        
            foreach ($resultats as $resultat) {     
            echo '<p align="center">Nom : ' . $resultat['nom'] . '<br> Prénom : ' . $resultat['prenom'] . '<br> Type de livres: ' . $resultat['stand'] . '<br> Emplacement : ' . $resultat['emplacement'] . '</p>';
            }
        } else {
            echo '<p align="center">Aucun résultat trouvé</p>';
        }
    }
    ?>
    <script>
        document.getElementById("sugg").onclick=function(){
            document.getElementById("mot").value=event.target.textContent;
        }
    </script>
</body>
</html>