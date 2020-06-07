<?php

function verifySafaricomPhoneNo($phone)
{
    return preg_match('/^(254){1}[7]{1}([0-2]{1}[0-9]{1}|[9,4]{1}[0-9]{1})[0-9]{6}/', $phone);
}
