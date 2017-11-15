// JavaScript Document
$(document).ready(function(){
	$('#conceptual').carouFredSel({
		responsive	: true,
		scroll		: {
			fx		: "crossfade",
			duration: 3000
		},
		prev		: {
			button	: '#bt_prev',
			key		: 'left'
		},
		next		: {
			button	: '#bt_next',
			key		: 'right',
		},
		circular	: true,
		auto		: true,
		pagination	: '#pag'
	});
});