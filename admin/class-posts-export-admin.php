<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/raosuresh94/
 * @since      1.0.0
 *
 * @package    Posts_Export
 * @subpackage Posts_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Posts_Export
 * @subpackage Posts_Export/admin
 * @author     Suresh <raosuresh94@gmail.com>
 */
class Posts_Export_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Posts_Export_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Posts_Export_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/posts-export-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Posts_Export_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Posts_Export_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/posts-export-admin.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name.'_swal', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js', array( 'jquery' ), $this->version, false);
    }
    
    public function export_posts()
    {
        $filename = "data.csv";
        
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        $output = fopen('php://output', 'w');

        fputcsv($output, array(
            'ID',
            'Title',
            'Slug',
            'Description',
            'Featured Image'
        ));

        $posts = new WP_Query(
            array(
                'post_status'=>'publish',
                'post_type'=>$_POST['post_type'],
                'posts_per_page' => -1
                )
        );
        foreach ($posts->posts as $result) {
            $data = array(
                $result->ID,
                $result->post_title,
                $result->post_name,
                $result->post_content,
                wp_get_attachment_url(get_post_thumbnail_id($result->ID)),
            );
            fputcsv($output, $data);
        }
    }
}
