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
                    var minwidth = 250;
                    var minheight = 250;
                    var imgwidth = 0;
                    var imgheight = 0;
                    var maxwidth = 1250;
                    var maxheight = 1250;

                    img.src = _URL.createObjectURL(file);
                    img.onload = function() {
                        imgwidth = this.width;
                        imgheight = this.height;
                        console.log("width & height:" + imgwidth + "&" + imgheight);
                        $("#width").text(imgwidth);
                        $("#height").text(imgheight);
                         if(imgwidth <= maxwidth && imgwidth >=minwidth && imgheight >= minheight && imgheight <= maxheight ){
                             $('.profile-pic').css('background-image',"url("+imageBlob+")");
                         }else{
                             $('#errorModal .modal-body').html("<p>Dimensions of the image are too weird!! Try the one with both width & height are less than 1250px  and greater than 250px aswell..</p>");
                             $('#errorModal').on('hidden.bs.modal', function (e) {
                                 $('#errorModal').off();
                             });

                             $("#errorModal").modal("show");
                             $("#errorModal").css("z-index","1100");
                             setTimeout(function() {$('#errorModal').modal('hide');}, 2000);
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
			 fileFormData.append("pic_pref",$('input[name=radiogroup]:checked', '#updateForm').val());

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
						data = $.trim(data);
						console.log(data);
                        if(data.includes("success")){
							$('#successModal .modal-body').html("<p> Profile updated Successfully. </p>");
							$('#successModal').on('hidden.bs.modal', function (e) {
								$('#successModal').off();
								location.reload();
							});


							$("#successModal").modal("show");
							$("#successModal").css("z-index","1100");
							setTimeout(function()
								{
									$('#successModal').modal('hide');
									location.reload();
								}, 2000);
							}
						else if(data.includes("fail"))
							{
								$('#errorModal .modal-body').html("<p>"+ $.trim(data).split("-")[1]+"</p>");
								$('#errorModal').on('hidden.bs.modal', function (e) {
									$('#errorModal').off();
								});

								$("#errorModal").modal("show");
								$("#errorModal").css("z-index","1100");
								setTimeout(function() {$('#errorModal').modal('hide');location.reload();}, 2000);
							}
							else if(data.includes("Error"))
							{
								$('#errorModal .modal-body').html("<p>E-mail id already exists. Try different id.</p>");
								$('#errorModal').on('hidden.bs.modal', function (e) {
									$('#errorModal').off();
								});

								$("#errorModal").modal("show");
								$("#errorModal").css("z-index","1100");
								setTimeout(function() {$('#errorModal').modal('hide');location.reload();}, 2000);
							}
						},
						error: function(xhr,error){
							console.log(error);
						}
					});
			});
		$(document).on("click",".editProfile",function() {
            $(".editProfile").hide();
            $(".displayProfile").hide();
            $.post('./Controller.php',{"getProfileDetails":''},function (data){
				console.log(data);
            		var userData=$.parseJSON(data);
            		$('.password').val(userData[0]['password']);


			});

            $(".updateProfile").show();
		});

	});

}
start();
