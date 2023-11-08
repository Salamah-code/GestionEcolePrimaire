<?php

// Exécutez la requête SQL mise à jour
$query = "SELECT c.*, COUNT(e.IDELEVE) AS nombre_eleves
          FROM classe c
          LEFT JOIN eleve e ON c.IDCLASSE = e.IDCLASSE
          WHERE c.ANNEACCADEMIQUE = '$selectedAnnee'
          GROUP BY c.IDCLASSE";
$result = mysqli_query($congestschool, $query);

// Créez un tableau pour stocker les données des classes
$classesData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $classesData[] = $row;
}

// Convertissez le tableau en format JSON et renvoyez-le
echo json_encode($classesData);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<script>
    function afficherClasses(classesData) {
    const listeClasses = document.getElementById("liste-classes");
    listeClasses.innerHTML = ""; // Effacez le contenu actuel

    classesData.forEach(function (classe) {
        const nomClasse = classe.NOMCLASSE;
        const classeId = classe.IDCLASSE;
        const nombreEleves = classe.nombre_eleves; // Nombre d'élèves pour cette classe

        // Créez la carte pour la classe avec le nombre d'élèves
        const cardDiv = document.createElement("div");
        cardDiv.className = "col-md-3";
        cardDiv.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${nomClasse}</h5>
                    <p class="card-text">Nombre d'élèves : ${nombreEleves}</p>
                    <button class="btn btn-primary m-2 classe-link" data-classe-id="${classeId}">Voir les élèves</button>
                </div>
            </div>
        `;

        // Ajoutez la carte à la liste des classes
        listeClasses.appendChild(cardDiv);
    });

    // Affichez la liste des classes
    listeClasses.style.display = "block";
}

</script>
</body>
</html>
