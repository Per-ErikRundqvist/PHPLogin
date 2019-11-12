<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
    </head>
    
    <body>
        
        <h1>Log In Page</h1>
        
        <?php
        define("ScriptAccess", TRUE); //Denna koden används för att komma åt 'loginScript.php' skripten.
        require_once 'loginScript.php'; //Denna ladda ner skriptkoden från loginScript.php.
        ?>
        
         <form action="login.php" method="post">
             <b>Name:</b> <input type="text" name="name"><br>
             <b>Password:</b> <input type="text" name="password"><br>
            <input type="submit"> 
         </form>
        
    </body>
</html>