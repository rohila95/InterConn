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
		 fileFormData.append("appointmentID",$.trim(1));
		 $.ajax({
							url: './services/updateProfile.php',
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
