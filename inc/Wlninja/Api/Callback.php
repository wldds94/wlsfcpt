<?php
/**
 * Settings API
 *
 * @package Fismbo
 */

namespace Wlninja\Api;

/**
 * Settings API Class
 */
class Callback {

	public $option;

	public $name;
    public $section;
	public $option_name;
	public $index;
	public $type;
	public $options;
	public $default;
	public $placeholder;
	public $classes;
	public $readonly;
	public $disabled;
	public $required;
	public $description;
	public $max;
	public $min;
	public $step;
	public $unit_dimension;
	public $rows;
	public $cols;
	public $first_option; // Only for select

	public function __contruct( $args = array() )
	{
		$this->setData( $args );
	}

	/**
	 * Initialize the value of this class
	 * @since   1.0.0
     * 
	 * @param   array   $args
	 * @return
	 */
	public function setData( array $args )
	{
		$this->name = isset( $args['label_for'] ) ? $args['label_for'] : '';
        $this->section = isset( $args['section'] ) ? $args['section'] : '';
		$this->option_name = isset( $args['option_name'] ) ? $args['option_name'] : '';
		$this->index = isset( $args['index'] ) ? $args['index'] : false;

		$this->setSingleField( $args );
			
		return $this;

	}

	public function setSingleField( $args )
	{
		$this->type = isset( $args['type'] ) ? $args['type'] : '';
		$this->default = isset( $args['default'] ) ? $args['default'] : '';
		$this->placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
		$this->classes = isset( $args['class'] ) ? $args['class'] : '';
		$this->readonly = isset( $args['readonly'] ) ? $args['readonly'] : '';
		$this->required = isset( $args['required'] ) ? $args['required'] : '';
		$this->description = isset( $args['description'] ) ? $args['description'] : '';
		// For Number
		$this->max = isset( $args['max'] ) ? $args['max'] : '';
		$this->min = isset( $args['min'] ) ? $args['min'] : '';
		$this->step = isset( $args['step'] ) ? $args['step'] : '1';
		$this->unit_dimension = isset( $args['unit_dimension'] ) ? $args['unit_dimension'] : '';
		// For Textarea
		$this->rows = isset( $args['rows'] ) ? $args['rows'] : 5;
		$this->cols = isset( $args['cols'] ) ? $args['cols'] : 50;
		// For select / checkbox / radio ecc
		$this->options = isset( $args['options'] ) ? $args['options'] : '';
		// For select
		$this->first_option = isset( $args['first_option'] ) ? $args['first_option'] : true;
		
		$this->option = get_option( $this->option_name );

        if( $this->index ) $this->value = isset( $this->option[$this->section][$this->name][$this->index] ) ? $this->option[$this->section][$this->name][$this->index] : '';
        else $this->value = isset( $this->option[$this->section][$this->name] ) ? $this->option[$this->section][$this->name] : $this->default;
	
	}

	/* ------------------------------------------------------------------------ *
	* ######## DISPLAY FIELDS CALLBACKS
	* ------------------------------------------------------------------------ */
    public function displayOptionsCallback( $args )
    {
		// dd($args);
        // $this->setData( $args );
		$this->name = isset( $args['label_for'] ) ? $args['label_for'] : '';
        $this->section = isset( $args['section'] ) ? $args['section'] : '';
		$this->option_name = isset( $args['option_name'] ) ? $args['option_name'] : '';
		$this->index = isset( $args['index'] ) ? $args['index'] : false;

		$this->setSingleField( $args );

        switch ( $this->type ) {
            case 'hidden': 
				$this->hiddenField();
				break;                

			case 'number':
				$this->numberField();
				break;

            case 'text':
                $this->textField();
                break;

			case 'date':
				$this->dateField();
				break;

			case 'url':
                $this->urlField();
                break;

			case 'range':
                $this->rangeField();
                break;

			case 'checkbox':
                $this->checkboxField();
                break;

			case 'radio':
                $this->radioField();
                break;

			case 'radio-image':
				$this->radioImageField();
				break;

            case 'select':
                $this->selectField();
                break;

			case 'select-geo':
				$this->selectGeoField();
                break;

            case 'image':
                $this->imageField();
                break;
			
			case 'color':
                $this->colorField();
                break;
			
			case 'typography':
                $this->typographyField();
                break;

			case 'responsive-typography':
                $this->responsiveTypographyField();
                break;

			case 'textarea':
				$this->textareaField();
                break;

			case 'textarea-css':
				$this->textareaCssField( $this->name );
                break;

			case 'wp-editor':
                $this->wpEditorField();
                break;

			case 'post-formats':
                $this->postFormatsField();
                break;

            case 'array':
                $this->array_fields = isset( $args['fields'] ) ? $args['fields'] : array();
                $this->arrayField();
                break;
            
            default:
				echo "Not Find!";
				break;
        }

    }
	
	public function resetArg( string $key, array $arguments )
	{
		// dd( $key);
		$new_args = array(
            'option_name' => $this->option_name,
			'section'   => $this->section,
			'label_for' => $this->name,
			'index'     => $key,
			'type'      => isset( $arguments['type'] ) ? $arguments['type'] : '',
			'options'   => isset( $arguments['options'] ) ? $arguments['options'] : array(),
			'default'   => isset( $arguments['default'] ) ? $arguments['default'] : '',
			'placeholder' => isset( $arguments['placeholder'] ) ? $arguments['placeholder'] : '',
			'class'       => isset( $arguments['class'] ) ? $arguments['class'] : ''
        );

		$new_args['readonly'] = isset( $arguments['readonly'] ) ? $arguments['readonly'] : '';
		$new_args['required'] = isset( $arguments['required'] ) ? $arguments['required'] : '';
		$new_args['description'] = isset( $arguments['description'] ) ? $arguments['description'] : '';
		$new_args['max'] = isset( $arguments['max'] ) ? $arguments['max'] : '';
		$new_args['min'] = isset( $arguments['min'] ) ? $arguments['min'] : '';
		$new_args['step'] = isset( $arguments['step'] ) ? $arguments['step'] : '1';
		$new_args['unit_dimension'] = isset( $arguments['unit_dimension'] ) ? $arguments['unit_dimension'] : $this->unit_dimension;
		$new_args['first_option'] = !isset( $arguments['first_option'] ) ? $this->first_option : false;

		return $new_args;	
	}

	private function arrayField()
    {
        foreach ($this->array_fields as $field => $arguments) {
            $new_args = $this->resetArg( $field, $arguments );

            $this->displayOptionsCallback( $new_args );
        }
    }

	private function urlField()
	{ ?>
		<div>
			<input type="text" class="widefat <?php echo esc_attr( $this->classes ); ?>" id="<?php echo esc_attr( $this->name )?>" <?php echo esc_attr( $this->required ); ?> <?php echo esc_attr( $this->readonly ); ?>
				name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
				value="<?php echo esc_url( $this->value ); ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" >
			<label for="<?php echo esc_attr( $this->name )?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label>
		</div>
	  <?php
	}

	/**
	 * 
	 * Use text-box class & text-clear in JS for clean Input - Dont't Touch
	 */
	private function textField()
    { ?>
		<div class="wlank-array-input-single input-text-container-wrap flex-column">

			<?php if( isset($this->description) ) : ?><span class="key-description"><?php echo esc_html($this->description); ?></span><?php endif; ?>

			<input id="<?php echo esc_attr( $this->name ); ?>" class="<?php echo esc_attr( $this->classes ); ?> text-box" type="text" 
				name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
				value="<?php echo esc_attr( $this->value ); ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" >
			
			<div class="text-clear"></div>

		</div>
        
      <?php     
    }

	private function responsiveTypographyField()
	{ ?>
		<div class="typography-section">
			<div class="font-size-container column">
				<span class="key-description">For Laptops <span class="opacity">(≤ 1440px of device width)</span><br><br>font-size:</span>
				<?php 
					$new_args = $this->resetArg( 'desktop_font_size', array( 'type' => 'text', 'placeholder' => 'Leave blank for inherit'  ) );
					$this->displayOptionsCallback( $new_args );
				?>	
			</div>

			<div class="font-size-container column">
				<span class="key-description">For tablets <span class="opacity">(≤ 1024px of device width)</span><br><br>font-size:</span>
				<?php 
					$new_args = $this->resetArg( 'tablet_font_size', array( 'type' => 'text', 'placeholder' => 'Leave blank for inherit'  ) );
					$this->displayOptionsCallback( $new_args );
				?>	
			</div>

			<div class="font-size-container column">
				<span class="key-description">For mobiles <span class="opacity">(≤ 768px of device width)</span><br><br>font-size:</span>
				<?php 
					$new_args = $this->resetArg( 'mobile_font_size', array( 'type' => 'text', 'placeholder' => 'Leave blank for inherit'  ) );
					$this->displayOptionsCallback( $new_args );
				?>	
			</div>

			<div class="line-height-container column">
				<span class="key-description">line-height:</span>
				<?php 
					$new_args = $this->resetArg( 'desktop_line_height', array( 'type' => 'text', 'placeholder' => 'Leave blank for inherit'  ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

			<div class="line-height-container column">
				<span class="key-description">line-height:</span>
				<?php 
					$new_args = $this->resetArg( 'tablet_line_height', array( 'type' => 'text', 'placeholder' => 'Leave blank for inherit'  ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

			<div class="line-height-container column">
				<span class="key-description">line-height:</span>
				<?php 
					$new_args = $this->resetArg( 'mobile_line_height', array( 'type' => 'text', 'placeholder' => 'Leave blank for inherit' ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

		</div>

	  <?php		
	}

	private function typographyField()
	{ ?>
		<div class="typography-section">
			<div class="font-size-container column">
				<?php wlankPrintCssSubTitleInput( 'Font size' ); ?>
				<?php 
					$new_args = $this->resetArg( 'font_size', array( 'type' => 'text' ) );
					$this->displayOptionsCallback( $new_args );
				?>	
			</div>

			<div class="font-style-container column">
				<span class="key-description">Font style</span>
				<?php 
					$new_args = $this->resetArg( 'font_style', array( 'type' => 'select', 'options' => array( 'inherit' => 'Inherit', 'normal' => 'Normal', 'italic' => 'Italic', 'oblique' => 'Oblique' ) ) );
					$this->displayOptionsCallback( $new_args );
				?>				
			</div>

			<div class="font-color-container column">
				<span class="key-description">Font Color</span>
				<?php 
					$new_args = $this->resetArg( 'font_color', array( 'type' => 'color' ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

			<div class="line-height-container column">
				<?php wlankPrintCssSubTitleInput( 'Line height' ); ?>
				<?php 
					$new_args = $this->resetArg( 'line_height', array( 'type' => 'text' ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

			<div class="font-weight-container column">
				<span class="key-description">Font weight</span>
				<?php 
					$new_args = $this->resetArg( 'font_weight', array( 'type' => 'select', 'options' => array( '100' => '100 thin', '200' => '200 Extra-light', '300' => '300 Light', '400' => '400 Regular', '500' => '500 Medium', '600' => '600 Semi-bold', '700' => '700 Bold', '800' => '800 Extra-Bold', '900' => '900 Black' ) ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

			<div class="letter-spacing-container column">
				<?php wlankPrintCssSubTitleInput( 'Letter spacing' ); ?>
				<?php 
					$new_args = $this->resetArg( 'letter_spacing', array( 'type' => 'text' ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

			<div class="font-family-container column">
				<?php wlankPrintCssFontSubTitleInput( 'Font family' ); ?>
				<!-- <span class="key-description">Font family <span class="opacity">See more on <a href="#">Google Fonts</a></span></span> -->
				<?php 
					$new_args = $this->resetArg( 'font_family', array( 'type' => 'select', 'options' => array( 'poppins' => 'Poppins', 'sacramento' => 'Sacramento' ) ) );
					$this->displayOptionsCallback( $new_args );
				?>
			</div>

		</div>

	  <?php
	}

	private function selectField()
	{ ?>
		<div class="wlank-array-input-single flex-column">
			<?php if( isset($this->description) ) : ?><span class="key-description"><?php echo esc_html($this->description); ?></span><?php endif; ?>

			<select id="<?php echo esc_attr( $this->name ); ?>" class="<?php echo esc_attr( $this->classes ); ?>"
				name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" >
				<?php if( $this->first_option ) : ?>
					<option value="">Choose an option</option>
				<?php endif; ?>
				<?php if( $this->value != '' ) : ?>
					<?php foreach( $this->options as $k => $v ) : 
						$selected = false;
						if( $k == $this->value ) {
							$selected = true;
						} ?>
						<option <?php echo selected( $selected, true, false ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
					<?php endforeach; ?>
				<?php else : ?>		
					<?php foreach( $this->options as $k => $v ) : 
							$selected = false; ?>
						<option <?php echo selected( $selected, true, false ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
      <?php 		
	}

	private function selectGeoField()
	{ ?>		
		<select name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>"
			id="<?php echo esc_attr( $this->name ); ?>" class="regular-text <?php echo esc_attr( $this->classes ); ?>" <?php echo esc_attr( $this->disabled ); ?> <?php echo $this->required != '' ? esc_attr( $this->required ) : ''; ?>>
		<?php 
		if ( $this->value != '' ) {
			$selected = true; ?>
			<option <?php echo selected( $selected, true, false ); ?> value="<?php echo esc_attr( $this->value ); ?>"><?php echo esc_html( $this->value ); ?></option>
		<?php } else { ?>
			<option value="" selected>Choose an option</option>
		<?php } ?>
		</select>
	<?php
	}

	private function numberField()
	{ ?>
		<div class="wlank-array-input-single number">
			<div class="flex-column">
				<?php echo isset($this->description) ? '<span class="key-description">' . esc_html($this->description) . '</span>' : ''; ?>
				<div class="flex-row">
					<input type="number" class="<?php echo esc_attr( $this->classes ); ?>" id="<?php echo esc_attr( $this->name ); ?>"
						name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
						placeholder="<?php echo esc_attr( $this->placeholder ); ?>" value="<?php echo esc_attr( $this->value ); ?>" 
						min="<?php echo esc_attr( $this->min ); ?>" max="<?php echo esc_attr( $this->max ); ?>" step="<?php echo esc_attr( $this->step ); ?>" >
					<?php if( $this->unit_dimension != '' ) : ?>
						<span class="unit-description"><?php echo esc_html( $this->unit_dimension ); ?></span>
					<?php endif; ?>
				</div>

			</div>
		</div>
	  <?php		
	}

	private function dateField()
	{ ?>
		<input id="<?php echo esc_attr( $this->name ); ?>" type="date" value="<?php echo esc_attr( $this->value ); ?>" 
			name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
			placeholder="<?php echo esc_attr( $this->placeholder ); ?>" class="regular-text">
	 <?php
	}

	private function radioImageField()
	{ ?>
		<div class="wlank-radio-image-container">
            <?php foreach( $this->options as $k => $v ) :
                $wl_extra_class = '';
                $checked = false;
                if ($this->value != '') {
                    if ($k == $this->value) {
                        $checked = true;
                    } elseif ( $k == '' ) {
                        $wl_extra_class = 'unset-radio-button';
                    }
                } elseif( $k == '' ) {
                    $checked = true;
                }
				$radioDescription = ucfirst( str_replace( "_", " ", $k ) );
            ?>
				<label class="wlank-radio-image">
					<input type="radio" <?php echo checked( $checked, true, false ); ?>
						name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
						value="<?php echo esc_attr( $k ); ?>" id="<?php echo esc_attr( $this->name . '_' . $this->index . '_' . $k ); ?>" />
					<div class="radio-visual">
						<img src="<?php echo esc_url( $v ); ?>">
						<span class="radio-image-description"><?php echo esc_html( $radioDescription ); ?></span>
					</div>
					
				</label>
            <?php endforeach; ?>
        </div>

      <?php  		
	}

	private function checkboxField()
	{ 
		if ($this->default != 0 && $this->default != 1 && $this->default != null) {
			if( $this->index ) $checked = isset($this->option[$this->section][$this->name][$this->index]) ? ($this->option[$this->section][$this->name][$this->index] ? true : false) : false; //echo $checked;
			else $checked = isset($this->option[$this->section][$this->name]) ? ($this->option[$this->section][$this->name] ? true : false) : false;
		} else {
			if ($this->default == absint(1)) {
				$checked = true;
			} else $checked = false;
		}		
	  ?>
	  	<div class="wlank-array-input-single flex-column">
		  	<?php if( isset($this->description) ) : ?><span class="key-description"><?php echo esc_html($this->description); ?></span><?php endif; ?>
			<div class="<?php echo $this->classes?>">
				<input type="checkbox" id="<?php echo esc_attr( $this->name ) . '_' . esc_attr( $this->index ); ?>" class="" <?php echo esc_attr( $checked ? 'checked' : '' ); ?>
					name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>"
					value="1" >
				<label for="<?php echo esc_attr( $this->name . '_' . $this->index ); ?>">
					<div></div>		
				</label>
			</div>
		</div>
      <?php  
	}

	private function colorField()
	{ 
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_enqueue_script('wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );
	  ?>
        <div class="wlank-array-input-single flex-column">
			<?php if( isset($this->description) ) : ?><span class="key-description"><?php echo esc_html($this->description); ?></span><?php endif; ?>

			<div class="color-picke wl_my_color_picker_container" style="position:relative;">
				<input id="<?php echo esc_attr( $this->name ); ?>" class="wl_my_color_picker" type="text" value="<?php echo esc_attr( $this->value ); ?>" data-default-color=""
					name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" />
			</div>

		</div>

      <?php 		
	}

    private function hiddenField()
    { ?>
        <input id="<?php echo esc_attr( $this->name ); ?>" class="<?php echo esc_attr( $this->classes ); ?>" type="hidden"
            name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
            value="<?php echo esc_attr( $this->value ); ?>" >
      <?php        
    }

	public function rangeField()
	{  ?>
		<div class="regular-text">
			<input type="number" id="<?php echo esc_attr( $this->name ); ?>" class="<?php echo esc_attr( $this->classes ); ?> wlank-range-value widefat" 
				name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>"
				value="<?php echo esc_attr( $this->value != '' ? $this->value : 0 ); ?>" min="<?php echo esc_attr( $this->min ); ?>" max="<?php echo esc_attr( $this->max ); ?>" 
				step="<?php echo esc_attr( $this->step ); ?>" readonly >

			<input id="" class="regular-text wlank-range-input" type="range" value="<?php echo esc_attr( $this->value != '' ? $this->value : 0 ); ?>" 
				min="<?php echo esc_attr( $this->min ); ?>" max="<?php echo esc_attr( $this->max ); ?>" step="<?php echo esc_attr( $this->step ); ?>" >
		</div>
		
      <?php 
	}

    private function radioField()
    { ?>
		<div class="">
			<?php if( isset($this->description) ) : ?><span class="key-description"><?php echo esc_html($this->description); ?></span><br><?php endif; ?>
			<div class="wlank-radio-container">
				<?php foreach( $this->options as $k => $v ) :
					$wl_extra_class = '';
					$checked = false;
					if ($this->value != '') {
						if ($k == $this->value) {
							$checked = true;
						} elseif ( $k == '' ) {
							$wl_extra_class = 'unset-radio-button';
						}
					} elseif( $k == '' ) {
						$checked = true;
					}
				?>
				<div id="<?php echo esc_attr( $this->name ) . '_' . esc_attr( $k ) . '_container'; ?>" class="wlank-radio <?php echo esc_attr( $this->classes ) ?>">	
					<input type="radio" <?php echo checked( $checked, true, false ); ?> 
						name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
						value="<?php echo esc_attr( $k ); ?>" id="<?php echo esc_attr( $this->name . '_' . $this->index . '_' . $k ); ?>" />
					<label for="<?php echo esc_attr( $this->name ) . '_' . esc_attr( $this->index ) . '_' . esc_attr( $k ); ?>" class="radio-label wlank-radio-button <?php echo esc_attr( $wl_extra_class ); ?>">
						<?php echo esc_attr( $v ); ?>
					</label>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
    <?php        
    }

    private function imageField()
    {
        // $url = $this->value === '' ? $this->theme_url . '/assets/images/photo-gallery.png' : $this->value; 
    ?>
        <div class="wlank-img-container wlank-array-input-single">
			<div class="wlank-uplaod-clean">
                <button type="button" class="wl-js-clean-upload">
					<!-- <img src="<?php // echo esc_url( $this->theme_url . '/assets/images/clear-input.png' ); ?>"> -->
				</button>
            </div>
            
            <div class="wlank-image-upload-thumb-container">
                <img src="<?php echo esc_url(  $this->value ); ?>" alt="Upload an image" class="wlank-upload-preview">
            </div>
            
			<div id="<?php echo esc_attr( $this->classes ); ?>" class="<?php echo esc_attr( $this->classes ); ?> wlank-upload-input-container">
                <input type="hidden" class="wl-image-upload" id="<?php echo esc_attr( $this->name ); ?>" <?php // style="visibility:hidden; display:none;" ?>
					name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
                    value="<?php echo esc_url( $this->value ); ?>">
                <button type="button" class="button button-primary wl-js-image-upload">Add Image</button>
            </div>
        </div>
        
     <?php 
    }

	public function textareaCssField( string $id )
	{
		wp_enqueue_style( 'ace_style', $this->theme_url . '/assets/css/ace.css' );
		wp_enqueue_script( 'ace_script', $this->theme_url . '/assets/js/ace/ace.js', 100 );

		wp_enqueue_script( 'custom_css_script', $this->theme_url . '/assets/js/custom-css.js', 100 );

		$this->value = ( $this->value != '' ) ? $this->value : "/* Wlident Theme Custom CSS */";
	  ?>
	  	<div id="<?php echo esc_attr( 'CssTextArea_' . $id ); ?>" class="CssTextArea"><?php echo esc_textarea( $this->value ); ?></div>
		<textarea id="<?php echo esc_attr( $this->name ); ?>" style="display:none;visible:hidden;" rows="<?php echo esc_attr( $this->rows ); ?>" cols="<?php echo esc_attr( $this->cols ); ?>"
				name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
				placeholder="<?php echo esc_attr( $this->placeholder ); ?>" ><?php echo esc_textarea( $this->value );?></textarea>
	  <?php
	}

	public function textareaField()
	{ 
	  ?>
		<textarea id="<?php echo esc_attr( $this->name ); ?>" class="<?php echo esc_attr( $this->classes ); ?>" rows="<?php echo esc_attr( $this->rows ); ?>" cols="<?php echo esc_attr( $this->cols ); ?>"
				name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->section ) . ']' . '[' . esc_attr( $this->name ) . ']' . ( $this->index ? '[' . esc_attr($this->index) . ']' : '' ); ?>" 
				placeholder="<?php echo esc_attr( $this->placeholder ); ?>" ><?php echo esc_textarea( $this->value );?></textarea>
	  <?php
	}

	public function postFormatsField()
	{
		$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
		$output = '';
		foreach ( $formats as $format ) {
			$new_args = $this->resetArg( $format, array( 
						'type' => 'checkbox',
						'class' => 'wlank-form ui-toggle',
						'description' => ucfirst( $format )  
				) 
			);
			$this->displayOptionsCallback( $new_args );
		}
	}
	
	/**
	 * Display the wp Editor fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	private function wpEditorField() 
	{
		$default_content = html_entity_decode($this->value);
	  ?> 
		<div class="wp-editor-container-wrap">
			<div class="wl-wp-editor-container">	
				<?php wp_editor( $default_content, $this->name/* 'custom_text' */, array( 'textarea_rows' => 5 ) ); ?>
			</div>
			<!-- <span style="margin-bottom:5px; font-size:12px;"><strong>***</strong> Only <strong>Post Tag</strong> permitted.</span> -->
		</div>
	  <?php
	}

    /**
	 * Generate HTML for displaying fields
	 * @since  1.0.0
	 * 
	 * @param  array $args Field data
	 * @return
	 */
	public function displayOptionsField( $args )
	{
		$this->setData( $args );

		switch ( $this->type ) {
			case 'hidden': ?>
				<input id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $this->value ); ?>" type="hidden">
			<?php break;

			case 'text': ?>
				<input id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $this->value ); ?>" type="text" 
					placeholder="<?php echo esc_attr( $this->placeholder ); ?>" class="regular-text">
			<?php break;

			case 'password':
				echo 'Not Provided Yet.';
				break;
			
			case 'number': ?>
				<input id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $this->value ); ?>" type="number" 
					placeholder="<?php echo esc_attr( $this->placeholder ); ?>" step="<?php echo esc_attr( $this->step ); ?>" min="<?php echo esc_attr( $this->min ); ?>" max="<?php echo esc_attr( $this->max ); ?>"
					class="regular-text">
			<?php break;

			case 'text_secret': ?>
				<input id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="" type="text" 
					placeholder="<?php echo esc_attr( $this->placeholder ); ?>" class="regular-text">
			<?php break;

			case 'textarea': ?>
				<textarea id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" rows="5" cols="50">
					<?php echo esc_textarea( $this->value );?>
				</textarea>
			<?php break;

			case 'checkbox': 
				$checked = isset($this->option[$this->name]) ? ($this->option[$this->name] ? true : false) : false; ?>
				<div class="<?php echo esc_attr( $this->classes ); ?>">
					<input type="checkbox" id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="1" <?php echo esc_attr( $checked ? 'checked' : '' ); ?> >
					<label for="<?php echo esc_attr( $this->name ); ?>">
						<div></div>
					</label>
				</div>
			<?php break;

			case 'checkbox_multi': 
				foreach( $this->options as $k => $v ) {
					$checked = false;
					// if( in_array( $k, $this->options ) ) {
					// 	$checked = true;
					// } ?>
					<label for="<?php echo esc_attr( $this->name ) . '_' .  esc_attr( $k ); ?>" data-idaux="<?php echo esc_attr($k) ?>">
						<input type="checkbox" <?php checked( $checked, true, false ); ?> name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . '][]'; ?>" 
							id="<?php echo esc_attr( $this->name ) . '_' .  esc_attr( $k ); ?>" class="<?php echo esc_attr( $this->classes ); ?>"
							value="<?php echo esc_attr( $k ); ?>">
						<?php echo esc_html( $v ); ?>
					</label>
				<?php } ?>
			<?php break;
			
			case 'radio':
				foreach( $this->options as $k => $v ) :
					$checked = false;
					if( $k == $this->value ) {
						$checked = true;
					} ?>
					<label for="<?php echo esc_attr( $this->name ) . '_' .  esc_attr( $k ); ?>">
						<input type="radio" <?php checked( $checked, true, false ); ?> name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $k ); ?>" id="<?php echo esc_attr( $this->name ) . '_' .  esc_attr( $k ); ?>" />
						<?php echo esc_html( $v ); ?>
					</label>
				<?php endforeach; ?>
			<?php break; 
			
			case 'select': ?>			
				<select name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" id="<?php echo esc_attr( $this->name ); ?>" class="regular-text">
					<option value="" selected>Choose an option</option>
				<?php 
				if ( $this->value != '' ) {
					foreach( $this->options as $k => $v ) :
						$selected = false;
						if( $k == $this->value ) {
							$selected = true;
						} ?>
						<option <?php echo selected( $selected, true, false ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
					<?php endforeach; 
				} else {
					foreach( $this->options as $k => $v ) {
						$selected = ''; ?>
						<option <?php echo selected( $selected, true, false ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
					<?php }
				} ?>				
				</select>
			<?php break; 
				
			case 'select_multi': ?>
				<select name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . '][]'; ?>" id="<?php echo esc_attr( $this->name ); ?>" multiple="multiple">
				<?php foreach( $this->options as $k => $v ) :
					$selected = false;
					if( in_array( $k, $this->value ) ) {
						$selected = true;
					} ?>
					<option <?php selected( $selected, true, false ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
				<?php endforeach; ?>
				</select>
				<?php break; 

			case 'image':
				$image_thumb = '';
				if( $this->value ) {
					$image_thumb = wp_get_attachment_thumb_url( $this->value );
				} ?>
				<img id="<?php echo esc_attr( $this->option_name ) . '_preview'; ?>" class="image_preview" src="<?php echo esc_url( $image_thumb ); ?>" /><br/>
				<input id="<?php echo esc_attr( $this->option_name ) . '_button'; ?>" type="button" data-uploader_title="<?php echo __( 'Upload an image' , 'wlsfcpt' ); ?>" data-uploader_button_text="<?php echo __( 'Use image' , 'wlsfcpt' ); ?>" class="image_upload_button button" value="<?php echo  __( 'Upload new image' , 'wlsfcpt' ); ?>" />
				<input id="<?php echo esc_attr( $this->option_name ) . '_delete'; ?>" type="button" class="image_delete_button button" value="<?php echo __( 'Remove image' , 'wlsfcpt' ); ?>" />
				<input id="<?php echo esc_attr( $this->option_name ); ?>" class="image_data_field" type="hidden" name="<?php echo esc_attr( $this->option_name ); ?>" value="<?php echo esc_attr( $this->value ); ?>"/><br/>
			<?php break; 
	
			case 'color': ?>
				<div class="color-picker" style="position:relative;">
					<input type="color" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'?>" class="color" value="<?php echo esc_attr( $this->value ); ?>" />
					<div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
				</div>
				<?php break;

			default:
				echo "Not Find!";
				break;
		}

		switch( $this->type ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi': ?>
				<br/><span class="description"><?php echo esc_attr( $this->description ); ?></span>
			<?php break;

			default: 
				if( '' != $this->description ) : ?>
					<label for="<?php echo esc_attr( $this->name ); ?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label>
				<?php endif; ?>
			<?php break;
		}

	}

	/**
	 * Singular Checkbox field
	 * @since    1.0.0
	 * 
     * @param    array     $args
	 * @return
	 */
	public function checkboxFieldBase( $args )
	{
		$checkbox_name = esc_attr( $args['label_for'] );
		$checkbox_classes = esc_attr( $args['class'] );
		$checkbox_option_name = esc_attr( $args['option_name'] );
		$checkbox = get_option( $option_name );
		$checked = isset($checkbox[$checkbox_name]) ? ($checkbox[$checkbox_name] ? true : false) : false; //echo $checked;
		
		echo '<div class="' . esc_attr( $checkbox_classes ) . '">';
			echo '<input type="checkbox" id="' . esc_attr( $checkbox_name ) . '" name="' . esc_attr( $checkbox_option_name ) . '[' . esc_attr( $checkbox_name ) . ']' . '" value="1" 
						class="" ' . esc_attr( $checked ? 'checked' : '' ) . '>';
			echo '<label for="' . esc_attr( $checkbox_name ) . '">';
				echo '<div></div>';			
			echo '</label>';
		echo '</div>';
	}

	/**
	 * Post_Types Checkbox fields
	 * @since    1.0.0
	 * 
     * @param    array     $args
	 * @return
	 */
	public function checkboxPostTypesField( $args )
	{
		$checkbox_name = esc_attr( $args['label_for'] );
		$checkbox_classes = esc_attr( $args['class'] );
		$checkbox_option_name = esc_attr( $args['option_name'] );
		// $checked = false;

		$checkbox = get_option( $checkbox_option_name );

		$post_types = get_post_types( array( 'show_ui' => true ) );

		echo '<div class="wlank-checkbox-posts-type container">';
		foreach ($post_types as $post_type) {

			$checked = isset( $checkbox[ $checkbox_name ][ $post_type ] ) ?: false;
	
			echo '<div class="' . esc_attr( $checkbox_classes ) . ' mb-10">';
				echo '<input type="checkbox" id="' . esc_attr( $post_type ) . '" name="' . esc_attr( $checkbox_option_name ) . '[' . esc_attr( $checkbox_name ) . '][' . esc_attr( $post_type ) . ']" value="1" class="" ' . esc_attr( $checked ? 'checked' : '' ) . '>';
				echo '<label for="' . esc_attr( $post_type ) . '">';
					echo '<div></div>';			
				echo '</label>';
				echo ' <strong>' . esc_html( $post_type ) . '</strong>';
			echo '</div>';			
		}
		echo '</div>';
	}

	/* ------------------------------------------------------------------------ *
	* ######## SANITIZE CALLBACKS
	* ------------------------------------------------------------------------ */
	/**
	 * Clean array
	 * Remove all key that is not inputted by value - acceot array of array
	 * @since  1.0.0
	 * 
	 * @param  array/array    $input Inputted value
	 * @return array          $output Validated value    
	 */
	public function generalArraySanitize( $input )
    {		
        $output = array();
        foreach ($input as $key => $value) {
			if( is_array( $value ) ) {
				$value = $this->cleanArray( $value );
			}
            if ( $value != '' && $value != null && ! empty( $value ) ) {
                $output[$key] = $value;
            }
        }

		return $output;
    }
	
	/**
	 * Clean array
	 * Remove all key that is not inputted by value
	 * @since   1.0.0
	 * 
	 * @param   array    $array Inputted value
	 * @return  array    $output Validated value    
	 */
	public function cleanArray( $array )
	{
		$output = array();
        foreach ($array as $key => $value) {
            if ( $value != '' || $value != null ) {
                $output[$key] = $value;
            }
        }

		return $output;
	}

    /**
	 * Validate general text settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $data;
	}

    /**
	 * Validate url settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_url_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = esc_url_raw( strip_tags( stripslashes( $data ) ) );
		}
		return $data;
	}

	/**
	 * Validate class & id settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_classes_field( $data )
	{
		$classes_values = explode( " ", $data );
		$value = '';
		foreach ($classes_values as $index => $class ) {
			$value .= sanitize_text_field( sanitize_html_class( $class ) ) . ' ';
		}
		return $value;	
	}

	/**
	 * Validate color settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_color_field( $data )
	{
		$value = sanitize_hex_color( $data );
		return $value;	
	}
	/* ------------------------------------------------------------------------ */

    /**
     * Utils
     */
    public function printSection( string $message = '' )
    {   
        if ( $message != '' ) : ?>
            <div class="wlank-section-note-container">
                <div class="wlank-section-info">
                    <span class="wlank-note-title">Note: </span>
                    <span class="wlank-note-description">
                        <?php echo esc_html( $message ); ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
      <?php
    }
}
