<?php
enum ValidationTypes {
    case strict_string;
    case password_pattern;
    case username_pattern;
    case integer;
    case email;
    case float;
    case date;
    case url;
}

function sanitizeString($string)
{
    if(isset($string)) {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }else {
        return '';
    }
}

function sanitizeArray(array $data)
{
    $sanitized = [];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $sanitized[$key] = sanitizeArray($value);
        } else {
            $sanitized[$key] = sanitizeString($value);
        }
    }
    return $sanitized;
}


function isValidArray(array $values, array $rule)
{

    if(count($values) !== count($rule)) {
        throw new Exception('Values and rules arrays must have the same length');
    }

    for ($i = 0; $i < count($values); $i++) {
        switch ($rule[$i]) {
            case ValidationTypes::strict_string:
                if (!is_string($values[$i]) || !ctype_alpha($values[$i])) {
                    return false;
                }
                break;

            case ValidationTypes::password_pattern:
                if (!is_string($values[$i]) || !preg_match('/[^\x20-\x7e]/', $value)) { // pregmatch ASCII 32-126
                    return false;
                } 
                break;

            case ValidationTypes::username_pattern:
                if (!is_string($values[$i]) || !preg_match('/[^A-Za-z0-9.\-_]/', $value)) { 
                    return false;
                } 
                break;

            case ValidationTypes::integer:
                if (!filter_var($values[$i], FILTER_VALIDATE_INT)) {
                    return false;
                                }
                break;

            case ValidationTypes::email:
                if (!filter_var($values[$i], FILTER_VALIDATE_EMAIL)) {
                    return false;
                                }
                break;

            case ValidationTypes::float:
                if (!filter_var($values[$i], FILTER_VALIDATE_FLOAT)) {
                    return false;
                                }
                break;

            case ValidationTypes::date:
                if (!strtotime($values[$i])) {
                    return false;
                                }
                break;

            case ValidationTypes::url:
                if ($value === null) {
                    return true;
                } else
                if (!filter_var($values[$i], FILTER_VALIDATE_URL)) {
                    return false;
                                }
                break;

            default:
            return false;
        }
    }

    return true;
}

if (!empty($errors)) {
    $_SESSION['flash_messages'] = $errors;
    return false;
}

return true;