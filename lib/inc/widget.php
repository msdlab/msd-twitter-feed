<?php
class MSD_Widget_Twitter_Feed extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_twitter_feed', 'description' => __('Simple Twitter Feed'));
        $control_ops = array('width' => 400, 'height' => 350);
        
        parent::__construct('twitter_feed', __('Twitter Feed'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        add_action('wp_print_footer_scripts',array(&$this,'footer_scripts'));
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        echo $before_widget;
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
        print '<div id="twitter-feed"></div>';
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $title = strip_tags($instance['title']);
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>        
<?php
    }
    
    function init() {
        if ( !is_blog_installed() )
            return;
        register_widget('MSD_Widget_Twitter_Feed');
    }    
    
    function footer_scripts(){
        print '
        <script type="text/javascript">
        var config4 = {
          "id": "593854058173083648",
          "domId": "twitter-feed",
          "maxTweets": 3,
          "enableLinks": true,
          "showUser": true,
          "showTime": true,
          "showRetweet": false
        };
        
        
        twitterFetcher.fetch(config4);
        </script>
        ';
    }
}

    
?>