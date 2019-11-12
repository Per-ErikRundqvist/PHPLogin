<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Access Page</title>
    </head>
    
    <body>
        
        <?php
        session_start(); //Starta session.
        
        //Denna villkoren kontrollera om man lyckas logga in genom login.php med loginScript.php.
        if (isset($_SESSION["authenitcation"]))
        {
            //Denna vilkoren kontrollera sessioner. Det kontrollera om man har verklig logga in och att ip adressen verklig tillhör användaren. Detta för att förhindra nån som lyckas få tag på användarens cookie och försöker logga in.
            if ($_SESSION["authenitcation"] == true && $_SESSION["ip"] == $_SERVER["REMOTE_ADDR"])
            {
                echo "Welcome to the Access Page " . $_SESSION["name"] . "!"; //Den välkomna användaren och säger användarens namn.
            }
            
            //Om nån lyckas får tag på användarens cookies men har inte rätt id adress får dom denna meddelande.
            else
            {
                exit("You are not allowed to view this page because of your hacking attempt.");
            }
        }
        
        //Om man försöker komma åt denna sidan utan logga in kommer dom får denna meddelande.
        else
        {
            exit("You are not allowed to view this page.");
        }
        
        session_unset(); //Den rader ut varibler på sessions, detta för att öka säkerheten.
        session_destroy(); //Den tar bort allt sessions, detta för att öka säkerheten.
        
        ?>
        
    </body>
</html>