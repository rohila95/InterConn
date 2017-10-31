function start()
{
	$(document).ready(function() {
		console.log("Inside ready"); 
		
		$(".signIn").on('click', function(){
			window.location.href = "./index.php";
		});
		$( ".createUser" ).on("click",function(e) {
			console.log("in clickkk");
			e.preventDefault();
			$(".not_reallyrequired").removeAttr("required");
			 if(!$("#registerForm")[0].checkValidity()){
                 $("#dummysubmit").trigger("click");
                 $(".not_reallyrequired").attr("required",true);
                 return;
			 }
            $(".not_reallyrequired").attr("required",true);

			var myForm = document.getElementById('registerForm');
		   	var formData = new FormData(myForm),
		   	convertedJSON = {},
		   	it = formData.entries(),
		   	n;
		   	while(n = it.next()) {
		      if(!n || n.done) break;
		      convertedJSON[n.value[0]] = n.value[1];
		    }
		    var stringData = JSON.stringify(convertedJSON);
	     	console.log(convertedJSON);
		    $.ajax({
		        url: './Controller.php',
		        type: 'post',
		        data: {'register':stringData},
		        dataType: 'text',
		        success: function (data) {
		        	// console.log(data);
		        	if ($.trim(data).split("-")[0]=="fail")
		        	{
		        		$('#errorModal .modal-body').html("<p>"+$.trim(data).split("-")[1]+"</p>");
						$('#errorModal').on('hidden.bs.modal', function (e) {
							$('#errorModal').off();
						});
						
						$("#errorModal").modal("show");
						$("#errorModal").css("z-index","1100");

		        		// $('.uniqueEmail').html('Email Id already exists. Try with different Id.');
		        	}
		        	else
		        	{
		        		$('#successModal .modal-body').html("<p>Registration Successful. </p>");
						$('#successModal').on('hidden.bs.modal', function (e) {  
							$('#successModal').off();
							window.location.href = "./index.php";
										
						});
					 
						 
						$("#successModal").modal("show");
						$("#successModal").css("z-index","1100");

		        		// window.location.href = "./index.php";
		        	}

		        }

		    });

	 	});
		$.ajax({
	        url: './Controller.php',
	        type: 'post',
	        data: {'getworkspaces':''},
	        dataType: 'text',
	        success: function (data) {
	        	// console.log(data);
	        	if (data.includes("Error"))
	        	{
	        		console.log(data);
	        	}
	        	else
	        	{
	        		var obj = JSON.parse(data);
	        		selectOptStr='';
	        		obj.forEach(function(element)
	        		{
	        			selectOptStr+=' <option value="'+element["workspace_id"]+'">'+element["workspace_name"]+'</option>';
	        		});
	        		
	        		$('#workspaceid').html(selectOptStr);
	        	}

	        }

	    });

	});
}
start();
