<?php
/**
 * Plugin Name:       Capital letter
 * Plugin URI:        https://example.com/
 * Description:       En plugin som gör om text till stora bokstäver.
 * Version:           1.0.0
 * Author:            Stefan
 * Author URI:        https://example.com/
 * Text Domain:       bla
 */

// I en plugin bygg en funktion som gör nåt - carten/kunden kontrollerar om handlat 1000 kr skapa en rad 5% rabatt
function capital_letters( $content ) {
    return strtoupper( $content );
}

function add_smiley( $content ) {
    return $content  . ";)";
}


// När Wordpress/woo ritar ut en sida - så gör den ju många saker  efter varandra
// först header, sen title, sen content, sen footer osv osv
// plugins (actions/filters) låter oss "jacka in" före/efter/under valda händelser
// När du ritar ut footer - anropa min funktion (PENSIONÄRSFREDAG i footer tex)

// När du ritar ut content - anropa min funktion - jag vill modifiera innan du ritar ut = FILTER
// eventet heter the_content (dvs när WP ska rita ut content för en post så händer händelsen/eventet "the_content")
add_filter("the_content","capital_letters");
add_filter("the_title","add_smiley");

?>






