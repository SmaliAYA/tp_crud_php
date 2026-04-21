<?php
require_once "../config/database.php";
require_once "../repositories/LivreRepository.php";

$repo = new LivreRepository($pdo);

// 🔹 Traitement du formulaire
if (isset($_POST['titre'], $_POST['auteur'], $_POST['prix'])) {
    
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $prix = trim($_POST['prix']);

    if (!empty($titre) && !empty($auteur) && !empty($prix)) {
        $repo->insert($titre, $auteur, $prix);

        header("Location: index.php");
        exit();
    }
}

// 🔹 Suppression d’un livre
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    if ($id > 0) {
        $repo->delete($id);
    }

    header("Location: index.php");
    exit();
}

// 🔹 Récupérer les livres (⚠️ déplacé ici AVANT edit)
$livres = $repo->findAll();

// 🔹 Gestion édition
$editLivre = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    foreach ($livres as $livre) {
        if ($livre['id'] == $id) {
            $editLivre = $livre;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des livres</title>
</head>
<body>

<h1>Liste des livres</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>

    <?php foreach ($livres as $livre): ?>
        <tr>
            <td><?= htmlspecialchars($livre['id']) ?></td>
            <td><?= htmlspecialchars($livre['titre']) ?></td>
            <td><?= htmlspecialchars($livre['auteur']) ?></td>
            <td><?= htmlspecialchars($livre['prix']) ?></td>
            <td>
                <a href="?delete=<?= $livre['id'] ?>" 
                   onclick="return confirm('Voulez-vous supprimer ce livre ?')">
                    Supprimer
                </a>
                <a href="?edit=<?= $livre['id'] ?>">Modifier</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<h2><?= $editLivre ? "Modifier" : "Ajouter" ?> un livre</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $editLivre['id'] ?? '' ?>">

    <label>Titre :</label><br>
    <input type="text" name="titre"
        value="<?= htmlspecialchars($editLivre['titre'] ?? '') ?>"><br><br>

    <label>Auteur :</label><br>
    <input type="text" name="auteur"
        value="<?= htmlspecialchars($editLivre['auteur'] ?? '') ?>"><br><br>

    <label>Prix :</label><br>
    <input type="number" step="0.01" name="prix"
        value="<?= htmlspecialchars($editLivre['prix'] ?? '') ?>"><br><br>

    <button type="submit">
        <?= $editLivre ? "Modifier" : "Ajouter" ?>
    </button>
</form>

</body>
</html>