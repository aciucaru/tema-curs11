<?php

require_once __DIR__ . '/consolelog.inc.php';

function loginSession(Client $clientLogat)
{
    consoleLog('loginSession: inceput rularea');

    if($clientLogat != null)
    {
        $_SESSION['username'] = $clientLogat->username;
        $_SESSION['email'] = $clientLogat->email;
        header('Location: index.php');

        consoleLog("loginSession: sesiune initializata: username: $clientLogat->username, email: $clientLogat->email");
    }
    else
        consoleLog('loginSession: argumentul pasat este nul');
}

function logoutSession()
{
    consoleLog('logOut: inceput rularea');

    session_start();
    session_unset();
    session_destroy();

    header('Location: ../login.php');
}

?>