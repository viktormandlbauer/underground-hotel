<?php
function sanitize($data)
{

    if ($data === null) {
        return '';
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function sanitizeArray(array $data)
{
    $sanitized = [];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $sanitized[$key] = sanitizeArray($value);
        } else {
            $sanitized[$key] = sanitize($value);
        }
    }
    return $sanitized;
}


function isValidArray(array $values, array $rule)
{
    for ($i = 0; $i < count($values); $i++) {
        if (!isset($values[$i])) {
            continue;
        }
        switch ($rule[$i]) {
            case "strict_string":
                if (!is_string($values[$i]) || !ctype_alpha($values[$i])) {
                    return false;
                }
                break;

            case "open_string":
                // Verbot der Zeichen: - + * # ' \ } { ] [ ( ) / & % $ § " !
                $forbiddenCharsPattern = '/[-+\*#\'{}\]\[()\&%$§"!]/';
                if (!is_string($value) || preg_match($forbiddenCharsPattern, $values[$i])) {
                    return false;
                } 
                break;

            case "integer":
                if (!filter_var($values[$i], FILTER_VALIDATE_INT)) {
                    return false;
                                }
                break;

            case "email":
                if (!filter_var($values[$i], FILTER_VALIDATE_EMAIL)) {
                    return false;
                                }
                break;

            case "float":
                if (!filter_var($values[$i], FILTER_VALIDATE_FLOAT)) {
                    return false;
                                }
                break;

            case "date":
                if (!strtotime($values[$i])) {
                    return false;
                                }
                break;

            case "password_confirm":
                if (empty($values[$i-1]) || empty($values[$i])) {
                    return false;
                } elseif ($values[$i-1] !== $values[$i]) {
                    return false;
                                }
                break;

            case "url":
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