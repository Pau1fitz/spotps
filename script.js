(function() {

	$(document).ready(function(){

		if (typeof $.cookie('presaved') === 'undefined'){

			var code = window.location.href.substr(window.location.href.indexOf('?'));

			if(code.length > 1){

				var data = {
					code: code.slice(6)
				};

				$.ajax({
					url:"create-playlist.php",
					type:"POST",
					data: data,

					success:function(response) {
						console.log(response);
						$(".success-overlay").fadeIn("slow");
						$(".create-playlist").css("display", "none");
						$.cookie('presaved', 100);
					}

				});

			} else {

				$(".create-playlist").click(function(){

					window.location.href = "http://10.16.214.82/presave/authenticate.php";

				});

			}

		} else {

			$(".success-overlay").fadeIn("slow");
			$(".create-playlist").css("display", "none");

		}




	});

})();
