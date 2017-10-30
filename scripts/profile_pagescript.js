function start()
{
	$(document).ready(function() {
		console.log("Inside ready");
		var readURL = function(input) {
        	if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					var imageBlob = e.target.result;
                    var file = input.files[0];
                    var _URL = window.URL || window.webkitURL;
                    img = new Image();
                    var imgwidth = 0;
                    var imgheight = 0;
                    var maxwidth = 750;
                    var maxheight = 750;

                    img.src = _URL.createObjectURL(file);
                    img.onload = function() {
                        imgwidth = this.width;
                        imgheight = this.height;
                        console.log("width & height:" + imgwidth + "&" + imgheight);
                        $("#width").text(imgwidth);
                        $("#height").text(imgheight);
                         if(imgwidth <= maxwidth && imgheight <= maxheight){
                             $('.profile-pic').css('background-image',"url("+imageBlob+")");
                         }else{
                             $('#errorModal .modal-body').html("<p>Dimensions of the image are too weird!! Try the one with both width & height are less than 750px..</p>");
                             $('#errorModal').on('hidden.bs.modal', function (e) {
                                 $('#errorModal').off();
                             });

                             $("#errorModal").modal("show");
                             $("#errorModal").css("z-index","1100");
                             setTimeout(function() {$('#errorModal').modal('hide');}, 4000);
						 }

                    }

				}

				reader.readAsDataURL(input.files[0]);
			}


		}
		$(".file-upload").on('change', function(){
			readURL(this);
		});

		$(".profile-pic").on('click', function(){
			$(".file-upload").trigger('click');
		});


		$(document).on("click",".updateUser",function(e){
			// var recruitmentId = $(this).attr("recid");
			e.preventDefault();
			var fileFormData = new FormData();
			fileFormData.append('filetoUpload', $('.file-upload')[0].files[0]);
			fileFormData.append("updateProfile",'');
			 var file_name=$(".file-upload").val();
			 fileFormData.append("file_name",file_name);

			 fileFormData.append("firstName",$('.firstName').val());
			 fileFormData.append("lastName",$('.lastName').val());
			 fileFormData.append("password",$('.password').val());
			 fileFormData.append("email",$('.email').val());
			 fileFormData.append("whatIDo",$('.whatIDo').val());
			 fileFormData.append("status",$('.status').val());
			 fileFormData.append("phoneNumber",$('.phoneNumber').val());
			 fileFormData.append("skype",$('.skype').val());

			 $(".not_reallyrequired").removeAttr("required");
			 if(!$("#updateForm")[0].checkValidity()){
                 $("#dummysubmit").trigger("click");
                 $(".not_reallyrequired").attr("required",true);
                 return;
			 }
            $(".not_reallyrequired").attr("required",true);
		 	$.ajax({
					url: './Controller.php',
					type: 'POST',
					data: fileFormData,
					processData: false,
					contentType: false,
					success: function(data) {
						console.log(data);
                        if(data.includes("success")){
							$('#successModal .modal-body').html("<p> Profile updated Successfully. </p>");
							$('#successModal').on('hidden.bs.modal', function (e) {  
								$('#successModal').off();
																		
							});
						 
							 
							$("#successModal").modal("show");
							$("#successModal").css("z-index","1100");
							setTimeout(function() 
								{
									$('#successModal').modal('hide');
									
								}, 4000);
							}
						else if($.trim(data).split("-")[0]=="fail")
							{
								$('#errorModal .modal-body').html("<p>"+ $.trim(data).split("-")[1]+"</p>");
								$('#errorModal').on('hidden.bs.modal', function (e) {
									$('#errorModal').off();
								});
								
								$("#errorModal").modal("show");
								$("#errorModal").css("z-index","1100");
								setTimeout(function() {$('#errorModal').modal('hide');}, 4000);
							}
						},
						error: function(xhr,error){
							console.log(error);
						}
					});
			});

	});

}
start();
