function start()
{
	$(document).ready(function() {
		console.log("Inside ready");

		var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
								$('.profile-pic').css('background-image',"url("+e.target.result+")");
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
		 $.ajax({
							url: './Controller.php',
							type: 'POST',
							data: fileFormData,
							processData: false,
							contentType: false,
							success: function(data) {
						//  $('#cover').hide();
						console.log(data);
					// 				if($.trim(data) == "success"){
					// 			successPopUpWithRD("Existing Appointment Letter uploaded successfully!");
					// 				}
					// else{
					// 	errorPopUp("error: some problem while uploading the existing Appointment letter!");
					// }
							},
							error: function(xhr,error){
							// 	$('#cover').hide();
							// errorPopUp("error: some problem while uploading the existing Appointment letter!");
							console.log(error);
							}
					});
			});

	});

}
start();
