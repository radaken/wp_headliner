<?php
/**
 * Добавляет виджет постов.
 */
 class Jetsa_Main_Post_Widget extends WP_Widget {
  
    /**
     * Register widget with WordPress.
     */
    function __construct() {
      parent::__construct(
        'jetsa_main_post_widget', // Base ID
        esc_html__( 'Jetsa Main Post', 'jmp_domain' ), // Name
        array( 'description' => esc_html__( 'Виджет для отображения хэдлайнера', 'jmp_domain' ), ) // Args
      );
    }
  
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
      echo $args['before_widget']; // Whatever you want to display before widget (<div>, etc)

      if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      }
        // WP_Query arguments
$args = array(
    'post_type'              => array('post'), // use any for any kind of post type, custom post type slug for custom post type
    'post_status'            => array('publish'), // Also support: pending, draft, auto-draft, future, private, inherit, trash, any
    'posts_per_page'         => '1', // use -1 for all post
    'order'                  => 'DESC', // Also support: ASC
    'orderby'                => 'date', // Also support: none, rand, id, title, slug, modified, parent, menu_order, comment_count
    'tax_query'              => array(
        'relation' => 'AND', // Use AND for taking result on both condition true
        array(
            'taxonomy'         => 'category', // taxonomy slug
            'terms'            => $instance['selected_category'],
            'field'            => 'slug', // Also support: slug, name, term_taxonomy_id
            'operator'         => 'IN', // Also support: AND, NOT IN, EXISTS, NOT EXISTS
            'include_children' => true,
        ),
        array(
            'taxonomy'         => 'category',// taxonomy slug
            'terms'            => 'headliner',  // term ids
            'field'            => 'slug', // Also support: slug, name, term_taxonomy_id
            'operator'         => 'IN', // Also support: slug, name, term_taxonomy_id
            'include_children' => true,
        ),
    ),
);

// The Query
$query = new WP_Query($args);

// The Loop
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $postImgUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $link = get_permalink(get_the_ID());
        echo '<section class="headliner">
<a class="headliner__box-link" href="'.$link.'">
      <div class="headliner__wrapper">
        <div class="headliner__wrapper-box">
          
          <img class="headliner__box-img" src="'.$postImgUrl.'">
          
          <h1 class="headliner__box-title">'.get_the_title() .'</h1>
          
        </div>
      </div>
      </a>
    </section>';
    }
} else {
    if ( is_admin() ){
        echo '<pre>Это видно только администаторам: Не найдено хедлайнера. Проверьте категории (хоть одна запись с отмеченной категорией headliner 
и хоть одна запись из <b>'.$instance['selected_category'].'</b><br> Если значение выше пусто или неверно, то поставьте его в настройках виджета</pre>';
    }
}

// Restore original Post Data
wp_reset_postdata();

      echo $args['after_widget']; // Whatever you want to display after widget (</div>, etc)
    }
  
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

      $selected_category = ! empty( $instance['selected_category'] ) ? $instance['selected_category'] : esc_html__( 'football', 'jmp_domain' );
      
      ?>
      
      

      <!-- Выбранная рубрика -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'selected_category' ) ); ?>">
          <?php esc_attr_e( 'Рубрика:', 'jmp_domain' ); ?>
        </label> 

        <input 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'selected_category' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'selected_category' ) ); ?>"
          type="text" 
          value="<?php echo esc_attr( $selected_category ); ?>">
      </p>

      <?php 
    }
  
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
      $instance = array();

      $instance['selected_category'] = ( ! empty( $new_instance['selected_category'] ) ) ? strip_tags( $new_instance['selected_category'] ) : '';
  
      return $instance;
    }
  
  } // class Foo_Widget