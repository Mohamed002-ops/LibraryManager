<?php
class Usager {
    public $id_usager;
    public $nom;
    public $prenom;
    public $email;

    public function __construct($nom, $prenom, $email, $numero_carte) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->numero_carte = $numero_carte;
    }

    public static function fromArray($data) {
        $usager = new self(
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['numero_carte']
        );
        $usager->id_usager = $data['id_usager'] ?? null;
        return $usager;
    }
}
?>
