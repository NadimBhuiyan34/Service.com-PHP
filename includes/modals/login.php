<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- alert message -->
                <div id="alertMessage" class="alert d-none" role="alert"></div>

                <!-- login form -->
                <form id="loginForm">
                  <div class="mb-3">
                      <label for="mobile" class="form-label">Mobile Number</label>
                      <input type="text" class="form-control"
                          id="mobile" placeholder="Enter your mobile" name="mobile" value="+88">
                      
                  </div>
                  <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-primary loginBtn">CONTINUE</button>
                  </div>
              </form>
              
            <!-- otp form -->
              <form id="otpForm" class="d-none" action="otp.php" method="POST">
                
                <input type="hidden" name="mobile" value="" id="otpMobile">
              
                    <div class="mb-3 text-center">
                        <h2>Enter OTP</h2>
                        <p>We've sent an OTP to your mobile number. Please enter it below.</p>
                    </div>
                    <div class="mb-3 d-flex justify-content-center">
                    <input type="text" inputmode="numeric" autocomplete="one-time-code" id="otpInput" name="otp" />
                    </div>
                    
                 
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="otpVerify">Verify OTP</button>
                </div>
            </form>
  
            </div>
        </div>
    </div>
  </div>
  
<script>
if ('OTPCredential' in window) {
  window.addEventListener('DOMContentLoaded', e => {
    const input = document.querySelector('input[autocomplete="one-time-code"]');
    
    navigator.credentials.get({
      otp: {transport:['sms']}
    }).then(otp => {
      if (otp && otp.code) {
        input.value = otp.code;
        // Find the form and submit it
        const form = input.closest('form');
        if (form) {
          form.submit();
        }
      }
    });
  });
}
</script>

