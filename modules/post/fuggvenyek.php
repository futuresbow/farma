<?php

function ws_getPost($id) {
	ws_autoload('post');
	$postClass = new Post_osztaly();
	return $postClass->load($id);
}
