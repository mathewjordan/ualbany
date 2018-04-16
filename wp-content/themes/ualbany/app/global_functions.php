<?php

if (! function_exists('program_meta_value')) {
  function program_meta_value($val, $list_type='comma-list') {
    ?>
    <?php if ($val != '') : 
      $list_class = 'program-meta__' . $list_type; ?>
      <ul class="<?php echo $list_class; ?>">
        <?php if (is_array($val)) : ?> 
          <?php foreach ($val as $v) : ?>
          <li><?php echo $v; ?></li>
          <?php endforeach; ?>
        <?php else : ?>
          <li><?php echo $val; ?></li>
        <?php endif; ?>
      </ul>
    <?php endif; ?>
    <?php
  }
}

if (! function_exists('program_target_string')) {
  function program_target_string($str) {
    $target = strtolower($str);
    $target = preg_replace("/[^a-z0-9 ]/", '', $target); // Keep only alphanumeric and spaces
    $target = preg_replace('/\s+/', '-', $target); // Replace occurances of 1 or more spaces
    return $target;
  }
}