<?php

namespace html {

	class form {
	
		private $name;
		private $action; // immer ohne "\?"
		private $cssClass;
		private $fields = array();
		
		
		public function __construct($form_name, $form_action, $form_cssClass = '', $form_submitLabel = 'OK') {
			
			$this->name 		= $form_name;
			$this->action 		= $form_action;
			$this->cssClass		= $form_cssClass;
			$this->submitLabel	= $form_submitLabel;
			
		} // __construct
		
		
		public function addField($field_type, $field_name, $field_label = '', $field_options = '', $field_cssClass = '', $field_helpText = '', $field_groupCssClass = '', $field_value = '') {
		
			$this->fields[] 	= array(	'type'				=> $field_type,
											'name'				=> $field_name,
											'label'				=> $field_label,
											'options'			=> $field_options,
											'cssClass'			=> $field_cssClass,
											'helpText'			=> $field_helpText,
											'groupCssClass'		=> $field_groupCssClass,
											'value'				=> $field_value
										);
			
		} // addField
		
		
		public function addCheckbox($checkbox_name, $checkbox_label = '', $checkbox_options = '', $checkbox_helpText = '', $checkbox_groupCssClass = '') {
			
			$this->fields[] 	= array(	'type'				=> 'checkbox',
											'name'				=> $checkbox_name,
											'label'				=> $checkbox_label,
											'options'			=> $checkbox_options,
											'cssClass'			=> '',
											'helpText'			=> $checkbox_helpText,
											'groupCssClass'		=> $checkbox_groupCssClass
										);
			
		} // addCheckbox
		
		
		public function addRadio($radio_groupname, $radio_name, $radio_label = '', $radio_options = '', $radio_groupCssClass = '') {
			
			$this->fields[] 	= array(	'type'				=> 'radio',
											'name'				=> $radio_name,
											'label'				=> $radio_label,
											'options'			=> $radio_options,
											'cssClass'			=> '',
											'helpText'			=> '',
											'groupCssClass'		=> $radio_groupCssClass,
											'radioGroupName'	=> $radio_groupname
										);
			
		} // addRadio
		
		
		public function addSelect($select_name, $select_array, $select_label = '', $select_options = '', $select_cssClass = '') {
			
			$this->fields[] 	= array(	'type'				=> 'select',
											'name'				=> $select_name,
											'label'				=> $select_label,
											'options'			=> $select_options,
											'cssClass'			=> $select_cssClass,
											'helpText'			=> '',
											'groupCssClass'		=> '',
											'selectArray'		=> $select_array
										);
			
		} // addSelect
		
		
		public function addBFHSelect($bfhselect_name, $bfhselect_array, $bfhselect_label = '', $bfhselect_options = '') {
			
			$this->fields[] 	= array(	'type'				=> 'bfhselect',
											'name'				=> $bfhselect_name,
											'label'				=> $bfhselect_label,
											'options'			=> $bfhselect_options,
											'cssClass'			=> '',
											'helpText'			=> '',
											'groupCssClass'		=> '',
											'selectArray'		=> $bfhselect_array
										);
			
		} // addBFHSelect
		
		
		public function addHTML($html, $html_label = '') {
			
			$this->fields[] 	= array(	'type'				=> 'html',
											'name'				=> '',
											'label'				=> $html_label,
											'options'			=> '',
											'cssClass'			=> '',
											'helpText'			=> '',
											'groupCssClass'		=> '',
											'html'				=> $html
										);
			
		} // addHTML
		
		
		
		public function draw() {
		
			// Beginn Formularblock
			$output = 	'<form role="form" id="form-'. $this->name .'" class="'. $this->cssClass .'" enctype="multipart/form-data" action="'. $this->action .'" method="post" target="_self">';
			
			
			// HTML für Felder generieren
			foreach($this->fields as $field) {
			
				// Prüfen ob Laben vorhanden, sonst zuweisen
				if($field['label'] == '') { $field['label'] = $field['name']; }
						
	
				// Bootstrap Gruppenklasse ermitteln
				switch($field['type']) {
					
					case 'checkbox':	$bootstrap_groupClass = 'checkbox'; break;
					case 'radio':		$bootstrap_groupClass = 'radio'; break;
					
					default:			$bootstrap_groupClass = 'form-group'; break;
					
				}
				
				
				// Form Group öffnen
				$output .=	'<div class="'. $bootstrap_groupClass .' '. $field['groupCssClass'] .'">';
				
				
					// Feldtypen unterscheiden
					$simpleField = false;
					$bootstrap_fieldClass = 'form-control';
					switch($field['type']) {
						
						case 'text':		$simpleField = true; break;								
						case 'password':	$simpleField = true; break;
						case 'email':		$simpleField = true; break;
						case 'date':		$simpleField = true; break;
						case 'file':		$simpleField = true; $bootstrap_fieldClass = ''; break;
						
						case 'textarea':	break;
						case 'checkbox':	break;
						case 'radio':		break;
						case 'select':		break;
						case 'bfhselect':	break;
						case 'html':		break;
						
						default:			$simpleField = true; $field['type'] = 'text'; break;
						
					}
					
					
					// Feld HTML generieren
					if($simpleField) {
						
						// Label erzeugen
						$output .= '<label class="control-label" for="'. $this->name .'-'. $field['name'] .'">'. $field['label'] .'</label>';
					
						// Feld erzeugen
						$field_html = '<input type="'. $field['type'] .'" class="'. $bootstrap_fieldClass .' '. $field['cssClass'] .'" id="'. $this->name .'-'. $field['name'] .'" name="'. $this->name .'-'. $field['name'] .'">';
					
					} else {
					
						// Komplexe Feldtypen unterscheiden
						switch($field['type']) {
							
							case 'textarea':		// Label erzeugen
													$output .= '<label class="control-label" for="'. $this->name .'-'. $field['name'] .'">'. $field['label'] .'</label>';
													
													// Feld erzeugen
													$field_html = '<textarea class="'. $bootstrap_fieldClass .' '. $field['cssClass'] .'" id="'. $this->name .'-'. $field['name'] .'" name="'. $this->name .'-'. $field['name'] .'">'. $field['value'] .'</textarea>';
													
													break;
													
													
							case 'checkbox':		if($field['options'] == 'checked') { $checked = 'checked'; } else { $checked = ''; }
							
													$field_html = '<label>'
																. '<input type="checkbox" name="'. $this->name .'-'. $field['name'] .'" '. $checked .'>'
																. $field['label']
																. '</label>';
													
													break;
													
									
							case 'radio':			if($field['options'] == 'checked') { $checked = 'checked'; } else { $checked = ''; }
							
													$field_html = '<label>'
																. '<input type="radio" name="'. $this->name .'-'. $field['radioGroupName'] .'" value="'. $field['name'] .'" '. $checked .'>'
																. $field['label']
																. '</label>';
													
													break;


							case 'select':			// Label erzeugen
													$output .= '<label class="control-label" for="'. $this->name .'-'. $field['name'] .'">'. $field['label'] .'</label>';
							
													$field_html = '<select name="'. $this->name .'-'. $field['name'] .'" id="'. $this->name .'-'. $field['name'] .'" class="form-control '. $field['cssClass'] .'" '. $field['options'] .'>';
													
													if(is_array($field['selectArray'])) {
	
														foreach($field['selectArray'] as $selectOption) {

															if($selectOption['value'] != '') { $field_html .= '<option value="'. $selectOption['value'] .'">'. $selectOption['name'] .'</option>'; }
																else { $field_html .= '<option>'. $selectOption['name'] .'</option>'; }

														}
														
													}
													
													$field_html .= '</select>';
													
													break;
													
													
							case 'bfhselect':		// Label erzeugen
													$output .= '<label class="control-label" for="'. $this->name .'-'. $field['name'] .'">'. $field['label'] .'</label>';
							
													$field_html = '<div class="bfh-selectbox" name="'. $this->name .'-'. $field['name'] .'" data-name="'. $this->name .'-'. $field['name'] .'" id="'. $this->name .'-'. $field['name'] .'" '. $field['options'] .'>';
													
													if(is_array($field['selectArray'])) {
	
														foreach($field['selectArray'] as $selectOption) {

															if($selectOption['value'] != '') { $field_html .= '<div data-value="'. $selectOption['value'] .'">'. $selectOption['name'] .'</div>'; }
																else { $field_html .= '<div data-value='. $selectOption['name'] .'">'. $selectOption['name'] .'</div>'; }

														}
														
													}
													
													$field_html .= '</div>';
													
													break;
													
							
							case 'html':			// Label erzeugen
													$output .= '<label class="control-label" for="'. $this->name .'-'. $field['name'] .'">'. $field['label'] .'</label>';
													
													$field_html = $field['html'];
							
													break;
													
						}
					
					}
					
					$output .= $field_html;
					
					
					// Hilfetext ausgeben
					if($field['helpText'] != '') { $output .= '<p class="help-block">'. $field['helpText'] . '</p>'; }
										
				
				// Form Group schließen
				$output .= '</div>';
				
			}
			
			
			// Submit-Button
			if($this->submitLabel != 'NONE') { $output .= '<button type="submit" id="form-'. $this->name .'-submit" class="btn btn-default">'. $this->submitLabel .'</button>'; }
			
			
			// Formularblock schließen
			$output .= 	'</form><!-- form-'. $this->name .' -->';
			
			return $output;
			
		} // draw
		
	}
	
}

?>