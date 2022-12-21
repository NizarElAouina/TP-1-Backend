<?php
	$loginProp = $_POST['loginProp'];
	$motPasse = $_POST['motPasse'];
	//$nom = $_POST['nom'];
	//$prenom = $_POST['prenom'];
	//$connexion = $_POST['connexion'];
/*
	// Database connection
	$conn = new mysqli('localhost','root','','tp1backend');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		echo "connecté";
		$stmt = $conn->prepare("insert into compteproprietaire(loginProp, motPasse, nom, prenom) values(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $loginProp, $motPasse, $nom, $prenom);
		$execval = $stmt->execute();
		echo $execval;
		echo "Registration successfully...";
		$stmt->close();
		$conn->close();
	}*/
	/*
Page: connexion.php
*/
//à mettre tout en haut du fichier .php, cette fonction propre à PHP servira à maintenir la $_SESSION
session_start();
//si le bouton "Connexion" est cliqué
if(isset($connexion)){
    // on vérifie que le champ "Pseudo" n'est pas vide
    // empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (is set)
    if(empty($loginProp)){
        echo "Le champ Login est vide.";
    } else {
        // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
        if(empty($motPasse)){
            echo "Le champ Mot de passe est vide.";
        } else {
            // les champs pseudo & mdp sont bien postés et pas vides, on sécurise les données entrées par l'utilisateur
            //le htmlentities() passera les guillemets en entités HTML, ce qui empêchera en partie, les injections SQL
            //$Pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES, "UTF-8"); 
            //$MotDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "UTF-8");
            //on se connecte à la base de données:
            $mysqli = mysqli_connect('localhost','root','','tp1backend');
            //on vérifie que la connexion s'effectue correctement:
            if(!$mysqli){
                echo "Erreur de connexion à la base de données.";
            } else {
                //on fait maintenant la requête dans la base de données pour rechercher si ces données existent et correspondent:
                //si vous avez enregistré le mot de passe en md5() il vous faudra faire la vérification en mettant mdp = '".md5($MotDePasse)."' au lieu de mdp = '".$MotDePasse."'
                $Requete = mysqli_query($mysqli,"SELECT * FROM compteproprietaire WHERE loginProp = '.$loginProp.' AND motPasse = '.$motPasse.'");
                //si il y a un résultat, mysqli_num_rows() nous donnera alors 1
                //si mysqli_num_rows() retourne 0 c'est qu'il a trouvé aucun résultat
                if(mysqli_num_rows($Requete) == 0) {
                    echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
                } else {
                    //on ouvre la session avec $_SESSION:
                    //la session peut être appelée différemment et son contenu aussi peut être autre chose que le pseudo
                    $_SESSION['loginProp'] = $loginProp;
                    echo "Vous êtes à présent connecté !";
                }
            }
        }
    }
}
?>