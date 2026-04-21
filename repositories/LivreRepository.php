<?php

class LivreRepository {
    private $pdo;

    // Constructeur avec injection PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // 🔹 Récupérer tous les livres
    public function findAll() {
        $sql = "SELECT * FROM livre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Ajouter un livre
    public function insert($titre, $auteur, $prix) {
        $sql = "INSERT INTO livre (titre, auteur, prix) VALUES (:titre, :auteur, :prix)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':prix' => $prix
        ]);
    }
    public function delete($id) {
    $sql = "DELETE FROM livre WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id
    ]);
}
public function update($id, $titre, $auteur, $prix) {
    $sql = "UPDATE livre 
            SET titre = :titre, auteur = :auteur, prix = :prix 
            WHERE id = :id";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':titre' => $titre,
        ':auteur' => $auteur,
        ':prix' => $prix
    ]);
}
}