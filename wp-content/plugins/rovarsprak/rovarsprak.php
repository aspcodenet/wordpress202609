<?php
/**
 * Plugin Name:       Rövarspråket
 * Plugin URI:        https://example.com/rovarspraket
 * Description:       Ett plugin som översätter inläggstext till Rövarspråket.
 * Version:           1.0.0
 * Author:            Din Github-profil eller ditt namn
 * Author URI:        https://github.com/dittanvändarnamn
 * Text Domain:       rovarspraket
 * Domain Path:       /languages
 */

// Se till att filen inte kan nås direkt
defined( 'ABSPATH' ) || die();


 function rovarspraket_filter( $content ) {
        $vokaler = array( 'a', 'e', 'i', 'o', 'u', 'y', 'å', 'ä', 'ö', 'A', 'E', 'I', 'O', 'U', 'Y', 'Å', 'Ä', 'Ö', ' ' );
        $konsonanter = array( 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'z' );
        $oversatt_text = '';

        // Dela upp strängen i enskilda tecken
        $tecken_array = preg_split('//u', $content, -1, PREG_SPLIT_NO_EMPTY);

        foreach ( $tecken_array as $tecken ) {
            // Kolla om tecknet är en stor bokstav
            $is_upper = ctype_upper( $tecken );

            // Konvertera tecknet till gemen för att jämföra mot konsonant-arrayen
            $tecken_lower = strtolower( $tecken );
            
            // Hoppa över om tecknet är en vokal eller ett mellanslag
            if ( in_array( $tecken, $vokaler ) ) {
                $oversatt_text .= $tecken;
                continue;
            }

            // Kontrollera om tecknet är en konsonant
            if ( in_array( $tecken_lower, $konsonanter ) ) {
                $nytt_tecken = $tecken_lower . 'o' . $tecken_lower;
                
                // Hantera stora bokstäver
                if ( $is_upper ) {
                    $nytt_tecken = strtoupper( $nytt_tecken );
                }
                $oversatt_text .= $nytt_tecken;
            } else {
                // Om tecknet inte är en vokal, konsonant eller mellanslag, lägg till det oförändrat.
                $oversatt_text .= $tecken;
            }
        }
        
        return $oversatt_text;
    }

    // STEFAN  -> SOS    TOT  E FOF A NON
add_filter("the_title","rovarspraket_filter");
?>