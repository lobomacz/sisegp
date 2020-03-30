
$(document).ready(() => {

	$('.mensaje-error').fadeOut(5000);

	$('[data-toggle="tooltip"]').tooltip();

	$('.menu-anidado').hover((e) => {
		$('.menu-anidado').dropdown('hide');
		$(e.target).dropdown('show');
		e.stopPropagation();
	});

});


