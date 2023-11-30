<div class="container  d-flex justify-content-center align-items-center">
    <div class="position-relative">
        <div class="card p-2 text-center" style="margin-top: 200px;">
            <h6>Please enter the one time password <br> to verify your account</h6>
            <div> <span>A code has been sent to</span> <small>*******<?php echo $_GET['mobile'] ?></small> </div>
            <form action="login.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> <input class="m-2 text-center form-control rounded" type="text" id="first" name="first" maxlength="1" /> <input class="m-2 text-center form-control rounded" type="text" id="second" name="second" maxlength="1" /> <input class="m-2 text-center form-control rounded" type="text" id="third" name="third" maxlength="1" /> <input class="m-2 text-center form-control rounded" type="text" id="fourth" name="fourth" maxlength="1" /> <input class="m-2 text-center form-control rounded" type="text" id="fifth" name="fifth" maxlength="1" /> <input class="m-2 text-center form-control rounded" type="text" id="sixth" name="sixth" maxlength="1" /> </div>
            <div class="mt-4"> <button class="btn btn-danger px-4 validate" name="otpVerify" type="submit">Validate</button> </div>
        </div>
        </form>
    </div>
</div>