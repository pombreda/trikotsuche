<?php
/**
 * Validate and sanitize URIs.
 *
 * @param string $string
 * @return string $string
 */
function check_uri($string) {
  # Extract scheme
  $arr_parts = parse_url($string);
  if (!isset ($arr_parts['scheme'])) {
    return FALSE;
  }
  $scheme = $arr_parts['scheme'];

  # Check if it is an email address
  if ('mailto' == $scheme) {
    $email = $arr_parts['path'];
    if (FALSE === filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return FALSE;
    }
    $string = 'mailto:' . filter_var($email, FILTER_SANITIZE_EMAIL);
  }

  # Check if it is a url
  else {
    if (FALSE === filter_var($string, FILTER_VALIDATE_URL)) {
      return FALSE;
    }
    $string = filter_var($string, FILTER_SANITIZE_URL);
    # TODO make internal relative URLs absolute
  }

  # Encode &<>"' for security reasons
  return htmlentities($string, ENT_QUOTES);
}

/**
 * Remove <>? for security reasons.
 *
 * @param string $string
 * @return string $string
 */
function check_plain($string) {
  return filter_var($string, FILTER_SANITIZE_STRING);
}

/**
 * Get base path of current app
 *
 * @param void
 * @return string $base_path;
 */
function base_path() {
  if (isset ($_SERVER['HTTP_HOST'])) {
    // As HTTP_HOST is user input, ensure it only contains characters allowed
    // in hostnames. See RFC 952 (and RFC 2181).
    // $_SERVER['HTTP_HOST'] is lowercased here per specifications.
    $_SERVER['HTTP_HOST'] = strtolower($_SERVER['HTTP_HOST']);
    if (!preg_match('/^\[?(?:[a-z0-9-:\]_]+\.?)+$/', $_SERVER['HTTP_HOST'])) {
      // HTTP_HOST is invalid, e.g. if containing slashes it may be an attack.
      header('HTTP/1.1 400 Bad Request');
      exit;
    }
  } else {
    // Some pre-HTTP/1.1 clients will not send a Host header. Ensure the key is
    // defined for E_ALL compliance.
    $_SERVER['HTTP_HOST'] = '';
  }
  # FIXME $base_url is not set before in this function
  if (isset ($base_url)) {
    // Parse fixed base URL from settings.php.
    $parts = parse_url($base_url);
    if (!isset ($parts['path'])) {
      $parts['path'] = '';
    }
    $base_path = $parts['path'] . '/';
    // Build $base_root (everything until first slash after "scheme://").
    $base_root = substr($base_url, 0, strlen($base_url) - strlen($parts['path']));
  } else {
    // Create base URL
    $base_root = (isset ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

    $base_url = $base_root .= '://' . $_SERVER['HTTP_HOST'];

    // $_SERVER['SCRIPT_NAME'] can, in contrast to $_SERVER['PHP_SELF'], not
    // be modified by a visitor.
    if ($dir = trim(dirname($_SERVER['SCRIPT_NAME']), '\,/')) {
      $base_path = "/$dir";
      $base_url .= $base_path;
      $base_path .= '/';
    } else {
      $base_path = '/';
    }
  }
  return $base_path;
}

function check_array($var, $key = false) {
  if (!isset($var)) return false;
  if (false !== $key && isset($var[$key]) && is_array($var[$key])) return true;
  if (is_array($var)) return true;
  return false;
}

function not_false($a) {
  return false !== $a;
}
