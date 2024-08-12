<?php

/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://github.com/timber/starter-theme
 */

namespace App;

use Timber\Timber;

// Load Composer dependencies.
require_once __DIR__ . '/StarterSite.php';

Timber::init();

new StarterSite();

// PBF-6: Sekce Tym (post type team)
require_once __DIR__ . '/post_type-team.php';
new \PostTypeTeam();