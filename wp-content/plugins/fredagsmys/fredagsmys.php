<?php
/**
 * Plugin Name: Min Enkla Action - Fredagsmys
 * Description: Ett enkelt plugin som visar FREDAGSMYS i footern om det är fredag.
 * Version: 1.1
 * Author: Ditt Namn
 */


add_action('wp_footer', function() {
    // Kontrollerar om det är fredag (5 = Fredag enligt ISO-8601)
    if (date('N') == 5) {
        echo '<p style="text-align: center;">fredagsmys</p>';
    }
});
?>
