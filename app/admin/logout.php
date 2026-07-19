<?php
/** Admin logout. */
admin_logout();
header('Location: ' . admin_url('login'));
