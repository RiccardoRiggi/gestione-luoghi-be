<?php

include './importManager.php';
include '../services/segnapostiService.php';
include '../services/webHookTelegramService.php';
include '../services/utentiService.php';

try {

    switch ($_GET["nomeMetodo"]) {

        case 'inserisciTipoSegnaposto':

            verificaMetodoHttp("POST");
            inserisciTipoSegnaposto(recuperaParametroJsonBody("idTipoSegnaposto"), recuperaParametroJsonBody("nome"), recuperaParametroJsonBody("descrizione"), recuperaParametroJsonBody("icona"));
            http_response_code(200);
            exit(null);

        case 'modificaTipoSegnaposto':

            verificaMetodoHttp("PUT");
            modificaTipoSegnaposto(recuperaParametroGet("idTipoSegnaposto"), recuperaParametroJsonBody("nome"), recuperaParametroJsonBody("descrizione"), recuperaParametroJsonBody("icona"));
            http_response_code(200);
            exit(null);

        case 'getTipiSegnaposto':

            verificaMetodoHttp("GET");
            $response = getTipiSegnaposto(recuperaParametroGet("pagina"));
            http_response_code(200);
            exit(json_encode($response));

        case 'getTipoSegnaposto':

            verificaMetodoHttp("GET");
            $response = getTipoSegnaposto(recuperaParametroGet("idTipoSegnaposto"));
            http_response_code(200);
            exit(json_encode($response));

        case 'eliminaTipoSegnaposto':

            verificaMetodoHttp("DELETE");
            $response = eliminaTipoSegnaposto(recuperaParametroGet("idTipoSegnaposto"));
            http_response_code(200);
            exit(null);

        case 'inserisciSegnaposto':

            verificaMetodoHttp("POST");
            inserisciSegnaposto(recuperaParametroJsonBody("idTipoSegnaposto"), recuperaParametroJsonBody("nome"), recuperaParametroJsonBody("descrizione"), recuperaParametroJsonBody("latitudine"), recuperaParametroJsonBody("longitudine"), getParametroJsonBody("altitudine"), getParametroJsonBody("dataVisita"), getParametroJsonBody("note"));
            http_response_code(200);
            exit(null);

        case 'modificaSegnaposto':

            verificaMetodoHttp("PUT");
            modificaSegnaposto(recuperaParametroGet("idSegnaposto"), recuperaParametroJsonBody("idTipoSegnaposto"), recuperaParametroJsonBody("nome"), recuperaParametroJsonBody("descrizione"), recuperaParametroJsonBody("latitudine"), recuperaParametroJsonBody("longitudine"), getParametroJsonBody("altitudine"), getParametroJsonBody("dataVisita"), getParametroJsonBody("note"));
            http_response_code(200);
            exit(null);

        case 'eliminaSegnaposto':

            verificaMetodoHttp("DELETE");
            eliminaSegnaposto(recuperaParametroGet("idSegnaposto"));
            http_response_code(200);
            exit(null);

        case 'getSegnapostiByAnno':

            verificaMetodoHttp("GET");
            $response = getSegnapostiByAnno(recuperaParametroGet("anno"));
            http_response_code(200);
            exit(json_encode($response));

        case 'getSegnapostiByCoordinate':

            verificaMetodoHttp("GET");
            $response = getSegnapostiByCoordinate(recuperaParametroGet("lat"), recuperaParametroGet("lon"), recuperaParametroGet("raggio"));
            http_response_code(200);
            exit(json_encode($response));

        case 'getSegnaposti':

            verificaMetodoHttp("GET");
            $response = getSegnaposti(isset($_GET["idTipoSegnaposto"]) ? recuperaParametroGet("idTipoSegnaposto") : null, isset($_GET["isVisitato"]) ? $_GET["isVisitato"] : null, isset($_GET["nome"]) ? $_GET["nome"] : null);
            http_response_code(200);
            exit(json_encode($response));

        case 'getSegnaposto':

            verificaMetodoHttp("GET");
            $response = getSegnaposto(recuperaParametroGet("idSegnaposto"));
            http_response_code(200);
            exit(json_encode($response));


        default:
            throw new OtterGuardianException(500, "Metodo non implementato");
            exit(null);
    }
} catch (AccessoNonAutorizzatoLoginException $e) {
    httpAccessoNonAutorizzatoLogin();
} catch (AccessoNonAutorizzatoException $e) {
    httpAccessoNonAutorizzato();
} catch (MetodoHttpErratoException $e) {
    httpMetodoHttpErrato();
} catch (ErroreServerException $e) {
    httpErroreServer($e->getMessage());
} catch (OtterGuardianException $e) {
    http_response_code($e->getStatus());
    $oggetto = new stdClass();
    $oggetto->codice = $e->getStatus();
    $oggetto->descrizione = $e->getMessage();
    exit(json_encode($oggetto));
} catch (Exception $e) {
    generaLogSuFile("Errore sconosciuto: " . $e->getMessage());
    httpErroreServer("Errore sconosciuto");
}