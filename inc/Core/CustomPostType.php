<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlaiddd
 */
namespace Wlsfcpt\Core;

use Inc\Api\SettingsApi;
use Wlsfcpt\Base\BaseController;

class CustomPostType extends BaseController
{
	public $custom_post_types = array();

	public function register()
	{
        add_action( 'init', array( $this, 'setup_cpt' ) );

        // Filter Archive Page Template for sfproduct CPT
        add_filter( 'archive_template', array( $this, 'wlsfcpt_archive_template' ) ) ;

        // Filter the single_template for sfproduct CPT
        add_filter('single_template', array( $this, 'wlsfcpt_singlepost_template' ) );

		// Try CMB2
		add_action( 'cmb2_admin_init', array( $this, 'cmb2_extra_metaboxes' ) );

		// Slide Shortcode
		add_shortcode( 'wlsfcpt_slide_single', array( $this, 'wlsfcpt_shortcode_slide_single' ) );
	}

	/**
	 * CORE
	 */
		/**
	 * Define the metabox and field configurations.
	 */
	public function cmb2_extra_metaboxes() {
	
		/**
		 * Initiate the metabox
		 */
		$cmb = new_cmb2_box( array(
			'id'            => 'wlsfcpt_extra_info',
			'title'         => __( 'Extra Prodotto SayFarm', 'wlsfcpt' ),
			'object_types'  => array( 'sfproduct', ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
		) );

		// Category for archive
		$cmb->add_field( array(
			'name'             => 'Wlsfcpt Category',
			'id'               => 'wlsfcpt_cat_meta',
			'type'             => 'radio',
			'show_option_none' => true,
			'options'          => array(
				'flowers' =>  __( 'Flowers', 'wlsfcpt' ),
				'hash'   => __( 'Hash', 'wlsfcpt' ),
				'vape'     => __( 'Vape', 'wlsfcpt' ),
				'extracts' => __( 'Extracts', 'wlsfcpt' ),
			),
		) );
	
		// Shortcode Slide Info
		$cmb->add_field( array(
			'name'       => __( 'Slide Shortcode', 'wlsfcpt' ),
			'desc'       => getSlideShortcodeString(),
			'id'         => 'wlsfcpt_slideshortcode',
			'type'       => 'title',
		) );

		// Regular text field
		$cmb->add_field( array(
			'name'       => __( 'Disponibile Online', 'wlsfcpt' ),
			'desc'       => '',
			'id'         => 'wlsfcpt_islive',
			'type'       => 'checkbox',
		) );

		// Regular text field
		$cmb->add_field( array(
			'name'       => __( 'Famiglia', 'wlsfcpt' ),
			'desc'       => 'flowers => Sativa / others => ""',
			'id'         => 'wlsfcpt_family',
			'type'       => 'text',
			'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
			'default'    => ''
			// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
			// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
			// 'on_front'        => false, // Optionally designate a field to wp-admin only
			// 'repeatable'      => true,
		) );

		// Add other metaboxes as needed
		$cmb->add_field( array(
			'name'             => 'Profilo Terpenico',
			'id'               => 'wlsfcpt_taste',
			'type'             => 'multicheck',
			'show_option_none' => false,
			'default'          => 'custom',
			'options'          => getAllTerpenicProfile(),
			// 'options'          => array(
			// 	'cheese' => __( 'Cheese', 'wlsfcpt' ),
			// 	'exotic'   => __( 'Esotico', 'wlsfcpt' ),
			// 	'hazelmut'     => __( 'Nocciolato', 'wlsfcpt' ),
			// 	'earthy' => 'Terroso',
			// 	'agrumato' => 'Agrumato',
			// 	'fruity' => 'Fruttato'

			// ),
		) );
	
		// Regular text field
		$cmb->add_field( array(
			'name'       => __( 'Livello CBD', 'wlsfcpt' ),
			'desc'       => 'flowers => "" / others =>  5 - 10 - 20 %',
			'id'         => 'wlsfcpt_cbdlevel',
			'type'       => 'text',
			'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
			'default'    => ''
			// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
			// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
			// 'on_front'        => false, // Optionally designate a field to wp-admin only
			// 'repeatable'      => true,
		) );

		// Regular text field
		$cmb->add_field( array(
			'name'       => __( 'Livello THC', 'wlsfcpt' ),
			'desc'       => 'flowers => "Secondo legge vigente" / others => Percentuale < 0,3',
			'id'         => 'wlsfcpt_thclevel',
			'type'       => 'text',
			'default'    => ''
			// 'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
			// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
			// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
			// 'on_front'        => false, // Optionally designate a field to wp-admin only
			// 'repeatable'      => true,
		) );

		// CTA URL button field
		$cmb->add_field( array(
			'name' => __( 'CTA URL', 'wlsfcpt' ),
			'desc' => __( '', 'wlsfcpt' ),
			'id'   => 'wlsfcpt_url',
			'type' => 'text_url',
			'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
			// 'repeatable' => true,
		) );

		// Excerpt description hero
		// $cmb->add_field( array(
		// 	'name'    => 'Test wysiwyg',
		// 	'desc'    => 'field description (optional)',
		// 	'id'      => 'wiki_test_wysiwyg',
		// 	'type'    => 'wysiwyg',
		// 	'options' => array(),
		// ) );

		// Hero Slider
		$cmb->add_field( array(
			'name' => 'Hero Slider',
			'desc' => '600x415 px reccomended',
			'id'   => 'wlsfcpt_hero_slider',
			'type' => 'file_list',
			// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			// 'query_args' => array( 'type' => 'image' ), // Only images attachment
			// Optional, override default text strings
			'text' => array(
				'add_upload_files_text' => 'Replacement', // default: "Add or Upload Files"
				'remove_image_text' => 'Replacement', // default: "Remove Image"
				'file_text' => 'Replacement', // default: "File:"
				'file_download_text' => 'Replacement', // default: "Download"
				'remove_text' => 'Replacement', // default: "Remove"
			),
		) );

		/** First INTRO */
		$group_field_id = $cmb->add_field( array(
			'id'          => 'wlsfcpt_repeat_intro',
			'type'        => 'group',
			'description' => __( 'Generates reusable form entries', 'wlsfcpt' ),
			'repeatable'  => true, // use false if you want non-repeatable group
			'options'     => array(
				'group_title'       => __( 'Intro {#}', 'wlsfcpt' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'        => __( 'Add Another Intro', 'wlsfcpt' ),
				'remove_button'     => __( 'Remove Intro', 'wlsfcpt' ),
				'sortable'          => true,
				// 'closed'         => true, // true to have the groups closed by default
				'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'wlsfcpt' ), // Performs confirmation before removing group.
			),
		) );
		
		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Intro Title',
			'id'   => 'title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );
		
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Description',
			'description' => 'Write a short description for this entry',
			'id'   => 'description',
			'type' => 'textarea_small',
		) );

		// Masonry
		$cmb->add_field( array(
			'name' => 'Masonry',
			'desc' => '',
			'id'   => 'wlsfcpt_masonry',
			'type' => 'file_list',
			// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			// 'query_args' => array( 'type' => 'image' ), // Only images attachment
			// Optional, override default text strings
			'text' => array(
				'add_upload_files_text' => 'Replacement', // default: "Add or Upload Files"
				'remove_image_text' => 'Replacement', // default: "Remove Image"
				'file_text' => 'Replacement', // default: "File:"
				'file_download_text' => 'Replacement', // default: "Download"
				'remove_text' => 'Replacement', // default: "Remove"
			),
		) );
		
		// Best Deals Hero
		$cmb->add_field( array(
			'name'    => 'Best Deal Slider Image',
			'desc'    => 'Used in carousel if "Best Deals" (Bookng Prodotto) is active. (500x500 px reccomended)',
			'id'      => 'wlsfcpt_bestdeal_image',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add or Upload File' // Change upload button text. Default: "Add File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				// 'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
				    'image/gif',
				    'image/jpeg',
				    'image/png',
					'image/svg'
				),
			),
			'preview_size' => 'small', // Image size to use when previewing in the admin.
		) );
	}

	public function setup_cpt()
	{
		$this->register_cpt();
		$this->register_taxonomy();
	}

	public function register_taxonomy()
	{
		// Prepare args to register taxonomy
		$args = array(
			'label'				=> 'Categorie Prodotto', // plural label
			'labels'			=> array(
				'name'				=> 'Categoria Prodotto', // general name, usually plural
				'singular_name'		=> 'Categoria Prodotto', // singlar name for object
				'menu_name'			=> _x( 'Categorie Prodotto', 'object taxonomy menu name' ) // menu name text, defaults to name
			),
			'rewrite' => array( 'slug' => 'prodotto' ),
			'hierarchical' => true,
			'public' => true,
			'show_in_rest' => true
		);

		// Register the taxonomy with prepared $object_types and $args
		register_taxonomy( 'wlsfcpt_category', 'sfproduct', $args );

		// Prepare args to register taxonomy
		$args = array(
			'label'				=>	'Booking Prodotto', // plural label
			'labels'			=>	array(
				'name'				=>	'Booking Prodotto', // general name, usually plural
				'singular_name'		=> 'Booking Prodotto', // singlar name for object
				'menu_name'			=>	_x( 'Booking Prodotto', 'object taxonomy menu name' ) // menu name text, defaults to name
			),
			'rewrite' => array( 'slug' => 'booking' ),
			'hierarchical' => true,
			'public' => true,
			'show_in_rest' => true
		);

		// Register the taxonomy with prepared $object_types and $args
		register_taxonomy( 'wlsfcpt_booking', 'sfproduct', $args );
	}

	public function register_cpt()
	{
		$this->storeCustomPostTypes();

		foreach ($this->custom_post_types as $post_type) {
			// foreach ($this->custom_post_types as $post_type) {
				register_post_type( $post_type['post_type'],
					array(
						'labels' => array(
							'name'                  => $post_type['name'],
							'singular_name'         => $post_type['singular_name'],
							'menu_name'             => $post_type['menu_name'],
							'name_admin_bar'        => $post_type['name_admin_bar'],
							'archives'              => $post_type['archives'],
							'attributes'            => $post_type['attributes'],
							'parent_item_colon'     => $post_type['parent_item_colon'],
							'all_items'             => $post_type['all_items'],
							'add_new_item'          => $post_type['add_new_item'],
							'add_new'               => $post_type['add_new'],
							'new_item'              => $post_type['new_item'],
							'edit_item'             => $post_type['edit_item'],
							'update_item'           => $post_type['update_item'],
							'view_item'             => $post_type['view_item'],
							'view_items'            => $post_type['view_items'],
							'search_items'          => $post_type['search_items'],
							'not_found'             => $post_type['not_found'],
							'not_found_in_trash'    => $post_type['not_found_in_trash'],
							'featured_image'        => $post_type['featured_image'],
							'set_featured_image'    => $post_type['set_featured_image'],
							'remove_featured_image' => $post_type['remove_featured_image'],
							'use_featured_image'    => $post_type['use_featured_image'],
							'insert_into_item'      => $post_type['insert_into_item'],
							'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
							'items_list'            => $post_type['items_list'],
							'items_list_navigation' => $post_type['items_list_navigation'],
							'filter_items_list'     => $post_type['filter_items_list']
						),
						'label'                     => $post_type['label'],
						'description'               => $post_type['description'],
						'supports'                  => $post_type['supports'],
						'show_in_rest'			    => $post_type['show_in_rest'],
						'taxonomies'                => $post_type['taxonomies'],
						'hierarchical'              => $post_type['hierarchical'],
						'public'                    => $post_type['public'],
						'show_ui'                   => $post_type['show_ui'],
						'show_in_menu'              => $post_type['show_in_menu'],
						'menu_position'             => $post_type['menu_position'],
						'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
						'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
						'can_export'                => $post_type['can_export'],
						'has_archive'               => $post_type['has_archive'],
						'exclude_from_search'       => $post_type['exclude_from_search'],
						'publicly_queryable'        => $post_type['publicly_queryable'],
						'capability_type'           => $post_type['capability_type']
					)
				);
			// }
		}
	}

	public function storeCustomPostTypes()
	{
		$options = array(
            array(
                'singular_name' => 'SF Product',
                'plural_name' => 'SF Products',
                'post_type' => 'sfproduct',
                'has_archive' => true,
                'public' => true
            )
        );
		
		foreach ($options as $option) {
		
			$this->custom_post_types[] = array(
				'post_type'             => $option['post_type'],
				'name'                  => $option['plural_name'],
				'singular_name'         => $option['singular_name'],
				'menu_name'             => $option['plural_name'],
				'name_admin_bar'        => $option['singular_name'],
				'archives'              => $option['singular_name'] . ' Archives',
				'attributes'            => $option['singular_name'] . ' Attributes',
				'parent_item_colon'     => 'Parent ' . $option['singular_name'],
				'all_items'             => 'All ' . $option['plural_name'],
				'add_new_item'          => 'Add New ' . $option['singular_name'],
				'add_new'               => 'Add New',
				'new_item'              => 'New ' . $option['singular_name'],
				'edit_item'             => 'Edit ' . $option['singular_name'],
				'update_item'           => 'Update ' . $option['singular_name'],
				'view_item'             => 'View ' . $option['singular_name'],
				'view_items'            => 'View ' . $option['plural_name'],
				'search_items'          => 'Search ' . $option['plural_name'],
				'not_found'             => 'No ' . $option['singular_name'] . ' Found',
				'not_found_in_trash'    => 'No ' . $option['singular_name'] . ' Found in Trash',
				'featured_image'        => 'Featured Image',
				'set_featured_image'    => 'Set Featured Image',
				'remove_featured_image' => 'Remove Featured Image',
				'use_featured_image'    => 'Use Featured Image',
				'insert_into_item'      => 'Insert into ' . $option['singular_name'],
				'uploaded_to_this_item' => 'Upload to this ' . $option['singular_name'],
				'items_list'            => $option['plural_name'] . ' List',
				'items_list_navigation' => $option['plural_name'] . ' List Navigation',
				'filter_items_list'     => 'Filter' . $option['plural_name'] . ' List',
				'label'                 => $option['singular_name'],
				'description'           => $option['plural_name'] . 'Custom Post Type',
				'supports'              => array( 'title', 'editor', 'thumbnail' ),
				'show_in_rest'			=> true,
				'taxonomies'            => array(), // array( 'category', 'post_tag' ),
				'hierarchical'          => false,
				'public'                => isset($option['public']) ?: false,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => isset($option['has_archive']) ?: false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post'
			);
		}

	}

	/**
	 * VIEWS
	 */
	
    public function wlsfcpt_archive_template( $archive_template ) 
    {
        global $post; // $post_type = get_post_type($post); $isArchive = is_archive(); // dd($post_type);

		if ( is_post_type_archive('sfproduct') ) {
			$theme_files = array( 'archive-sfproduct.php', 'wlsfcpt/archive-sfproduct.php' );
			$exists_in_theme = locate_template($theme_files, false);
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				// $plugin_root_dir = $this->plugin_path . 'views/public/archive-sfproducts.php';
				// $plugin_root_dir = $this->plugin_path . 'views/public/template-parts/archive-single.php'; // return $plugin_root_dir;
				$plugin_root_dir = $this->plugin_path . 'views/public/archive.php';

				if ( is_archive() && get_post_type($post) == 'sfproduct' && file_exists( $plugin_root_dir ) ) { // dd($isArchive);
					return $plugin_root_dir;
				}
			}
		}
		return $archive_template;

        /* if ( is_post_type_archive('my_plugin_lesson') ) {
				$theme_files = array('archive-my_plugin_lesson.php', 'myplugin/archive-lesson.php');
				$exists_in_theme = locate_template($theme_files, false);
				if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
				} else {
				return plugin_dir_path(__FILE__) . 'archive-lesson.php';
				}
			}
			return $template;
		 */
    }

    public function wlsfcpt_singlepost_template($single) 
    {
        global $post;
        
        $plugin_root_dir = $this->plugin_path . 'views/public/single-sfproducts.php';
		// return $plugin_root_dir;
        /* Checks for single template by post type */
        if ( is_single() && get_post_type($post) == 'sfproduct' && file_exists( $plugin_root_dir ) ) {
            return $plugin_root_dir;
        }
    
        return $single;
    
    }

	/**
	 * SHORTOCODES
	 */
	// Slider Single Post
	public function wlsfcpt_shortcode_slide_single( $atts )
	{
		# code...
		// return '<p>Shortcode Paragrap</p>';
		ob_start();
		require( WLSFCPT_PLUGIN_PUBLIC_TMPL_PATH . 'shortcode/slide-single.php' );
		$template = ob_get_clean();
		// ob_end_clean();
		return $template;
	}

	
}