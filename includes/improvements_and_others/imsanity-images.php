<?php

/**
 * Handler after a file has been uploaded.  If the file is an image, check the size
 * to see if it is too big and, if so, resize and overwrite the original.
 *
 * @param Array $params The parameters submitted with the upload.
 */
function sp_imsanity_handle_upload($params) {

	// If "noresize" is included in the filename then we will bypass imsanity scaling.
	if (strpos($params['file'], 'noresize') !== false) {
		return $params;
	}

	// Make sure this is a type of image that we want to convert and that it exists.
	$oldpath = $params['file'];

	// Let folks filter the allowed mime-types for resizing.
	$allowed_types = apply_filters('sp_imsanity_allowed_mimes', array('image/png', 'image/gif', 'image/jpeg'), $oldpath);

	if (is_string($allowed_types)) {
		$allowed_types = array($allowed_types);
	} elseif (!is_array($allowed_types)) {
		$allowed_types = array();
	}

	if (
		(!is_wp_error($params)) &&
		is_file($oldpath) &&
		is_readable($oldpath) &&
		is_writable($oldpath) &&
		filesize($oldpath) > 0 &&
		in_array($params['type'], $allowed_types, true)
	) {

		// figure out where the upload is coming from.
		//$source = sp_imsanity_get_source();

		$maxw             = SP_IMSANITY_DEFAULT_MAX_WIDTH;
		$maxh             = SP_IMSANITY_DEFAULT_MAX_HEIGHT;
		//$max_width_height = sp_imsanity_get_max_width_height($source);

		// if (is_array($max_width_height) && 2 === count($max_width_height)) {
		//     list($maxw, $maxh) = $max_width_height;
		// }

		list($oldw, $oldh) = getimagesize($oldpath);

		if (($oldw > $maxw + 1 && $maxw > 0) || ($oldh > $maxh + 1 && $maxh > 0)) {
			$quality = SP_IMSANITY_DEFAULT_QUALITY;

			$ftype       = sp_imsanity_quick_mimetype($oldpath);
			$orientation = sp_imsanity_get_orientation($oldpath, $ftype);

			// If we are going to rotate the image 90 degrees during the resize, swap the existing image dimensions.
			if (6 === (int) $orientation || 8 === (int) $orientation) {
				$old_oldw = $oldw;
				$oldw     = $oldh;
				$oldh     = $old_oldw;
			}

			if ($maxw > 0 && $maxh > 0 && $oldw >= $maxw && $oldh >= $maxh && ($oldh > $maxh || $oldw > $maxw) && apply_filters('sp_imsanity_crop_image', false)) {
				$neww = $maxw;
				$newh = $maxh;
			} else {
				list($neww, $newh) = wp_constrain_dimensions($oldw, $oldh, $maxw, $maxh);
			}

			// global $ewww_preempt_editor;
			// if (!isset($ewww_preempt_editor)) {
			//     $ewww_preempt_editor = false;
			// }

			//$original_preempt    = $ewww_preempt_editor;
			//$ewww_preempt_editor = true;
			$resizeresult        = sp_imsanity_image_resize($oldpath, $neww, $newh, apply_filters('sp_imsanity_crop_image', false), null, null, $quality);
			//$ewww_preempt_editor = $original_preempt;

			if ($resizeresult && !is_wp_error($resizeresult)) {
				$newpath = $resizeresult;

				if (is_file($newpath) && filesize($newpath) < filesize($oldpath)) {
					// We saved some file space. remove original and replace with resized image.
					unlink($oldpath);
					rename($newpath, $oldpath);
				} elseif (is_file($newpath)) {

					// The resized image is actually bigger in filesize (most likely due to jpg quality).
					// Keep the old one and just get rid of the resized image.
					unlink($newpath);
				}
			} elseif (false === $resizeresult) {
				return $params;
			} elseif (is_wp_error($resizeresult)) {

				// resize didn't work, likely because the image processing libraries are missing.
				// remove the old image so we don't leave orphan files hanging around.
				unlink($oldpath);

				$params = wp_handle_upload_error(
					$oldpath,
					sprintf(
						/* translators: 1: error message 2: link to support forums */
						esc_html__('Imsanity(inside function) was unable to resize this image for the following reason: %1$s. If you continue to see this error message, you may need to install missing server components. If you think you have discovered a bug, please report it on the Imsanity support forum: %2$s', 'imsanity'),
						$resizeresult->get_error_message(),
						'https://wordpress.org/support/plugin/imsanity'
					)
				);
			} else {
				return $params;
			}
		}
	}

	clearstatcache();

	return $params;
}

/**
 * Imsanity utility functions.
 */

/**
 * Util function returns an array value, if not defined then returns default instead.
 *
 * @param array  $arr Any array.
 * @param string $key Any index from that array.
 * @param mixed  $default Whatever you want.
 */
function sp_imsanity_val($arr, $key, $default = '') {
	return isset($arr[$key]) ? $arr[$key] : $default;
}

/**
 * Retrieves the path of an attachment via the $id and the $meta.
 *
 * @param array  $meta The attachment metadata.
 * @param int    $id The attachment ID number.
 * @param string $file Optional. Path relative to the uploads folder. Default ''.
 * @param bool   $refresh_cache Optional. True to flush cache prior to fetching path. Default true.
 * @return string The full path to the image.
 */
function sp_imsanity_attachment_path($meta, $id, $file = '', $refresh_cache = true) {
	// Retrieve the location of the WordPress upload folder.
	$upload_dir  = wp_upload_dir(null, false, $refresh_cache);
	$upload_path = trailingslashit($upload_dir['basedir']);
	if (is_array($meta) && !empty($meta['file'])) {
		$file_path = $meta['file'];
		if (strpos($file_path, 's3') === 0) {
			return '';
		}
		if (is_file($file_path)) {
			return $file_path;
		}
		$file_path = $upload_path . $file_path;
		if (is_file($file_path)) {
			return $file_path;
		}
		$upload_path = trailingslashit(WP_CONTENT_DIR) . 'uploads/';
		$file_path   = $upload_path . $meta['file'];
		if (is_file($file_path)) {
			return $file_path;
		}
	}
	if (!$file) {
		$file = get_post_meta($id, '_wp_attached_file', true);
	}
	$file_path          = (0 !== strpos($file, '/') && !preg_match('|^.:\\\|', $file) ? $upload_path . $file : $file);
	$filtered_file_path = apply_filters('get_attached_file', $file_path, $id);
	if (strpos($filtered_file_path, 's3') === false && is_file($filtered_file_path)) {
		return str_replace('//_imsgalleries/', '/_imsgalleries/', $filtered_file_path);
	}
	if (strpos($file_path, 's3') === false && is_file($file_path)) {
		return str_replace('//_imsgalleries/', '/_imsgalleries/', $file_path);
	}
	return '';
}

/**
 * Get mimetype based on file extension instead of file contents when speed outweighs accuracy.
 *
 * @param string $path The name of the file.
 * @return string|bool The mime type based on the extension or false.
 */
function sp_imsanity_quick_mimetype($path) {
	$pathextension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
	switch ($pathextension) {
		case 'jpg':
		case 'jpeg':
		case 'jpe':
			return 'image/jpeg';
		case 'png':
			return 'image/png';
		case 'gif':
			return 'image/gif';
		case 'pdf':
			return 'application/pdf';
		default:
			return false;
	}
}

/**
 * Gets the orientation/rotation of a JPG image using the EXIF data.
 *
 * @param string $file Name of the file.
 * @param string $type Mime type of the file.
 * @return int|bool The orientation value or false.
 */
function sp_imsanity_get_orientation($file, $type) {
	if (function_exists('exif_read_data') && 'image/jpeg' === $type) {
		$exif = @exif_read_data($file);
		if (is_array($exif) && array_key_exists('Orientation', $exif)) {
			return (int) $exif['Orientation'];
		}
	}
	return false;
}

/**
 * Check an image to see if it has transparency.
 *
 * @param string $filename The name of the image file.
 * @return bool True if transparency is found.
 */
function sp_imsanity_has_alpha($filename) {
	if (!is_file($filename)) {
		return false;
	}
	if (false !== strpos($filename, '../')) {
		return false;
	}
	$file_contents = file_get_contents($filename);
	// Determine what color type is stored in the file.
	$color_type = ord(substr($file_contents, 25, 1));
	// If we do not have GD and the PNG color type is RGB alpha or Grayscale alpha.
	if (!sp_imsanity_gd_support() && (4 === $color_type || 6 === $color_type)) {
		return true;
	} elseif (sp_imsanity_gd_support()) {
		$image = imagecreatefrompng($filename);
		if (imagecolortransparent($image) >= 0) {
			return true;
		}
		list($width, $height) = getimagesize($filename);
		for ($y = 0; $y < $height; $y++) {
			for ($x = 0; $x < $width; $x++) {
				$color = imagecolorat($image, $x, $y);
				$rgb   = imagecolorsforindex($image, $color);
				if ($rgb['alpha'] > 0) {
					return true;
				}
			}
		}
	}
	return false;
}

/**
 * Check for GD support of both PNG and JPG.
 *
 * @return bool True if full GD support is detected.
 */
function sp_imsanity_gd_support() {
	if (function_exists('gd_info')) {
		$gd_support = gd_info();
		if (is_iterable($gd_support)) {
			if ((!empty($gd_support['JPEG Support']) || !empty($gd_support['JPG Support'])) && !empty($gd_support['PNG Support'])) {
				return true;
			}
		}
	}
	return false;
}

/**
 * Output a fatal error and optionally die.
 *
 * @param string $message The message to output.
 * @param string $title A title/header for the message.
 * @param bool   $die Default false. Whether we should die.
 */
function sp_imsanity_fatal($message, $title = '', $die = false) {
	echo ("<div style='margin:5px 0px 5px 0px;padding:10px;border: solid 1px red; background-color: #ff6666; color: black;'>"
		. ($title ? "<h4 style='font-weight: bold; margin: 3px 0px 8px 0px;'>" . $title . '</h4>' : '')
		. $message
		. '</div>');
	if ($die) {
		die();
	}
}

/**
 * Find the path to a backed-up original (not the full-size version like the core WP function).
 *
 * @param int    $id The attachment ID number.
 * @param string $image_file The path to a scaled image file.
 * @param array  $meta The attachment metadata. Optional, default to null.
 * @return bool True on success, false on failure.
 */
function sp_imsanity_get_original_image_path($id, $image_file = '', $meta = null) {
	$id = (int) $id;
	if (empty($id)) {
		return false;
	}
	if (!wp_attachment_is_image($id)) {
		return false;
	}
	if (is_null($meta)) {
		$meta = wp_get_attachment_metadata($id);
	}
	if (empty($image_file)) {
		$image_file = get_attached_file($id, true);
	}
	if (empty($image_file) || !is_iterable($meta) || empty($meta['original_image'])) {
		return false;
	}

	return trailingslashit(dirname($image_file)) . wp_basename($meta['original_image']);
}

/**
 * Resize an image using the WP_Image_Editor.
 *
 * @param string $file Image file path.
 * @param int    $max_w Maximum width to resize to.
 * @param int    $max_h Maximum height to resize to.
 * @param bool   $crop Optional. Whether to crop image or resize.
 * @param string $suffix Optional. File suffix.
 * @param string $dest_path Optional. New image file path.
 * @param int    $jpeg_quality Optional, default is 82. Image quality level (1-100).
 * @return mixed WP_Error on failure. String with new destination path.
 */
function sp_imsanity_image_resize($file, $max_w, $max_h, $crop = false, $suffix = null, $dest_path = null, $jpeg_quality = 82) {
	if (function_exists('wp_get_image_editor')) {
		$editor = wp_get_image_editor($file);
		if (is_wp_error($editor)) {
			return $editor;
		}
		$editor->set_quality(min(92, $jpeg_quality));

		$ftype = sp_imsanity_quick_mimetype($file);

		// Return 1 to override auto-rotate.
		$orientation = (int) apply_filters('sp_imsanity_orientation', sp_imsanity_get_orientation($file, $ftype));
		// Try to correct for auto-rotation if the info is available.
		switch ($orientation) {
			case 3:
				$editor->rotate(180);
				break;
			case 6:
				$editor->rotate(-90);
				break;
			case 8:
				$editor->rotate(90);
				break;
		}

		$resized = $editor->resize($max_w, $max_h, $crop);
		if (is_wp_error($resized)) {
			return $resized;
		}

		$dest_file = $editor->generate_filename($suffix, $dest_path);

		// Make sure that the destination file does not exist.
		if (file_exists($dest_file)) {
			$dest_file = $editor->generate_filename('TMP', $dest_path);
		}

		$saved = $editor->save($dest_file);

		if (is_wp_error($saved)) {
			return $saved;
		}

		return $dest_file;
	}
	return false;
}
