<?php
/**
 * Plugin Name:       Word Count
 * Plugin URI:        http://saberhr.com/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Saber Hossen Rabbani
 * Author URI:        http://saberhr.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       word-count
 * Domain Path:       /languages
 */

/*
function wordcount_activation_hook () {}
register_activation_hook(__FILE__ , 'wordcount_activation_hook');
function wordcount_deactivation_hook () {}
register_deactivation_hook(__FILE__ , 'wordcount_deactivation_hook');
*/

function wordcount_load_textdomain () {
    load_plugin_textdomain('word-count', false, dirname(__FILE__) . '/languages');
}
add_action('plugins_loaded', 'wordcount_load_textdomain');


function wordcount_count_words ($content) {
    $stripped_tag = strip_tags($content);
    $word_num = str_word_count($stripped_tag);
    $label = __('Total Number of Words', 'word-count');
    $label = apply_filters("wordcount_heading", $label);
    $tag = apply_filters("wordcount_tag", "h2");
    $content .= sprintf("<%s>%s : %s</%s>", $tag, $label, $word_num, $tag);
    return $content;
}
add_filter('the_content', 'wordcount_count_words');



function wordcount_reading_time ($content) {
    $stripped_tag = strip_tags($content);
    $word_num = str_word_count($stripped_tag);
    $reading_minute = floor($word_num/200);
    $reading_seconds = floor($word_num % 200 / (200 / 60));
    $is_visible = apply_filters('wordcount_display_reading_time', 1);
    if ($is_visible) {
        $label = __('Total Reading Time', 'word-count');
        $label = apply_filters("wordcount_heading", $label);
        $tag = apply_filters("wordcount_tag", "h2");
        $content .= sprintf("<%s>%s : %s minutes %s seconds</%s>", $tag, $label, $reading_minute, $reading_seconds, $tag);
    }

    return $content;
}


add_filter('the_content', 'wordcount_reading_time');


