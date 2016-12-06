  <?php

 if (!extension_loaded('ldap')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        dl('php_ldap.dll');
    } else {
        dl('ldap.so');
    }
 }
  /*
   * checks the credentials against the LDAP server
   * $user - 
   * $pass - password
   */
   function ldap_authenticate($user, $pass) {

      // prevents guest account access
      if($pass == "") {
         return false;
      }

      try {
         $Yldap_location = "ldaps://ldap.iastate.edu";
         $ldap_port = 636;

         // call the ldap connect function
         $Ydatabase = ldap_connect($Yldap_location, $ldap_port);

         // bind the connection
         $good = @ldap_bind($Ydatabase, "uid=".$user.",ou=People,dc=iastate,dc=edu", $pass);

         if($good) {
            // valid credentials
            return true;
         } else {
            // invalid credentials
            return false;
         }

      } catch(Exception $e){
        //var_dump($e);
         return false;
      }
   }
   ?>
   
