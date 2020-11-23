$('a[href^="#playlist"]').on('click', function(e) {
	var id = $(this).attr('href'),
			targetOffset = $(id).offset().top;
			
	$('html, body').animate({ 
    //o - 50 serve para criar uma distância de 50px entre o destino e o topo da página
  
		scrollTop: targetOffset - 50
	}, 500);
});
