<?php
session_start();

$uri = $_POST['urlrewrite'] ?: ($_SERVER['REQUEST_METHOD'] == "HEAD" ? $_SERVER['HTTP_URI'] : $_SERVER['REQUEST_URI']);
/*
    SPIEGAZIONE URI:
    - SE E' AJAX PRELEVA IL PARAMETRO POST urlrewrite
    - SE E' LA INDEX CHE PROVA A LEGGERE L'HEADER PER SETTARE I META, PRENDE LA VARIABILE URI SETTATA DAL getHeaders
    - SE E' L'INCLUDE DEL BODY DELLA INDEX ALLORA LEGGE SEMPLICEMENTE LA RICHIESTA
*/

$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
$webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME']);
$mods = [24, 25, 28, 1];
$nq = 0;
error_reporting(E_ERROR | E_PARSE);

$c = mysqli_connect("172.31.47.88", "pekan_fr", "oq64x8I~", "final_round", 6666);
function security_query($q, $p = [])
{
    global $c;
    $types = "";
    preg_match_all("/\[([^\]]*)\]/", $q, $matches);
    if (count($matches[1]) > 0) {
        foreach ($matches[1] as $key => $value) {
            $types .= $value;
            $q = str_replace("[$value]", "?", $q);
        }

        if ($stmt = mysqli_prepare($c, $q)) {
            if (mysqli_stmt_bind_param($stmt, $types, ...$p)) {
                if (mysqli_stmt_execute($stmt)) {
                    return mysqli_stmt_get_result($stmt);
                }
            } else die('mysqli_stmt_bind_param error: ' . mysqli_stmt_error($stmt));
        }
    } else {
        return mysqli_query($c, $q);
    }
}

function securityarray($arr)
{
    /*
    global $c;
    foreach ($arr as $key => $value) {
        if (is_array($arr[$key])) {
            foreach ($arr[$key] as $key2 => $value2) {
                $arr[$key][$key2] = $c->mres($value2);
            }
        } else
            $arr[$key] = $c->mres($value);
    }
    */
    return $arr;
}

function htmlarray($arr, $tags = 0)
{
    foreach ($arr as $key => $value) {
        if (is_array($arr[$key])) {
            foreach ($arr[$key] as $key2 => $value2) {
                if ($tags)
                    $arr[$key][$key2] = htmlentities($value2);
                else
                    $arr[$key][$key2] = strip_tags($value2);
            }
        } else {
            if ($tags)
                $arr[$key] = htmlentities($value);
            else
                $arr[$key] = strip_tags($value);
        }
    }
    return $arr;
}
function print_array($array)
{
    print_r("<pre>");
    print_r($array);
    print_r("</pre>");
}
function redirect($page)
{
    if ($page != "") {
        header("location:$page");
        echo "<script type='text/javascript'>window.location.href='$page'</script>";
        exit();
    }
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
function validatePhoneNumber($phone)
{
    // Allow +, - and . in phone number
    $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    // Remove "-" from number
    $phone_to_check = str_replace("-", "", $filtered_phone_number);
    // Check the lenght of number
    // This can be customized if you want phone number from a specific country
    if (strlen($phone_to_check) < 9 || strlen($phone_to_check) > 14) {
        return false;
    } else {
        return true;
    }
}

function mb_unserialize($string)
{
    $string = mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    $string = preg_replace_callback(
        '/s:([0-9]+):"(.*?)";/',
        function ($match) {
            return "s:" . strlen($match[2]) . ":\"" . $match[2] . "\";";
        },
        $string
    );
    return unserialize($string);
}

function email($from, $from_name, $to, $subject, $body)
{ //manda un'email
    if (isset($to)) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: ' . $from_name . ' <' . $from . '>';
        $h = implode("\r\n", $headers);
        return mail($to, $subject, $body, $h);
    } else return false;
}

/*SMTP EMAIL*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function smtpEmail($from, $from_name, $to, $subject, $body, $attachment = "")
{
    global $webRoot;
    require $webRoot . '/plugins/phpmailer/src/Exception.php';
    require $webRoot . '/plugins/phpmailer/src/PHPMailer.php';
    require $webRoot . '/plugins/phpmailer/src/SMTP.php';
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'authsmtp.securemail.pro';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'no-reply@finalround.it';                     //SMTP username
        $mail->Password = 'Y*Uj65%pcY&AeAdw';                               //SMTP password
        $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption

        $mail->Port = 465;

        $mail->setFrom($from, $from_name);
        $mail->addAddress($to);

        if ($attachment != "" && $attachment['error'] == UPLOAD_ERR_OK) {
            $mail->AddAttachment($attachment['tmp_name'], $attachment['name']);
        }

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {
        return $e;
    }
}

function upload_photo($file, $url, $maxwidth = "", $rotate = 0)
{
    if ($maxwidth == "")
        $maxwidth = 1920;

    $uploadOk = 1;
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }
    // Check file size
    if ($file["size"] > 10485760) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    $imageFileType = pathinfo($file["name"], PATHINFO_EXTENSION);
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
        $error = "Sorry, only JPG, JPEG, PNG and WEBP files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk != 0) {
        if ($imageFileType == "png") {
            $image = imagecreatefrompng($file['tmp_name']);
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        } else
            $image = imagecreatefromstring(file_get_contents($file['tmp_name']));

        if (getimagesize($file["tmp_name"])[0] > $maxwidth)
            $image = imagescale($image, $maxwidth);

        if ($rotate > 0)
            $image = imagerotate($image, 360 - $rotate, 0);

        imagewebp($image, $url, 80);
        return true;
    } else {
        return false;
    }
}

function checkCaptcha($response)
{
    if (dev()) return true;
    if (isset($response)) {
        $secretKey = "6LeW0tQiAAAAADjTljHQeo7j8iApsUB7Q4wVPqhu";
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($response);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        return $responseKeys["success"];
    } else
        return false;
}

function significant_number($n, $decimals = 2)
{
    $n = number_format($n, 8);
    $n = str_replace(",", "", $n);
    $i = 0;
    foreach (str_split(str_replace(".", "", $n)) as $key => $value) {
        if ($value == 0)
            $i++;
        else
            break;
    }
    return str_replace(",", "", rtrim(floorp($n, max(1, $i) + $decimals - 1), ".0"));
}

function floorp($val, $precision)
{
    $mult = pow(10, $precision); // Can be cached in lookup table        
    return number_format(floor($val * $mult) / $mult, $precision);
}

function curl_call($url, $method = "GET", $header = "")
{
    $ch = curl_init($url);

    /* SET HEADER */
    if ($header != "") {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $header = "";
    }
    /* SET HEADER */

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    return json_decode(curl_exec($ch), true);
}

function nl2br2($string)
{
    return preg_replace('/\v+|\\\r\\\n/Ui', '<br>', $string);
}

function nl2brt($string)
{
    return preg_replace('/\v+|\\\r\\\n/Ui', '&#13;&#10;', $string);
}
function nl2p($string)
{
    $string = preg_replace('~\r\n?~', "\n", $string);
    $string = explode("\n\n", $string);
    $r = "";
    foreach ($string as $line) {
        $line = str_replace("\n", '<br />', $line);
        $line = trim($line, "<br />");
        $r .= "<p>$line</p>";
    }
    return $r;
}

function include_params($path)
{
    $params = explode("?", $path)[1];
    $params = explode("&", $params);
    foreach ($params as $v) {
        $p = explode("=", $v);
        if (count($p) == 1)
            $_GET[$v] = ""; //se è un parametro senza value (es. ?email-sent) imposta una variabile vuota.
        else
            $_GET[$p[0]] = $p[1];
    }
    return explode("?", $path)[0];
}
function deleteAll($dir)
{
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            deleteAll($file);
        else
            unlink($file);
    }
    rmdir($dir);
}
function removeNullValues($array)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = removeNullValues($value);
            if ($array[$key] === [])
                unset($array[$key]);
        } else {
            if ($value == "")
                unset($array[$key]);
        }
    }
    return $array;
}
function timePassed($date)
{
    $start_date = new DateTime($date);
    $since_start = $start_date->diff(new DateTime());
    if (($years = $since_start->y) != 0)  return $years . "a";
    else if (($months = $since_start->m) != 0) return $months . "m";
    else if (($days = $since_start->d) != 0) return $days . "g";
    else if (($hours = $since_start->h) != 0) return $hours . "h";
    else if (($minutes = $since_start->i) != 0) return $minutes . "m";
    else if (($seconds = $since_start->s) != 0) return $seconds . "s";
    else return "adesso";
}
function strtourl($string)
{
    $transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
    $normalized = $transliterator->transliterate($string);
    return trim(preg_replace('/\W+/', '-', strtolower(trim($normalized))), "-");
}

function getIP()
{

    # PHP7+
    $clientIP = $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER["HTTP_CF_CONNECTING_IP"] # when behind cloudflare
        ?? $_SERVER['HTTP_X_FORWARDED']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['HTTP_FORWARDED']
        ?? $_SERVER['HTTP_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? '0.0.0.0';

    # Earlier than PHP7
    $clientIP = '0.0.0.0';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $clientIP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        # when behind cloudflare
        $clientIP = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $clientIP = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $clientIP = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $clientIP = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $clientIP = $_SERVER['REMOTE_ADDR'];
    }

    return $clientIP;
}

function dev()
{
    return $_SERVER['SERVER_NAME'] == "www.beautiful-elbakyan.15-161-195-66.plesk.page";
}

function security_uri($uri = "", $idpost = NULL)
{
    if (dev()) return true;
    global $c;
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $uri = str_replace("https://www.finalround.it/", "", $uri); //se arriva uno SPA con link diretto a final, (tipo un riferimento ad un articolo di final dentro un articolo di final con link esplicito)
    $uri = ($uri != "") ? ((strpos($uri, "/") !== 0) ? "/$uri" : $uri) : $_SERVER['REQUEST_URI'];

    /* CHECK SPAM BAN */
    if (security_query("SELECT (SELECT count(ip) FROM fr_tracks where date > date_sub(now(), interval 1 minute) and ip = [s]) + (SELECT count(ip) FROM fr_tracks_err where date > date_sub(now(), interval 1 minute) and ip = [s]) as count", array($ip, $ip))->fetch_assoc()['count'] > 60)
        security_query("INSERT into fr_users_bans (ip) values ([s])", array($ip));
    /* CHECK SPAM BAN */

    if (
        $uri == "/" ||
        preg_match_all("/^\/(anteprime|monografie|notizie|recensioni|rubriche|board-games|vr|pc|xbox-series-x|nintendo-switch|ps5|ps4|login|registrazione|account|privacy-policy|cookie-policy|cerca|supporters)$/", $uri) ||
        preg_match_all("/^\/(anteprime|monografie|notizie|recensioni)\/(board-games|vr|pc|xbox-series-x|nintendo-switch|ps5|ps4)$/", $uri) ||
        preg_match("/^\/(anteprime|monografie|notizie|recensioni|rubriche)\/[0-9]*\/[a-z0-9\-]*$/", $uri) ||
        preg_match("/^\/staff\/[0-9]*\/[a-z0-9\-]*$/", $uri) ||
        preg_match("/^\/(anteprime|monografie|notizie|recensioni|rubriche)\/[0-9]*\/[a-z0-9\-]*[?][a-z]*=[a-zA-Z0-9\-\_]*$/", $uri) ||
        preg_match("/^\/registrazione$|^\/registrazione([?]verify-sent)(=[^@]+@[^@]+\.[^@]{2,}$|)$/", $uri) ||
        preg_match("/^\/[?][a-z]*=[a-zA-Z0-9\-\_]*$/", $uri) ||
        (preg_match("/^\/[?]page=admin\//", $uri)  && $_SESSION['user']['admin'] == 1)
    ) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) { //controlla se è un ip valido altrimente interrompe lo script. (non serve bannare, se l'ip non è valido nemmeno ti scrivo nel db)
            if (security_query("SELECT ip from fr_users_bans where ip = [s] and date > TIME(DATE_SUB(NOW(), INTERVAL 1 HOUR))", array($ip))->fetch_assoc()['ip'] != "") {
                echo "<p class='text-center p-4 d-block'>Stai spammando un po' troppo. Riprova tra 1 ora.</p>";
                exit();
            }
            if ($idpost != NULL) {
                security_query("INSERT into fr_tracks (ip,uri,idpost) values ([s],[s],[i])", array($ip, $uri, $idpost));
            } else {
                security_query("INSERT into fr_tracks (ip,uri) values ([s],[s])", array($ip, $uri));
            }
            return true;
        } else {
            exit();
        }
    } else {
        security_query("INSERT into fr_tracks_err (ip,uri,debug) values ([s],[s],[s])", array($ip, $uri, json_encode($_SERVER)));
        return false;
    }
}

function login($r)
{
    $_SESSION['user'] = $r;
    if ($_SESSION['user']['twitch_data'] != "")
        $_SESSION['user']['twitch_data'] = json_decode($_SESSION['user']['twitch_data'], 1);
    if ($_SESSION['user']['password'] == "") $_SESSION['user']['password'] = -1; //serve per il cambio password in caso di pw non impostata
    else
        unset($_SESSION['user']['password']);

    $_SESSION['toasts'] = array("Accesso effettuato");
}

/* TWITCH API */
$twitch_client_id = "al25scyvrqw5brro9l74b72k11ej2k";
$twitch_client_secret = "cq64zqu4geqrzxqkmqb8uhvb4iywwd";
$twitch_redirect_uri = "https://www.finalround.it/php/twitch_login.php";

function twitch_getToken()
{
    global $c, $twitch_client_id, $twitch_client_secret;
    if ($_SESSION['user']['twitch_data']['access_token'] != "") {
        if (time() >= $_SESSION['user']['twitch_data']['expires_in']) {
            $result = curl_call("https://id.twitch.tv/oauth2/token?grant_type=refresh_token&refresh_token=" . urlencode($_SESSION['user']['twitch_data']['refresh_token']) . "&client_id=$twitch_client_id&client_secret=$twitch_client_secret", "POST");
            if ($result['access_token'] != "") {

                $_SESSION['user']['twitch_data']['access_token'] = $result['access_token'];
                $_SESSION['user']['twitch_data']['expires_in'] = $result['expires_in'] + time();
                $_SESSION['user']['twitch_data']['refresh_token'] = $result['refresh_token'];
                $data = json_encode($_SESSION['user']['twitch_data']);

                security_query("update fr_users set twitch_data = [s] where id = {$_SESSION['user']['id']}", array($data));
                return $result['access_token'];
            } else return false;
        } else return $_SESSION['user']['twitch_data']['access_token'];
    } else return false;
}
function twitch_GetUsers($login = "", $token = "")
{
    global $twitch_client_id;

    if ($token == "")
        $token = twitch_getToken();

    if ($token != "") {
        // se non è indicato LOGIN, prenderà le info dell'utente loggato su twitch, altrimenti ricaverà le info del nome indicato
        if ($login != "") $login = "?login=$login";
        $header = array('client-id: ' . $twitch_client_id, 'Authorization: Bearer ' . $token);
        $result = curl_call("https://api.twitch.tv/helix/users$login", "GET", $header);
        return $result;
    } else return false;
}
function twitch_GetSubInfo($broadcaster_id, $user_id = "", $token = "")
{
    global $twitch_client_id;

    if ($user_id == "")
        if (($user_id = $_SESSION['user']['twitch_data']['id']) == "") return false;

    if ($token == "")
        if (($token = twitch_getToken()) == false) return false;

    if (!is_int($broadcaster_id)) {
        $broadcaster_id = twitch_GetUsers($broadcaster_id, $token)['data']['0']['id'];
    }
    $r = curl_call("https://api.twitch.tv/helix/subscriptions/user?broadcaster_id=$broadcaster_id&user_id={$user_id}", "GET", array('client-id: ' . $twitch_client_id, 'Authorization: Bearer ' . $token));
    return $r['data']['0'];
}
/* TWITCH API */

function parseHeaders($headers)
{
    $head = array();
    foreach ($headers as $k => $v) {
        $t = explode(':', $v, 2);
        if (isset($t[1]))
            $head[trim($t[0])] = trim($t[1]);
        else {
            $head[] = $v;
            if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out))
                $head['reponse_code'] = intval($out[1]);
        }
    }
    return $head;
}
function getHeaders($url)
{
    $context = stream_context_create([
        'http' => [
            'method' => "HEAD",
            'header' => [
                "Cookie: " . $_SERVER['HTTP_COOKIE'],
                "Uri: " . trim($_SERVER['REQUEST_URI'], "/")
            ],
        ]
    ]);
    session_write_close(); // unlock the file
    $contents = file_get_contents($url, false, $context);
    session_start(); // Lock the file
    return parseHeaders($http_response_header);
}
function setHeaders($array)
{
    foreach ($array as $key => $value) {
        if ($value == "") continue;
        if ($key == "meta-jsonld")
            $value = base64_encode(json_encode($value, 1));
        header("{$key}: {$value}");
    }
    if ($_SERVER['REQUEST_METHOD'] == "HEAD") //SE E' LA INDEX CHE LEGGE L'HEADER ALLORA BLOCCA QUI L'ESECUZIONE
        exit();
}


function getPatreonBadge($tier = null, $title = "")
{
    if ($tier == null) return "";
    return "<img src='img/tiers/{$tier}.png'  class='tier align-middle' title='$title'/> ";
}
