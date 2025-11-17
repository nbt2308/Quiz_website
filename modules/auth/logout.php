<?php
$Login = getSession("logged_in");
if ($Login) {
   logout();
}
