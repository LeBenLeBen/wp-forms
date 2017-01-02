<?php

class WP_Form_View_Radios extends WP_Form_View {
	protected function radios( WP_Form_Element_Radios $element ) {
		$attributes = $element->get_all_attributes();
		if ( empty($attributes['name']) ) {
			throw new LogicException(__('Cannot render radio group without a name', 'wp-forms'));
		}
		$options = $element->get_options();
		$selected = (array) $element->get_selected();
		$output = '';
		foreach ( $options as $key => $label ) {
			$checked = false;
			if ( in_array( $key, $selected ) ) {
				$checked = true;
			}
			$output .= $this->radio( $key, $label, $attributes, $checked );
		}
		return $output;
	}

	protected function radio( $key, $label, $attributes, $checked ) {
		$radio = WP_Form_Element::create('radio')
			->set_name($attributes['name'])
			->set_label($label)
			->set_value($key)
			->set_attribute('id', $attributes['name'].'-'.$key);
		if ( isset($attributes['type']) ) {
			unset($attributes['type']);
		}
		if ( isset($attributes['name']) ) {
			unset($attributes['name']);
		}
		if ( isset($attributes['value']) ) {
			unset($attributes['value']);
		}
		foreach ( $attributes as $att => $value ) {
			$radio->set_attribute($att, $value);
		}
		if ( $checked ) {
			$radio->set_attribute('checked', 'checked');
		}
		do_action('wp_form_radio_group_member', $radio);
		return $radio->render();
	}
}
