<?php

class Livre {
    private $id;
    private $titre;
    private $auteur;
    private $prix;

    public function __construct($id, $titre, $auteur, $prix) {
        $this->id = $id;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->prix = $prix;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function getPrix() {
        return $this->prix;
    }
}