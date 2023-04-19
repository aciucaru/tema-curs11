<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/consolelog.inc.php';
require_once __DIR__ . '/../model/client.php';
require_once __DIR__ . '/../model/produs.php';

enum TipInputClient: string
{
    case Nume = "Nume";
    case Username = "Username";
    case Email = "Email";
    case Parola = "Parola";
    case Comenzi = "Comenzi";
}

// clasa de baza folosita ca tip comun pentru diferitele tipuri de reguli de validare
class ReguliValidare
{
    // daca input-ul este obligatoriu sau nu, propr. comuna pt. toate input-urile
    public bool $campObligatoriu = false;
}

class ReguliValidareNume extends ReguliValidare
{
    public int $lungimeMinima = 3;
    public int $lungimeMaxima = 255;
}

class ReguliValidareUsername extends ReguliValidare
{
    public int $lungimeMinima = 3;
    public int $lungimeMaxima = 255;
}

class ReguliValidareParola extends ReguliValidare
{
    public int $lungimeMinima = 4; // prea mic, e doar de exemplu
    public int $lungimeMaxima = 255;
}

function valideazaInputNume(string $numeCamp, ReguliValidareNume $reguliValidare): bool
{
    consoleLog("valideazaInputNume: inceput rularea, validare: $numeCamp");

    if (isset($reguliValidare))
    {
        if ($reguliValidare->campObligatoriu)
        {
            if (isset($numeCamp) && !empty($numeCamp))
            {
                if(isset($_POST[$numeCamp]) && !empty($_POST[$numeCamp]))
                {
                    // curatam inputul de posibile atacuri XSS
                    $camp = htmlspecialchars($_POST[$numeCamp]);

                    // 1. verificare prima regula: lungimea minima
                    if (strlen($camp) < $reguliValidare->lungimeMinima)
                    {
                        consoleLog("valideazaInputNume: $numeCamp este prea scurt");
                        return false;
                    }

                    // 2. verificare prima regula: lungimea maxima
                    if (strlen($camp) > $reguliValidare->lungimeMaxima)
                    {
                        consoleLog("valideazaInputNume: $numeCamp este prea lung");
                        return false;
                    }

                    // 3. verificare daca string-ul contine caractere speciale (interzise pt. nume de persoane)
                    if(strpbrk($camp, ',;-()[]{}~!@#$%^&*?') === false)
                    {
                        consoleLog("valideazaInputUsername: $numeCamp contine caractere ilegale (,;-()[]{}~!@#$%^&*?)");
                        return false;
                    }

                    // daca s-a ajuns pana aici inseamna ca s-au trecut toate validarile, deci input-ul este bun
                    return true;
                }
                else
                {
                    consoleLog("valideazaInputNume: input $numeCamp nu exista in POST");
                    return false;
                }

            }
            else
            {
                consoleLog("valideazaInputNume: $numeCamp este nul sau gol");
                return false;
            }
        }
        else
            // daca acest camp nu este obligatoriu, atunci teoretic campul este valid
            return true;
    }
    else
        // daca nu s-au specificat reguli de validare, atunci teoretic campul este valid
        return true;
}

function valideazaInputUsername(string $numeCamp, ReguliValidareUsername $reguliValidare): bool
{
    consoleLog("valideazaInputUsername: inceput rularea, validare: $numeCamp");

    if (isset($reguliValidare))
    {
        if ($reguliValidare->campObligatoriu)
        {
            if (isset($camp) && !empty($camp))
            {
                if(isset($_POST[$camp]) && !empty($_POST[$camp]))
                {
                    // curatam inputul de posibile atacuri XSS
                    $camp = htmlspecialchars($_POST[$numeCamp]);

                    // 1. verificare prima regula: lungimea minima
                    if (strlen($camp) < $reguliValidare->lungimeMinima)
                    {
                        consoleLog("valideazaInputUsername: $numeCamp este prea scurt");
                        return false;
                    }

                    // 2. verificare a doua regula: lungimea maxima
                    if (strlen($camp) > $reguliValidare->lungimeMaxima)
                    {
                        consoleLog("valideazaInputUsername: $numeCamp este prea lung");
                        return false;
                    }

                    // 3. verificare daca string-ul contine caractere speciale (interzise pt. username)
                    if(strpbrk($camp, ',;-()[]{}~!@#$%^&*?') === false)
                    {
                        consoleLog("valideazaInputUsername: $numeCamp contine caractere ilegale: ,;-()[]{}~!@#$%^&*?");
                        return false;
                    }

                    // daca s-a ajuns pana aici inseamna ca s-au trecut toate validarile, deci input-ul este bun
                    return true;
                }
                else
                {
                    consoleLog("valideazaInputUsername: $numeCamp nu exista in POST");
                    return false;
                }

            }
            else
            {
                consoleLog("valideazaInputUsername: $numeCamp este nul sau gol");
                return false;
            }
        }
        else
            // daca acest camp nu este obligatoriu, atunci teoretic campul este valid
            return true;
    }
    else
        // daca nu s-au specificat reguli de validare, atunci teoretic campul este valid
        return true;
}

function valideazaInputEmail(string $numeCamp, ReguliValidare $reguliValidare): bool
{
    consoleLog("valideazaInputEmail: inceput rularea, validare: $numeCamp");

    if (isset($reguliValidare))
    {
        if ($reguliValidare->campObligatoriu)
        {
            if (isset($camp) && !empty($camp))
            {
                if(isset($_POST[$camp]) && !empty($_POST[$camp]))
                {
                    // curatam inputul de posibile atacuri XSS
                    $camp = htmlspecialchars($_POST[$numeCamp]);

                    if(filter_var($camp, FILTER_VALIDATE_EMAIL) === false)
                    {
                        consoleLog("valideazaInputEmail: $numeCamp nu este o adresa de email valida");
                        return false;
                    }

                    // daca s-a ajuns pana aici inseamna ca s-au trecut toate validarile, deci input-ul este bun
                    return true;
                }
                else
                {
                    consoleLog("valideazaInputEmail: $numeCamp nu exista in POST");
                    return false;
                }
            }
            else
            {
                consoleLog("valideazaInputEmail: $numeCamp: este obligatoriu");
                return false;
            }
        }
        else
            // daca acest camp nu este obligatoriu, atunci teoretic campul este valid
            return true;
    }
    else
        // daca nu s-au specificat reguli de validare, atunci teoretic campul este valid
        return true;
}

function valideazaInputParola(string $numeCampParola, ReguliValidareParola $reguliValidare): bool
{
    consoleLog("valideazaInputNume: inceput rularea, validare: $numeCampParola");

    if (isset($reguliValidare))
    {
        if ($reguliValidare->campObligatoriu)
        {
            if (isset($numeCampParola) && !empty($numeCampParola))
            {
                if(isset($_POST[$numeCampParola]) && !empty($_POST[$numeCampParola]))
                {
                    // curatam inputurile de posibile atacuri XSS
                    $campParola = htmlspecialchars($_POST[$numeCampParola]);

                    // 1. verificare prima regula: lungimea minima
                    if (strlen($campParola) < $reguliValidare->lungimeMinima)
                    {
                        consoleLog("valideazaInputNume: $numeCampParola este prea scurt");
                        return false;
                    }

                    // 2. verificare prima regula: lungimea maxima
                    if (strlen($campParola) > $reguliValidare->lungimeMaxima)
                    {
                        consoleLog("valideazaInputNume: $numeCampParola este prea lung");
                        return false;
                    }

                    // daca s-a ajuns pana aici inseamna ca s-au trecut toate validarile, deci input-ul este bun
                    return true;
                }
                else
                {
                    consoleLog("valideazaInputNume: input $numeCampParola nu exista in POST");
                    return false;
                }

            }
            else
            {
                consoleLog("valideazaInputNume: $numeCampParola este nul sau gol");
                return false;
            }
        }
        else
            // daca acest camp nu este obligatoriu, atunci teoretic campul este valid
            return true;
    }
    else
        // daca nu s-au specificat reguli de validare, atunci teoretic campul este valid
        return true;
}

// functie ce valideaza toate input-urile necesare paginii 'regsiter'
function valideazaInputuriRegister(): ?Client
{
    consoleLog("valideazaInputuriRegister: inceput rularea");
    $inputurileSuntValide = true;

    // variabile folosite pt. a cosntrui un nou obiect de tip Client
    $id = -1;
    $nume = "";
    $username = "";
    $email = "";
    $hashParola = "";
    $comenzi = "";

    $inputuriDeValidat =
    [
        'nume' =>
        [
            'tip' => TipInputClient::Nume,
            'reguliValidare' => new ReguliValidareNume()
        ],

        'username' =>
        [
            'tip' => TipInputClient::Username,
            'reguliValidare' => new ReguliValidareUsername()
        ],

        'email' =>
        [
            'tip' => TipInputClient::Email,
            'reguliValidare' => new ReguliValidare()
        ],

        'parola' =>
        [
            'tip' => TipInputClient::Parola,
            'reguliValidare' => new ReguliValidareParola()
        ]
    ];

    foreach($inputuriDeValidat as $numeInput => $detaliiValidareInput)
    {
        switch($detaliiValidareInput['tip'])
        {
            case TipInputClient::Nume:
                if(valideazaInputNume($numeInput, $detaliiValidareInput['reguliValidare']) === true)
                    $nume = htmlspecialchars($_POST[$numeInput]);
                else
                    $inputurileSuntValide = false;
                break;

            case TipInputClient::Username:
                if(valideazaInputUsername($numeInput, $detaliiValidareInput['reguliValidare']) === true)
                    $username = htmlspecialchars($_POST[$numeInput]);
                else
                    $inputurileSuntValide = false;
                break;

            case TipInputClient::Email:
                if(valideazaInputEmail($numeInput, $detaliiValidareInput['reguliValidare']) === true)
                    $email = htmlspecialchars($_POST[$numeInput]);
                else
                    $inputurileSuntValide = false;
                break;

            case TipInputClient::Parola:
                if(valideazaInputParola($numeInput, $detaliiValidareInput['reguliValidare']) === true)
                {
                    $parola = htmlspecialchars($_POST[$numeInput]);
                    // $parola = $_POST[$numeInput];
                    // $hashParola = password_hash($parola, PASSWORD_DEFAULT);
                    $hashParola = $parola;
                }
                else
                    $inputurileSuntValide = false;
                break;

            default:
                break;
        }
    }

    if($inputurileSuntValide === true)
    {
        consoleLog("valideazaInputuriRegister: validare cu succes");
        return new Client(
            $id,
            $nume,
            $username,
            $email,
            $hashParola,
            $comenzi
        );
    }

    else
    {
        consoleLog("valideazaInputuriRegister: validare esuata");
        return null;
    }
}

// functie ce valideaza toate input-urile necesare paginii 'regsiter'
function valideazaInputuriLogin(): bool
{
    consoleLog("valideazaInputuriLogin: inceput rularea");
    $inputurileSuntValide = true;

    $inputuriDeValidat =
    [
        'username' =>
        [
            'tip' => TipInputClient::Username,
            'reguliValidare' => new ReguliValidareUsername()
        ],

        'parola' =>
        [
            'tip' => TipInputClient::Parola,
            'reguliValidare' => new ReguliValidareParola()
        ]
    ];

    foreach($inputuriDeValidat as $numeInput => $detaliiValidareInput)
    {
        switch($detaliiValidareInput['tip'])
        {
            case TipInputClient::Username:
                if(valideazaInputUsername($numeInput, $detaliiValidareInput['reguliValidare']) === true)
                    $username = htmlspecialchars($_POST[$numeInput]);
                else
                    $inputurileSuntValide = false;
                break;

            case TipInputClient::Parola:
                if(valideazaInputParola($numeInput, $detaliiValidareInput['reguliValidare']) === true)
                {
                    $parola = htmlspecialchars($_POST[$numeInput]);
                    $hashParola = password_hash($parola, PASSWORD_DEFAULT);
                }
                else
                    $inputurileSuntValide = false;
                break;

            default:
                break;
        }
    }

    if($inputurileSuntValide === true)
    {
        consoleLog("valideazaInputuriLogin: validare cu succes");
        return true;
    }

    else
    {
        consoleLog("valideazaInputuriLogin: validare esuata");
        return false;
    }
}

?>