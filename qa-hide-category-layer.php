<?php

class qa_html_theme_layer extends qa_html_theme_base
{
	// Just write numbers inside the array(), for example, to hide categories 1 and 7
	// you coud write: array(1, 7)
	private $hideCategories = array();

	function initialize()
	{
		if ($this->template == 'account') {
			// add hide form
			$hide_form = $this->hide_form();
			if (!empty($hide_form)) {
				$this->content['form_3'] = $hide_form;
			}
		}

		parent::initialize();
	}

	//change category id, look up in admin category
	function q_list_item($q_item)
	{
		if (!in_array($q_item['raw']['categoryid'], $this->hideCategories)) {
			parent::q_list_item($q_item);

			return;
		}

		// For qa_db_usermeta_get()
		require_once QA_INCLUDE_DIR . 'db/metas.php';
		$userid = qa_get_logged_in_userid();
		if (qa_db_usermeta_get($userid, 'hide') != '1') {
			parent::q_list_item($q_item);
		}
	}

	/**
	 * @return array
	 */
	function hide_form()
	{
		//		uncomment for permissions level
		//		if (qa_get_logged_in_level() < QA_USER_LEVEL_EXPERT) {
		//			return array();
		//		}
		if ($handle = qa_get_logged_in_handle()) {
			require_once QA_INCLUDE_DIR . 'db/metas.php';
			$userid = qa_get_logged_in_userid();
			if (qa_clicked('hide_save')) {
				if (qa_post_text('hide')) {
					qa_db_usermeta_set($userid, 'hide', qa_post_text('hide'));
				} else {
					qa_db_usermeta_set($userid, 'hide', "0");
				}
				$ok = 'Category Options Saved.';
			} else {
				$ok = null;
			}

			$fields = array();
			$fields['hide'] = array(
				'label' => qa_opt('hide-plugin-text'),
				'tags' => 'NAME="hide"',
				'type' => 'checkbox',
				'value' => qa_db_usermeta_get($userid, 'hide'),
			);
			$form = array(
				'ok' => (isset($ok) && !isset($error)) ? $ok : null,
				'style' => 'tall',
				'title' => '<a name="hide_text"></a>' . qa_opt('hide-plugin-title'),
				'tags' => 'action="' . qa_self_html() . '#hide_text" method="POST"',
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
