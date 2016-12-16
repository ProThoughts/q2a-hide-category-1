<?php
class qa_hide_category_admin {

	function allow_template($template)
	{
		return ($template!='admin');
	}

	function option_default($option) {

		switch($option) {
			case 'hide-plugin-text':
				return 'Hide Politics category by Default';
			case 'hide-plugin-title':
				return 'Hide Politics';
			case 'hide-plugin-css':
				return '.hide { text-align:center;}';
			default:
				return null;

		}
	}
	function admin_form(&$qa_content)
	{

		//	Process form input

		$ok = null;
		if (qa_clicked('hide_save_button')) {
			foreach($_POST as $i => $v) {

				qa_opt($i,$v);
			}

			$ok = qa_lang('admin/options_saved');
		}
		else if (qa_clicked('hide_reset_button')) {
			foreach($_POST as $i => $v) {
				$def = $this->option_default($i);
				if($def !== null) qa_opt($i,$def);
			}
			$ok = qa_lang('admin/options_reset');
		}			
		//	Create the form for display


		$fields = array();
		$fields[] = array(
				'label' => 'Hide Title',
				'tags' => 'NAME="hide-plugin-title"',
				'value' => qa_opt('hide-plugin-title'),
				'type' => 'text',
				);
		$fields[] = array(
				'label' => 'Hide Text',
				'tags' => 'NAME="hide-plugin-text"',
				'value' => qa_opt('hide-plugin-text'),
				'type' => 'text',
				);


		$fields[] = array(
				'label' => 'Hide custom css',
				'tags' => 'NAME="hide-plugin-css"',
				'value' => qa_opt('hide-plugin-css'),
				'type' => 'textarea',
				'rows' => 20
				);


		return array(
				'ok' => ($ok && !isset($error)) ? $ok : null,

				'fields' => $fields,

				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						'tags' => 'NAME="hide_save_button"',
					     ),
					array(
						'label' => qa_lang_html('admin/reset_options_button'),
						'tags' => 'NAME="hide_reset_button"',
					     ),
					),
			    );
	}


}
