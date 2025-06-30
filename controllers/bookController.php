<?php
require_once '/Library/models/Book.php';

class BookController {
    public function list() {
        $books = Book::getAll();
        include '/Library/views/books/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = htmlspecialchars($_POST['titre']);
            $auteur = htmlspecialchars($_POST['auteur']);
            $annee = htmlspecialchars($_POST['annee']);

            if (Book::add($titre, $auteur, $annee)) {
                header('Location: index.php?page=books');
                exit;
            }
        }
        include '/Library/views/books/add.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            Book::delete($_GET['id']);
            header('Location: index.php?page=books');
        }
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $book = Book::getById($_GET['id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titre = htmlspecialchars($_POST['titre']);
                $auteur = htmlspecialchars($_POST['auteur']);
                $annee = htmlspecialchars($_POST['annee']);

                Book::update($_GET['id'], $titre, $auteur, $annee);
                header('Location: index.php?page=books');
                exit;
            }
            include 'views/books/edit.php';
        }
    }
}
