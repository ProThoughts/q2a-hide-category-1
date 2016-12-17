<?php

class qa_html_theme_layer extends qa_html_theme_base {

	function doctype()
	{
		if($this->template == 'account') {
			// add hide form
			$hide_form = $this->hide_form();
			if($hide_form) {

				$this->content['form_3'] = $hide_form;
			}

		}
		qa_html_theme_base::doctype();
	}

	//change category id, look up in admin category
	function q_list_items($q_items)
	{
		$userid=qa_get_logged_in_userid();
				require_once QA_INCLUDE_DIR . 'db/metas.php';
				if(qa_db_usermeta_get($userid, 'hide') == "1") {
		foreach ($q_items as $q_item){
		if($q_item['raw']['categoryid'] != 28) {
		$this->q_list_item($q_item);
		}
		}
		}
		else {
		qa_html_theme_base::q_list_items($q_items);
		}
	}
	
	function hide_form() {
		if($handle = qa_get_logged_in_handle()) {
			require_once QA_INCLUDE_DIR . 'db/metas.php';
			$userid = qa_get_logged_in_userid();
			if (qa_clicked('hide_save')) {
				if(qa_post_text('hide')){
					qa_db_usermeta_set($userid, 'hide', qa_post_text('hide')) ;
				}
				else {
					qa_db_usermeta_set($userid, 'hide', "0") ;
				}

				qa_redirect($this->request,array('ok'=>qa_lang_html('admin/options_saved')));
			}

			$ok = qa_get('ok')?qa_get('ok'):null;

			$fields = array();
			$fields['hide'] = array(
					'label' => qa_opt('hide-plugin-text'),
					'tags' => 'NAME="hide"',
					'type' => 'checkbox',
					'value' =>  qa_db_usermeta_get($userid, 'hide'),
					);
			$form=array(

					'ok' => ($ok && !isset($error)) ? $ok : null,

					'style' => 'tall',

					'title' => '<a name="hide_text"></a>'.qa_opt('hide-plugin-title'),

					'tags' =>  'action="'.qa_self_html().'#hide_text" method="POST"',

					'fields' => $fields,

					'buttons' => array(
						array(
							'label' => qa_lang_html('main/save_button'),
							'tags' => 'NAME="hide_save"',
						     ),
						),
				   );
			return $form;

		}
	}

}
?>
