<?php
/**
 * Adds Youtube_Subs widget.
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

      $postParams = array(
        'post_type' => 'post', // тип постов - записи
        'category' => $instance['category'],
        'numberposts' => 1, // получить 5 постов, можно также использовать posts_per_page
        'orderby' => 'date', // сортировать по дате
        'order' => 'DESC', // по убыванию (сначала - свежие посты)
        'suppress_filters' => true // 'posts_*' и 'comment_feed_*' фильтры игнорируются
      );
      
      $examplePost = get_posts($postParams);
      
      

      // Widget Content Output
      echo '<section class="headliner">
      <div class="headliner__wrapper">
        <div class="headliner__wrapper-box">
          <a>
          <img src="'.get_the_post_thumbnail_url($examplePost).'">
          
          <h1 class="title">'.$examplePost[0]->post_title.'</h1>
          </a>
        </div>
      </div>
    </section>';
    echo '************************************';
    var_dump($examplePost);

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

      $category = ! empty( $instance['category'] ) ? $instance['category'] : esc_html__( 'football', 'jmp_domain' ); 

      $enableStatus = ! empty( $instance['enableStatus'] ) ? $instance['enableStatus'] : esc_html__( 'default', 'jmp_domain' ); 
  
      ?>
      
      

      <!-- Выбранная рубрика -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
          <?php esc_attr_e( 'Рубрика:', 'jmp_domain' ); ?>
        </label> 

        <input 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" 
          type="text" 
          value="<?php echo esc_attr( $category ); ?>">
      </p>

      <!-- ON/OFF enableStatus -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'enableStatus' ) ); ?>">
          <?php esc_attr_e( 'Статус: ', 'jmp_domain' ); ?>
        </label> 

        <select 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'enableStatus' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'enableStatus' ) ); ?>">
          <option value="off" <?php echo ($enableStatus == 'off') ? 'selected' : ''; ?>>
            Выключено
          </option>
          <option value="on" <?php echo ($enableStatus == 'on') ? 'selected' : ''; ?>>
            Включено
          </option>
        </select>
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

      $instance['enableStatus'] = ( ! empty( $new_instance['enableStatus'] ) ) ? strip_tags( $new_instance['enableStatus'] ) : '';

      $instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
  
      return $instance;
    }
  
  } // class Foo_Widget