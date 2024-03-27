<?php

function isLoginSessionExpired() {
    $login_session_duration = 10;

    if (isset($_SESSION['login_time']) and isset($_SESSION["username"])){
        if (((time() - $_SESSION['login_time']) > $login_session_duration)){
            return true;
        }
    }
    return false;
}
