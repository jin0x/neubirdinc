<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$custom_code = get_field('custom_code') ? : '';

echo $custom_code;