<?php
/**
 * Validate and sanitize URIs.
 *
 * @param string $string
 * @return string $string
 */
function checkUri($string) {
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
function checkPlain($string) {
  return filter_var($string, FILTER_SANITIZE_STRING);
}