$(document).ready(function() {
	$(".crossKom a").confirm({
		text: "Jste si jist, že chcete smazat tento komentář?",
		title: "Potvrzení o smazání",
		confirmButton: "Ano, jsem.",
		cancelButton: "Ne, nejsem.",
		dialogClass: "modal-dialog modal-lg"
	});

	confirm();

	function confirm()
	{
		$(".crossx").confirm({
		text: "Jste si jist, že chcete smazat tento příspěvek?",
		title: "Potvrzení o smazání",
		confirmButton: "Ano, jsem.",
		cancelButton: "Ne, nejsem.",
		dialogClass: "modal-dialog modal-lg"
	});
	}

	$(".vse").click(function() {
		$(".inputAutor").val('');
		$(".autori").slideUp('fast');

		$.ajax({
			url: "renderingPosts.php?filter=all"
		}).success(function(vysledek) {
			document.getElementById("posty").innerHTML = vysledek;
			confirm();
		});
	});


	$("#inputAutor").keyup(function () {
        var that = this,
        value = $(this).val();

        if (value.length >= 1 ) {
            $.ajax({
                url: "renderingPosts.php?filter=autori&autor=" + value,
                success: function(msg){
                    if (value==$(that).val()) {
                    	document.getElementById("posty").innerHTML = msg;
                    	confirm();
                    }
                }
            });
        }
        else 
        {
        	$.ajax({
				url: "renderingPosts.php?filter=all"
			}).success(function(vysledek) {
				document.getElementById("posty").innerHTML = vysledek;
				$(".crossx").confirm({
					text: "Jste si jist, že chcete smazat tento příspěvek?",
					title: "Potvrzení o smazání",
					confirmButton: "Ano, jsem.",
					cancelButton: "Ne, nejsem.",
					dialogClass: "modal-dialog modal-lg"
				});
			});
        }
    });
	
	$(".dleAutora p").click(function() {
		$(".autori").slideToggle('slow');
	});
});