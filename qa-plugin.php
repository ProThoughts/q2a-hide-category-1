<?php

if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

qa_register_plugin_layer('qa-hide-category-layer.php', 'Hide Category Layer');
qa_register_plugin_module('module', 'qa-hide-category-admin.php', 'qa_hide_category_admin', 'Hide Category Admin');
