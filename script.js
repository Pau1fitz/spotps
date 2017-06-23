(function() {

	$(document).ready(function(){

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
				}

			});

		} else {

			$(".create-playlist").click(function(){

				window.location.href = "http://10.16.214.82/presave/authenticate.php";

			});

		}


	});

})();
