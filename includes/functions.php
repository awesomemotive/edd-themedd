<?php

/**
 * Is EDD active
 *
 * @return bool
 */
function trustedd_is_edd_active() {
	return class_exists( 'Easy_Digital_Downloads' );
}
