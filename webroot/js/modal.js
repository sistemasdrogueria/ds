$(function() {
	$("#opener,#openert").click(function() {
		var xcoord = $('#opener').position().left - 100;
		var ycoord = $('#opener').position().top - 100;
		$("#dialog_carro").dialog('open');
	});

	var dialog = $("#dialog_carro").dialog({
		autoOpen: false,
		position: {
			my: "right center-50",
			at: "right-155 top",
			of: window
		},
		minWidth: 400,
		resizable: true,
		title: "Carro de Compras",
	});

});