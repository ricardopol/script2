<?php
/**
 * Created by PhpStorm.
 * User: RicardovdPol
 * Date: 5-10-2017
 * Time: 16:50
 */

$username = 'root';
$password = '';


try {
    $db1 = new PDO('mysql:host=localhost;dbname=autoverhuur', $username, $password);
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db2 = new PDO('mysql:host=localhost;dbname=automodellen', $username, $password);
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

 $querybedrijven = $db1->prepare('SELECT * FROM bedrijven');
 $querybedrijven->execute();
 $bedrijven = $querybedrijven->fetchAll(PDO::FETCH_OBJ);

 foreach ($bedrijven as $bedrijf){

     $insbedrijf = $db2->prepare('INSERT INTO bedrijfs_informatie (adres, naam, telnr) VALUES (:adres, :naam, :telnr)');
     $newnaam = implode(', ', [$bedrijf->addressen_1 , $bedrijf->addressen_2]);
     $insbedrijf->bindParam(':adres', $newnaam);
     $insbedrijf->bindParam(':naam', $bedrijf->bedrijvennaam);
     $insbedrijf->bindParam(':telnr', $bedrijf->telefoonnr);
     $insbedrijf->execute();
     $bedrijfsID = $db2->lastInsertId();

     var_dump($newnaam);

 }

