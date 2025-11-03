<?php
$Login = getSession("logged_in");
if ($Login) {
    deleteSession("user_id");
    deleteSession("logged_in");
    deleteSession("user_name");
    deleteSession("user_role");
    header("Location:?module=home&action=index");
}
