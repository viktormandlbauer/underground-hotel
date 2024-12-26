<?php

function isValidRequest($values, $rules)
{
    for ($i = 0; $i < count($values); $i++) {
        if ($rules[$i] == "string") {
            if (!is_string($values[$i])) {
                return false;
            }
        } else if ($rules[$i] == "integer") {
            if (!is_int($values[$i])) {
                return false;
            }
        } else if ($rules[$i] == "email") {
            if (!filter_var($values[$i], FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
    }
    return true;
}