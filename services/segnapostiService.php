<?php

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: inserisciTipoSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('inserisciTipoSegnaposto')) {
    function inserisciTipoSegnaposto($idTipoSegnaposto, $nome, $descrizione, $icona)
    {
        verificaValiditaToken();

        $sql = "INSERT INTO " . PREFISSO_TAVOLA . "_t_segnaposto (idTipoSegnaposto, nome, descrizione, icona) VALUES (:idTipoSegnaposto, :nome , :descrizione, :icona)";


        $conn = apriConnessione();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':icona', $icona);
        $stmt->execute();
        chiudiConnessione($conn);
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: modificaTipoSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('modificaTipoSegnaposto')) {
    function modificaTipoSegnaposto($idTipoSegnaposto, $nome, $descrizione, $icona)
    {

        verificaValiditaToken();

        $sql = "UPDATE " . PREFISSO_TAVOLA . "_t_segnaposto SET nome= :nome ,descrizione= :descrizione ,icona= :icona WHERE idTipoSegnaposto = :idTipoSegnaposto";

        $conn = apriConnessione();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':icona', $icona);
        $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        $stmt->execute();
        chiudiConnessione($conn);
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: getTipiSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('getTipiSegnaposto')) {
    function getTipiSegnaposto($pagina)
    {
        verificaValiditaToken();
        $paginaDaEstrarre = ($pagina - 1) * ELEMENTI_PER_PAGINA;


        $sql = "SELECT idTipoSegnaposto, nome, descrizione, icona FROM " . PREFISSO_TAVOLA . "_t_segnaposto ORDER BY nome LIMIT :pagina, " . ELEMENTI_PER_PAGINA;

        $conn = apriConnessione();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pagina', $paginaDaEstrarre, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        chiudiConnessione($conn);

        return restituisciOggettoFiltrato($result, array("idTipoSegnaposto", "nome", "descrizione", "icona"));
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: getTipoSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('getTipoSegnaposto')) {
    function getTipoSegnaposto($idTipoSegnaposto)
    {
        verificaValiditaToken();

        $sql = "SELECT idTipoSegnaposto, nome, descrizione, icona FROM " . PREFISSO_TAVOLA . "_t_segnaposto WHERE idTipoSegnaposto = :idTipoSegnaposto";

        $conn = apriConnessione();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        $stmt->execute();
        $result = $stmt->fetch();
        chiudiConnessione($conn);

        return restituisciOggettoFiltrato($result, array("idTipoSegnaposto", "nome", "descrizione", "icona"));
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: eliminaTipoSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('eliminaTipoSegnaposto')) {
    function eliminaTipoSegnaposto($idTipoSegnaposto)
    {
        verificaValiditaToken();

        $sql = "DELETE FROM " . PREFISSO_TAVOLA . "_t_segnaposto WHERE idTipoSegnaposto = :idTipoSegnaposto ";

        $conn = apriConnessione();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        $stmt->execute();

        $numeroRecordModificati = $stmt->rowCount();
        chiudiConnessione($conn);

        if ($numeroRecordModificati != 1) {
            generaLogSuBaseDati("ERROR", "Tentativo di eliminazione di un tipo segnaposto non esistente. Identificativo inserito: " . $idTipoSegnaposto);
            throw new OtterGuardianException(500, "Non esiste un record con l'identificativo indicato");
        }
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: inserisciSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('inserisciSegnaposto')) {
    function inserisciSegnaposto($idTipoSegnaposto, $nome, $descrizione, $latitudine, $longitudine, $altitudine, $dataVisita, $note)
    {
        verificaValiditaToken();

        $sql = "INSERT INTO " . PREFISSO_TAVOLA . "_segnaposti (idTipoSegnaposto, nome, descrizione, latitudine, longitudine, altitudine, dataVisita, note) VALUES (:idTipoSegnaposto, :nome , :descrizione, :latitudine, :longitudine, :altitudine, :dataVisita, :note)";


        $conn = apriConnessione();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':latitudine', $latitudine);
        $stmt->bindParam(':longitudine', $longitudine);
        $stmt->bindParam(':altitudine', $altitudine);
        $stmt->bindParam(':dataVisita', $dataVisita);
        $stmt->bindParam(':note', $note);

        $stmt->execute();
        chiudiConnessione($conn);

        if ($dataVisita != null) {
            inviaNotificaOneSignalGlobale("Grande festa nel regno!", "Abbiamo visitato un nuovo luogo: " . $nome, ONE_SIGNAL_URL_ICONA, ONE_SIGNAL_URL_DESTINAZIONE);
        }
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: modificaSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('modificaSegnaposto')) {
    function modificaSegnaposto($idSegnaposto, $idTipoSegnaposto, $nome, $descrizione, $latitudine, $longitudine, $altitudine, $dataVisita, $note)
    {

        verificaValiditaToken();

        $sql = "UPDATE " . PREFISSO_TAVOLA . "_segnaposti SET idTipoSegnaposto = :idTipoSegnaposto, nome= :nome , descrizione= :descrizione , latitudine= :latitudine, longitudine=:longitudine, altitudine=:altitudine, dataVisita=:dataVisita, note=:note   WHERE idSegnaposto = :idSegnaposto";

        $conn = apriConnessione();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idSegnaposto', $idSegnaposto);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        $stmt->bindParam(':latitudine', $latitudine);
        $stmt->bindParam(':longitudine', $longitudine);
        $stmt->bindParam(':altitudine', $altitudine);
        $stmt->bindParam(':dataVisita', $dataVisita);
        $stmt->bindParam(':note', $note);
        $stmt->execute();
        chiudiConnessione($conn);

        if ($dataVisita != null) {
            inviaNotificaOneSignalGlobale("Grande festa nel regno!", "Abbiamo visitato un nuovo luogo: " . $nome, ONE_SIGNAL_URL_ICONA, ONE_SIGNAL_URL_DESTINAZIONE);
        }
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: eliminaSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('eliminaSegnaposto')) {
    function eliminaSegnaposto($idSegnaposto)
    {
        verificaValiditaToken();

        $sql = "DELETE FROM " . PREFISSO_TAVOLA . "_segnaposti WHERE idSegnaposto = :idSegnaposto ";

        $conn = apriConnessione();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idSegnaposto', $idSegnaposto);
        $stmt->execute();

        $numeroRecordModificati = $stmt->rowCount();
        chiudiConnessione($conn);

        if ($numeroRecordModificati != 1) {
            generaLogSuBaseDati("ERROR", "Tentativo di eliminazione di un segnaposto non esistente. Identificativo inserito: " . $idSegnaposto);
            throw new OtterGuardianException(500, "Non esiste un record con l'identificativo indicato");
        }
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: getSegnaposti
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('getSegnaposti')) {
    function getSegnaposti($idTipoSegnaposto, $isVisitato, $nome)
    {
        verificaValiditaToken();


        $sql = "SELECT idSegnaposto, s.idTipoSegnaposto, ts.nome nomeTipoSegnaposto, ts.descrizione descrizioneTipoSegnaposto, icona, s.nome, s.descrizione, latitudine, longitudine, altitudine, dataVisita, note  FROM " . PREFISSO_TAVOLA . "_t_segnaposto ts, " . PREFISSO_TAVOLA . "_segnaposti s WHERE ts.idTipoSegnaposto = s.idTipoSegnaposto ";
        if ($idTipoSegnaposto != null) {
            $sql = $sql . " AND s.idTipoSegnaposto = :idTipoSegnaposto";
        }
        if ($isVisitato == "S") {
            $sql = $sql . " AND dataVisita IS NOT NULL";
        } else if ($isVisitato == "N") {
            $sql = $sql . " AND dataVisita IS NULL";
        }

        if ($nome != null) {
            $sql = $sql . " AND ( s.nome LIKE :nome OR s.descrizione LIKE :nome )";
        }
        $sql = $sql . " ORDER BY s.nome";

        $conn = apriConnessione();
        $stmt = $conn->prepare($sql);
        if ($idTipoSegnaposto != null) {
            $stmt->bindParam(':idTipoSegnaposto', $idTipoSegnaposto);
        }
        if ($nome != null) {
            $nomeTmp = "%" . $nome . "%";
            $stmt->bindParam(':nome', $nomeTmp);
        }
        $stmt->execute();
        $result = $stmt->fetchAll();
        chiudiConnessione($conn);

        return $result;
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: getSegnapostiByAnno
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('getSegnapostiByAnno')) {
    function getSegnapostiByAnno($anno)
    {
        verificaValiditaToken();


        $sql = "SELECT idSegnaposto, s.idTipoSegnaposto, ts.nome nomeTipoSegnaposto, ts.descrizione descrizioneTipoSegnaposto, icona, s.nome, s.descrizione, latitudine, longitudine, altitudine, dataVisita, note  FROM " . PREFISSO_TAVOLA . "_t_segnaposto ts, " . PREFISSO_TAVOLA . "_segnaposti s WHERE ts.idTipoSegnaposto = s.idTipoSegnaposto AND dataVisita IS NOT NULL AND YEAR(dataVisita) = :anno ";
        $sql = $sql . " ORDER BY s.dataVisita DESC";

        $conn = apriConnessione();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':anno', $anno);
        $stmt->execute();
        $result = $stmt->fetchAll();
        chiudiConnessione($conn);

        return $result;
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: getSegnapostiByCoordinate
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('getSegnapostiByCoordinate')) {
    function getSegnapostiByCoordinate($lat, $lon, $raggio)
    {
        verificaValiditaToken();


        $sql = "SELECT s.idSegnaposto, s.idTipoSegnaposto, ts.nome nomeTipoSegnaposto, ts.descrizione descrizioneTipoSegnaposto, icona, s.nome, s.descrizione, latitudine, longitudine, altitudine, dataVisita, note , ROUND((6371 *
            acos(
            cos(radians(:latitudine)) *
            cos(radians(latitudine)) *
            cos(radians(longitudine) - radians(:longitudine)) +
            sin(radians(:latitudine)) *
            sin(radians(latitudine))
            ))) AS distanza  FROM " . PREFISSO_TAVOLA . "_t_segnaposto ts, " . PREFISSO_TAVOLA . "_segnaposti s, (SELECT idSegnaposto, ROUND((6371 *
        acos(
        cos(radians(:latitudine)) *
        cos(radians(latitudine)) *
        cos(radians(longitudine) - radians(:longitudine)) +
        sin(radians(:latitudine)) *
        sin(radians(latitudine))
        ))) AS distanza FROM " . PREFISSO_TAVOLA . "_segnaposti ) d WHERE d.idSegnaposto = s.idSegnaposto AND ts.idTipoSegnaposto = s.idTipoSegnaposto AND d.DISTANZA <= :distanza";



        $sql = $sql . " ORDER BY d.distanza";

        $conn = apriConnessione();
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':latitudine', $lat);
        $stmt->bindParam(':longitudine', $lon);
        $stmt->bindParam(':distanza', $raggio);

        $stmt->execute();
        $result = $stmt->fetchAll();
        chiudiConnessione($conn);

        return $result;
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Funzione: getSegnaposto
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

if (!function_exists('getSegnaposto')) {
    function getSegnaposto($idSegnaposto)
    {
        verificaValiditaToken();


        $sql = "SELECT idSegnaposto, s.idTipoSegnaposto, ts.nome nomeTipoSegnaposto, ts.descrizione descrizioneTipoSegnaposto, icona, s.nome, s.descrizione, latitudine, longitudine, altitudine, dataVisita, note  FROM " . PREFISSO_TAVOLA . "_t_segnaposto ts, " . PREFISSO_TAVOLA . "_segnaposti s WHERE s.idSegnaposto = :idSegnaposto ";

        $conn = apriConnessione();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idSegnaposto', $idSegnaposto);
        $stmt->execute();
        $result = $stmt->fetch();
        chiudiConnessione($conn);

        return $result;
    }
}