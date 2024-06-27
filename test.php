<?php
$hashedSecret = password_hash('kurokos11', PASSWORD_BCRYPT);
echo $hashedSecret;
