<?php
/**
 * Plugin Name:       Pdf Embedder Fay
 * Plugin URI:        https://wordpress.org/plugins/pdf-and-documents-embedder
 * Description:       Pdf Embedder Fay is a powerful WordPress plugin that makes it easy to embed PDF files into your website.
 * Version:           1.10.1
 * Requires at least: 4.6
 * Requires PHP:      5.0.0
 * Author:            ByteLabX
 * Author URI:        https://bytelabx.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pdf-embedder-fay
 */


if ( ! defined( 'ABSPATH' ) ) {
    die( 'You cannot jump here!!' );
}

//Redirect to plugin to any page
register_activation_hook( __FILE__, 'pdf_embed_fay_plugin_activate' );
add_action('admin_init', 'pdf_embed_fay_plugin_redirect');

function pdf_embed_fay_plugin_activate(){
	add_option('pdf_embed_fay_plugin_do_activation_redirect', true);
}

function pdf_embed_fay_plugin_redirect(){
	if (get_option('pdf_embed_fay_plugin_do_activation_redirect', false)){
		delete_option('pdf_embed_fay_plugin_do_activation_redirect');
		if(!isset($_GET['activate-multi']))
		{
			//This is custom post link
			wp_redirect("themes.php?page=pdf-embedder-fay");
		}
	}
}


function pdf_embedder_fay_func_short( $atts ) {
    $atts = shortcode_atts(
        array(
            'src' => '',
            'width' => '',
            'height' => '',
            'position' => '',
        ),
        $atts,
        'pdf_fay'
    );
    return sprintf('<div style="text-align: %s;"><iframe src="%s" width="%s" height="%s">
    </iframe></div>',$atts['position'],$atts['src'], $atts['width'], $atts['height']);

}
add_action( 'init', 'pdf_embedder_fay_shortcode' );

function pdf_embedder_fay_shortcode() {
    add_shortcode( 'pdf_fay', 'pdf_embedder_fay_func_short' );
}


function pdf_embedder_fay_enqueue_admin_script( $hook ) {

	if ( 'appearance_page_pdf-embedder-fay' === $hook ) {
		wp_enqueue_script( 'sweetalert', plugin_dir_url( __FILE__).'admin/js/sweetalert2@10.js', null, '1.0', true );
		wp_enqueue_script( 'pdf-embedder-fay', plugin_dir_url( __FILE__).'admin/js/main.js', array('jquery'), '1.0', true );

		wp_register_style( 'pdf-embedder-fay-style',  plugin_dir_url( __FILE__ ) . 'admin/css/style.css' );
		wp_enqueue_style( 'pdf-embedder-fay-style' );
	}
}
add_action( 'admin_enqueue_scripts', 'pdf_embedder_fay_enqueue_admin_script' );




//Add sub page to the menu
add_action('admin_menu', 'pdf_embedder_fay_custom_submenu_page');
function pdf_embedder_fay_custom_submenu_page() {
	add_submenu_page(
		'themes.php',
		'Pdf Embedder Fay',
		'Pdf Embedder Fay',
		'manage_options',
		'pdf-embedder-fay',
		'pdf_embedder_fay_submenu_page_callback'
    );
}



function pdf_embedder_fay_submenu_page_callback()
{

	global $title;
	print "<h1>$title</h1>";

	if (!is_admin()){
	    _e('Only admin can access this page','pdf-embedder-fay');
	    die();
    }

	?>

    <h2>For free support</h2>

    <p>Send me an email to fayjur500@gmail.com</p>

    <div class="left-pdf-fay">

        <table class="form-table" role="pdf-width-table">

            <tbody>
            <tr>
                <th scope="row"><label for="pdf-url-fay">Url of PDF</label></th>
                <td><input type="text" class="regular-text pdf-fay-input" id="pdf-url-fay" placeholder="Enter valid PDF url" class="regular-text"></td>
            </tr>

            <tr>
                <th scope="row"><label for="pdf-width-fay">Width</label></th>
                <td>
                    <input type="number" class="regular-text pdf-fay-input" id="pdf-width-fay" value="100" class="regular-text" placeholder="Enter width of the PDF">
                    <select id="pdf-width-type" class="pdf-fay-input">
                        <option selected="selected" value="%">%</option>
                        <option value="px">px</option>
                    </select>
                    <p class="description" id="pdf-width-fay-description">For the full width of PDF view, you have to select 100% width.</p>
                </td>
            </tr>


            <tr>
                <th scope="row"><label for="pdf-height-fay">Height</label></th>
                <td>
                    <input  type="number" id="pdf-height-fay" value="500" class="regular-text" placeholder="Enter height of the PDF">
                    <select name="default_role" class="pdf-fay-input" id="pdf-height-type">

                        <option selected="selected" value="px">px</option>
                        <option value="%">%</option>
                    </select>
                </td>
            </tr>


            <tr>
                <th scope="row"><label for="pdf-align-fay">Align/Position </label></th>
                <td>
                    <select id="pdf-align-fay" class="pdf-fay-input">
                        <option selected="selected" value="center">Center</option>
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                </td>
            </tr>




            <tr>
                <th scope="row"><label for="default_role">ShortCode</label></th>
                <td>
                    <textarea id="pdf-input-generate" rows="4" cols="50" disabled></textarea>
                    <input type="button" id="pdf-copy-generate" class="button button-secondary" value="Copy ShortCode">
                </td>
            </tr>


            <tr>
                <th scope="row"></th>
                <td>
                    <input type="button" id="pdf-btn-generate" class="button button-primary" value="Generate Shortcode">

                </td>
            </tr>



            </tbody></table>
    </div>


    <div class="right-pdf-fay">
        <div id="container-iframe">
            <embed id="preview-iframe" src="" width="100%" height="500px"/>
            </embed>
        </div>
        <br>
        <hr>
        <div class="preview-btn-container">
            <input type="button" id="pdf-preview-button" class="button button-primary" value="Preview">
        </div>

    </div>


	<?php
}