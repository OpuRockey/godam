<?php
/**
 * Register Custom Widget - GoDAM Audio
 *
 * @package GoDAM
 */

namespace RTGODAM\Inc\Elementor_Widgets;

use Elementor\Controls_Manager;

/**
 * GoDAM Gallery Widget.
 */
class GoDAM_Player extends Base {

	/**
	 * Default config for GoDAM Video Widget.
	 *
	 * @return array
	 */
	public function set_default_config() {
		return array(
			'name'            => 'godam-player',
			'title'           => _x( 'GoDAM Player', 'Widget Title', 'godam' ),
			'icon'            => 'eicon-video',
			'categories'      => array( 'godam' ),
			'keywords'        => array( 'godam', 'video' ),
			'depended_script' => array( 'godam-player-frontend-script', 'godam-player-analytics-script' ),
			'depended_styles' => array( 'godam-player-style', 'godam-player-frontend-style' ),
		);
	}

	/**
	 * Register Widget Controls.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_video_settings',
			array(
				'label'   => esc_html__( 'Player Settings', 'godam' ),
				'classes' => 'rtgodam-video-elementor-control-2',
			)
		);

		$this->add_control(
			'video-file',
			array(
				'label'       => esc_html__( 'Video', 'godam' ),
				'type'        => Controls_Manager::MEDIA,
				'media_types' => array( 'video' ),
				'description' => esc_html__( 'Select the video.', 'godam' ),
				
			)
		);
		
		$this->add_control(
			'seo_settings_popover_toggle',
			array(
				'label'        => esc_html__( 'SEO Settings', 'godam' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__( 'Default', 'godam' ),
				'label_on'     => esc_html__( 'Custom', 'godam' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'video-file[url]!' => '',
				),
			)
		);

		$this->start_popover();

		$this->add_control(
			'seo_content_url',
			array(
				'label'       => esc_html__( 'Content URL', 'godam' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'URL of the video content can be MOV, MP4, MPD. Example: https://www.example.com/video.mp4', 'godam' ),
			)
		);

		$this->add_control(
			'seo_content_headline',
			array(
				'label'       => esc_html__( 'Headline', 'godam' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'Title of the video', 'godam' ),
			)
		);

		$this->add_control(
			'seo_content_description',
			array(
				'label'       => esc_html__( 'Description', 'godam' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'description' => esc_html__( 'Description of the video', 'godam' ),
			)
		);

		$this->add_control(
			'seo_content_upload_date',
			array(
				'label'          => esc_html__( 'Upload Date', 'godam' ),
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => array(
					'enableTime' => false,
				),
			)
		);

		$this->add_control(
			'seo_content_video_thumbnail_url',
			array(
				'label'          => esc_html__( 'Video Thumbnail URL', 'godam' ),
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => array(
					'enableTime' => false,
				),
			)
		);

		$this->add_control(
			'seo_content_family_friendly',
			array(
				'label'       => esc_html__( 'Is Family Friendly', 'godam' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Is the video suitable for all audiences?', 'godam' ),
				'default'     => 'yes',
			)
		);

		$this->end_popover();

		$this->add_control(
			'autoplay',
			array(
				'label'     => esc_html__( 'Autoplay', 'godam' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'video-file[url]!' => '',
				),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'     => esc_html__( 'Loop', 'godam' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'video-file[url]!' => '',
				),
			)
		);

		$this->add_control(
			'muted',
			array(
				'label'     => esc_html__( 'Muted', 'godam' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'video-file[url]!' => '',
				),
			)
		);

		$this->add_control(
			'controls',
			array(
				'label'     => esc_html__( 'Playback controls', 'godam' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'video-file[url]!' => '',
				),
			)
		);

		$this->add_control(
			'preload',
			array(
				'label'     => esc_html__( 'Preload', 'godam' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'metadata',
				'options'   => array(
					'auto'     => esc_html__( 'Auto', 'godam' ),
					'metadata' => esc_html__( 'Metadata', 'godam' ),
					'none'     => esc_html_x( 'None', 'Preload value', 'godam' ),
				),
				'condition' => array(
					'video-file[url]!' => '',
				),
			)
		);

		$this->add_control(
			'poster',
			array(
				'label'       => esc_html__( 'Poster Image', 'godam' ),
				'type'        => Controls_Manager::MEDIA,
				'media_types' => array( 'image' ),
				'description' => esc_html__( 'Select the poster image.', 'godam' ),
				'condition'   => array(
					'video-file[url]!' => '',
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render GoDAM Video widget output on the frontend.
	 *
	 * @access protected
	 */
	protected function render() {
		$widget_video_file  = $this->get_settings_for_display( 'video-file' );
		$widget_poster_file = $this->get_settings_for_display( 'poster' );
		$widget_autoplay    = 'yes' === $this->get_settings_for_display( 'autoplay' ) ? true : false;
		$widget_controls    = 'yes' === $this->get_settings_for_display( 'controls' ) ? true : false;
		$widget_muted       = 'yes' === $this->get_settings_for_display( 'muted' ) ? true : false;
		$widget_loop        = 'yes' === $this->get_settings_for_display( 'loop' ) ? true : false;
		$widget_preload     = $this->get_settings_for_display( 'preload' ) ?? 'auto';

		if ( ! isset( $widget_video_file['url'] ) || empty( $widget_video_file['url'] ) ) {
			return;
		}

		$attributes = array(
			'id'             => $widget_video_file['id'],
			'sources'        => '',
			'src'            => $widget_video_file['url'],
			'transcoded_url' => '',
			'poster'         => $widget_poster_file['url'],
			'aspectRatio'    => '16/9',
			'autoplay'       => $widget_autoplay,
			'controls'       => $widget_controls,
			'muted'          => $widget_muted,
			'loop'           => $widget_loop,
			'preload'        => $widget_preload,
		);

		$is_elementor_widget = true;

		ob_start();
		require RTGODAM_PATH . 'inc/templates/godam-player.php';
	}
}
