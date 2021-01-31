# candle

Site web pour le TP de PHP.

# Connexion à la base de données

Modifiez les lignes 35 à 38 du fichier /Model/databaseConnection.php et adaptez les à votre configuration.
```
    /**
     * Init the database connection.
     * @return DatabaseConnection
     */
    private static function initConnection(){
        $db = self::getInstance();

        $db_username = 'username'; //à modifier
        $db_password = 'password'; //à modifier
        $db_name     = 'bougie'; //à modifier
        $db_host     = 'localhost'; //à modifier

        $db->dbConn = new \mysqli($db_host, $db_username, $db_password, $db_name);
        $db->dbConn->set_charset('utf8');
        
        return $db;
    }
```

# Rôle d'un utilisateur

L'attribution d'un rôle a été défini selon les règles suivantes : 
  - rôle = 0 : root
  - rôle = 1 : admin
  - rôle = 2 : utilisateur lambda
 
De plus :
  - Un utilisateur lambda ne peut pas ajouter ou modifier un élément d'une table
  - La liste des utilisateurs n'est accessible qu'aux admins et à l'utilisateur root
  - Un utilisateur pouvant accéder à la liste des utilisateurs ne peut modifier qu'un utilisateur possédant moins de privilèges que lui.
  - Le premier utilisateur créé devient automatiquement root. Cet utilisateur ne peut être changé et il est impossible d'avoir plusieurs utilisateurs root.
  
# Gestion du token

Pour éviter toute attaque de type CSRF, la mise en place d'un token a été mise en oeuvre avec une gestion du temps également. Au bout de 5 minutes le jeton expire. En cas de manque ou d'expiration du token, l'utilisateur est redirigé vers la page d'erreur "forbidden".

