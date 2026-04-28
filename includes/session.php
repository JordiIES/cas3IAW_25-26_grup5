<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['id'])) {
        header('Location: ../index.php');
        exit;
    }
}

function checkProfessorat() {
    checkLogin();
    if ($_SESSION['rol'] !== 'professorat') {
        header('Location: ../index.php');
        exit;
    }
}

function checkAlumnat() {
    checkLogin();
    if ($_SESSION['rol'] !== 'alumnat') {
        header('Location: ../index.php');
        exit;
    }
}
?>