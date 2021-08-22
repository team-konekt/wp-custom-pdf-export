<?php
/*
Plugin Name: Custom Loops: get_posts()
Description: Demonstrates how to customize the WordPress Loop using get_posts().
Plugin URI:  https://plugin-planet.com/
Author:      Jeff Starr
Version:     1.0
*/

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/vendor/autoload.php';

add_action( 'template_redirect', 'alter_content' );

function alter_content() {

    if (isset($_GET['custom_pdf_export'])) {

        $loader = new \Twig\Loader\FilesystemLoader(plugin_dir_path( dirname( __FILE__ ) ) . 'public/template');
        $twig = new \Twig\Environment($loader);
        
        $indexTemplate = $twig->load('index.html');
        $html = $indexTemplate->render([
            'title' => get_the_title(),
            'content' => get_the_content()
        ]);

        $footerTemplate = $twig->load('footer.html');
        $footer = $footerTemplate->render([
            'logos' => [
                ['src' => 'https://www.konekt.lk/wp-content/uploads/2021/06/ESET-Authorised-Reseller-min.png'],
                ['src' => 'https://www.konekt.lk/wp-content/uploads/2020/10/dell-technology-authorized-partner.png'],
                ['src' => 'https://www.konekt.lk/wp-content/uploads/2020/10/shopify-partner-logo.png']
            ]
        ]);

        $stylesheet = file_get_contents(plugin_dir_path( dirname( __FILE__ ) ) . 'public/template/styles.css');

        $mpdfOptions = [
            'setAutoTopMargin' => 'pad',
            'setAutoBottomMargin' => 'pad',
        ];

        $mpdf = new \Mpdf\Mpdf($mpdfOptions);
        $mpdf->SetHeader('<h1>Header Goes Here</h1>');
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html);
        $mpdf->Output();

        wp_die("Completed!", $html);
    }
    
}