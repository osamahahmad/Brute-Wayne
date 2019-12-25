<?php
    /** Brute Wayne 1.0.0 */

    // Set your password here.
    $password = 'password';

    // Set the number of attempts allowed before further attempts are blocked.
    $attempts = 2;

    // Set the time, in seconds, that these further attempts are blocked.
    $wait = 10;

    // Set the code to be executed on login.
    function onLoad() {
        echo file_get_contents('secure/index.html');
    }

    /** (C) Osamah Ahmad 2019 */

    // Batcave
    session_start();
    ob_start();
    echo '<html><head><meta charset="utf-8"></meta><meta name="robots" content="noindex"></meta><title>Brute Wayne</title></head>';
	if (isset($_SESSION['access']) == false) {
        if (isset($_POST['password']) == false) {
            echo '<body><script>var password = prompt("Password?"); password == null ? window.location.replace("../") : null; var request = new XMLHttpRequest(); request.onload = function () { window.location.replace(""); }; request.open("POST", "", true); request.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); request.send("password=" + password);</script></body></html>';
        } else {
            $allowed = true;
            $brutewayneLocation = 'secure/brutewayne.txt';
            $brutewayne = file_get_contents($brutewayneLocation);
            $brutewayne = explode(' ', $brutewayne);
            if ($brutewayne[0] > $attempts) {
                if ((time() - $brutewayne[1]) < $wait) {
                    $allowed = false;
                }
            }
            if ($allowed) {
                if ($_POST['password'] == $password) {
                    $_SESSION['access'] = true;
                    file_put_contents($brutewayneLocation, '0 0');
                }
            }
            if ($_SESSION['access'] != true) {
                $brutewayne[0] += 1;
                file_put_contents($brutewayneLocation, $brutewayne[0] . ' ' . strval(time()));
            }
        }
    } else {
        ob_end_clean();
        onLoad();
        echo '<p><a href="exit.php">Exit</a></p>';
    }
?>
