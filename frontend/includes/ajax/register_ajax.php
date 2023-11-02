 <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>


 <script>
     $(document).ready(function() {

         // register
         $(document).on('click', '.registerBtn', function(e) {
             e.preventDefault();
             let name = $('#name').val();
             let role = $('#role').val();

             // let email = $('#email').val();
             let mobile = $('#mobileRegister').val();
             let category = $('#category').val();

             let location = $('#location').val();
             let registerRequest = "registerRequest";
             
             // Iterate through checked checkboxes
             $('input[type="checkbox"]:checked').each(function() {
                 services.push($(this).val());
             });

             console.log(mobile);
             // Check if category is not set and set a default value
              
             $.ajax({
                 url: "register.php",
                 method: 'post',
                 dataType: 'text',
                 data: {
                     name: name,
                     // email: email,
                     mobile: mobile,
                     role: role,
                     category: category,
                     location: location,
                     registerRequest: registerRequest,
                 },
                 success: function(response) {
                      
                         var res = JSON.parse(response);
                          
      
                         console.log(res);
                         if (res.status == 'success') {
                             $('#registerForm').addClass('d-none');
                             $('.modal-footer').addClass('d-none');
                             $('#otpRegisterForm').removeClass('d-none');
                             $('#otpRegisterMobile').val(res.mobile);
                             console.log( $('#otpRegisterMobile').val(res.mobile));
                             $('#alertMessage').addClass('d-none');
                         } else if (res.status == 'fail') {
                             $('#alertMessageRegister').removeClass('d-none').addClass('alert-danger').text(res.message);

                         }
                     

                 },
                 error:  function(xhr, status, error) {
                    console.error('AJAX error: ' + error);
                     if (xhr.status === 422) { // HTTP status code for validation errors
                         let error = xhr.responseJSON;
                         $('.errorDiv').empty(); // Clear previous errors
                         $.each(error.errors, function(index, value) {
                             $('.errorDiv').append('<span class="text-danger">' + value + '</span><br>');
                         });
                     } else {
                         console.error(xhr.statusText);
                     }
                 }


             });



         });

         // otp
         $(document).on('click', '.otpRegister', function(e) {
             e.preventDefault();

             let mobile = $('#otpRegisterMobile').val();
             // let otp = $('#otpInput').val();
             // let otpVerify = "otpVerify";
             console.log(mobile);
             // $.ajax({
             //     url: "",
             //     method: 'post',
             //     dataType: 'text',
             //     data: {
             //         mobile: mobile,
             //         otp: otp,
             //         otpVerify: otpVerify,
             //     },
             //     success: function(response) {
             //         var res = JSON.parse(response);
             //         if (res.status == 'success') {
             //             console.log(res.status);
             //             $('#loginModal').modal('hide');
             //             $('#loginForm').removeClass('d-none');
             //             $('#loginForm')[0].reset();
             //             $('#otpForm').addClass('d-none');

             //             window.location.href = 'index.php'; // Replace with the actual URL
             //         } else if (res.status == 'fail') {
             //             $('#alertMessage').addClass('alert-danger').removeClass('d-none')
             //                 .text(res.message).show();
             //         }
             //     }
             // });







         });

     });
 </script>
 <?php
    include_once('config.php');
    if (isset($_POST['loginRequest'])) {
        $mobile = $_POST['mobile'];

        $query = "SELECT * FROM users WHERE mobile = '$mobile'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Use $user as needed
        } else {
            $res = [
                'status' => 'fail',
                'message' => 'User with the provided mobile number does not exist'
            ];

            header('Content-Type: application/json');
            echo json_encode($res);
        }
    }

    ?>