<?php

session_start(); //Starta session.

if(!defined("ScriptAccess")) //Denna villkoren hindra nån komma direkt åt skriptkoden.
{
    //Om användaren försöker gå direkt till skriptkoden får dom denna meddelande.
    exit("You are not allowed to access the script file."); 
}

$servername = "localhost"; //Namnen på databas server.
$username = "root"; //Namnen på användarkonto.
$userpassword = ""; //Lösenord till användarkonto som är tomt.
$database = "login_database"; //Namnen till databasen login_database.sql.

//Om användare mata in name och password formulären i login.php kommer den aktivera resten av koden.
if (isset ($_POST['name']) && isset ($_POST['password']))    
{
    $name = $_POST['name']; //Denna varibler hämta "Name" formulären från login.php.
    $password = $_POST['password']; //Denna varibler hämta "Password" formulären från login.php.
    
    $name = str_replace("=", "", $name); //Den ta bort "=" från $name för att hindra från göra enklar SQL Injection attacker, exempel som "OR 1=1".
    
    
    $connection = new mysqli($servername, $username, $userpassword, $database); //Denna MYSQLI koppla till databasen.
    
    //Om koppling till databasen misslyckas kommer denna villkoren vis femeddelande.
    if ($connection->connect_errno) 
    {
        echo "Connection failed: " . $connection->connect_error;
    }
    
    $getUser = "SELECT * FROM user WHERE name = ?"; //Denna är SQL kommando för hämta name från databasen.
    
    $stmt = $connection->prepare($getUser); //Denna är Prepared Statesments som förberedder SQL kommando från $getUser.
    $stmt->bind_param("s", $name); //Den binder parameter från $stmt så att bara strängen
    $stmt->execute(); //Utför kommando med $stmt;
    
    $result = $stmt->get_result(); //Den hämta resultatet från databasen.
    
    //Om man får resultated från databasen kommer den genomgå kontrol för lösenord.
    if ($result)
    {
        $rows = $result->fetch_assoc(); //Den tillfällig skapa varible som hämta data från databaen där lagra på samma raden som "name".
        
        //Denna villkoren  kommer kontrollera lösenorden som man fått från användaren och databasen. Eftersom lösenorden på
        //databasen login_database.sql är hashad måste man använda password_verify() för kontrollera lösenorden.
        if (password_verify($password, $rows['password']))
        {
            header("Location: accesspage.php"); //Om lösenorden är rätt kommer den hoppa till assesspage.php sidan.
            
            $_SESSION["authenitcation"] = true; //Denna session kommer användas för verifiera om man logga in på rätt sätt.
            $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"]; //Denna session kontrollera om det är samma IP adress som användaren.
                                                       //Detta är för att förhindra nån som lyckas komma åt användarens
                                                       //cookies och försöker hacka in inloggning sidan.
            $_SESSION["name"] = $name; //Denna session kommer användas för visa användarens namn på accesspge.php
            
            $connection->close(); //Stänger koppling till databasen.
        }
        //Om $result misslyckas hämta resultatet från databasen
        else
        {
            echo "The password are not correct, please control the password and try again. <br>";
            
            $connection->close(); //Stänger koppling till databasen.
        }
    }
    //Om $result misslyckas att hämta resultatet från databasen kommer den ger användaren felmeddelande.
    else 
    {
        echo "User name and passowrd does not exist in database. <br>";
        
        $connection->close(); //Stänger koppling till databasen.
    }
    
}

?>
        