<?php

/*
 * Plugin Name: iHumbak WebP Convert
 */
defined( 'ABSPATH' ) || exit;
add_filter( 'wp_generate_attachment_metadata', 'ihumbak_webp_convert', 10, 2 );
function ihumbak_webp_convert( $meta, $filepath ) {
  //print_r($meta);

  $filepath = wp_get_upload_dir()['basedir'].'/'.$meta['file'];
  $file = pathinfo( $filepath );
  switch ($file['extension']) {
    case 'png':
      imagewebp(imagecreatefrompng($filepath), $filepath.'.webp');
      break;
    case 'jpeg':
    case 'jpg':
      imagewebp(imagecreatefromjpeg($filepath), $filepath.'.webp');
      break;
    default:
      break;
  }
  if (!empty($meta['sizes'])) {
    foreach ( $meta['sizes'] as $image ) {
      $filepath = wp_get_upload_dir()['path'] . '/' . $image['file'];
      $file     = pathinfo( $filepath );
      switch ( $file['extension'] ) {
        case 'png':
          imagewebp( imagecreatefrompng( $filepath ), $filepath . '.webp' );
          break;
        case 'jpeg':
        case 'jpg':
          imagewebp( imagecreatefromjpeg( $filepath ), $filepath . '.webp' );
          break;
        default:
          break;
      }
    }
  }
  return $meta;
}
