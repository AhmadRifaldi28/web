<?php
function is_active_path($paths = []) {
  $CI =& get_instance();
  $seg1 = $CI->uri->segment(1);
  $seg2 = $CI->uri->segment(2);
  $current = $seg1 . '/' . $seg2;
  return in_array($current, (array)$paths) ? 'active' : '';
}
