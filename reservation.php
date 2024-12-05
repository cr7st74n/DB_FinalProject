<!--

Add a wrapper element with .form-group, around each form control, 
to ensure proper margins

-->
<!DOCTYPE html>
<html lang="en">

<?php include("./view/head.php"); ?>
<body>
    <?php include('./view/header.php'); ?>
    <div class="container mt-2">
        <?php
        $i = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstname = isset($_POST['Firstname']) ? htmlspecialchars($_POST['Firstname']) : '';
            $lastname = isset($_POST['Lastname']) ? htmlspecialchars($_POST['Lastname']) : '';
            $streetname = isset($_POST['Street']) ? htmlspecialchars($_POST['Street']) : '';
            $city = isset($_POST['City']) ? htmlspecialchars($_POST['City']) : '';
            $state = isset($_POST['State']) ? htmlspecialchars($_POST['State']) : '';
            $zip = isset($_POST['Zip']) ? htmlspecialchars($_POST['Zip']) : '';
            $in = isset($_POST['In']) ? new DateTime($_POST['In']) : '';
            $out = isset($_POST['Out']) ? new DateTime($_POST['Out']) : '';
            $people = isset($_POST['Number']) ? (int)$_POST['Number'] : '';
            $room = isset($_POST['Room']) ? $_POST['Room'] : '';
            $email = isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : '';
            $phone = isset($_POST['Phone']) ? htmlspecialchars($_POST['Phone']) : '';
            $payment = isset($_POST['Payment']) ? $_POST['Payment'] : '';
            $cardnum = isset($_POST['Cardnum']) ? htmlspecialchars($_POST['Cardnum']) : '';
            $requests = isset($_POST['Request']) ? htmlspecialchars($_POST['Request']) : ' ';

            $nights = $in->diff($out)->days ?: 1;

            $roomprice = ['King' => 200, 'Queen' => 150, 'Suite' => 300];
            $tax = 1.07;

            $cost = $roomprice[$room] * $nights * $tax;

            echo "<h2>Thank you $firstname $lastname for your reservation</h2>";
            echo "<p>The following is the information that you entered:</p>";
            echo "<table class='table table-striped' style='width: 100%;'>";

            $fields = [
                'Number & Street' => $streetname,
                'City' => $city,
                'State' => $state,
                'Zip Code' => $zip,
                'Check-in Date' => $in->format('Y-m-d'),
                'Check-out Date' => $out->format('Y-m-d'),
                'Room Type' => $room,
                'Number of People' => $people,
                'Number of Days' => $nights,
                'Email' => $email,
                'Phone Number' => $phone,
                'Credit Card' => $payment,
                'Card Number' => $cardnum,
                'Special Request' => $requests,
                'Total Charge' => "$" . number_format($cost, 1)
            ];

            foreach ($fields as $label => $value) {
                echo "<tr><th style='width: 30%;'>$label</th><td>$value</td></tr>";
                $i++;
            }
            echo "</table>";
        } else { ?>

            <div class="container">
                <form class="form-horizontal" action="" method="POST">
                    <!-- Form Fields -->
                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="firstname">First Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="firstname" name="Firstname" autofocus required>
                        </div>
                    </div>
                    <!-- Add remaining form fields here... -->
                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="lastname">Last Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lastname" name="Lastname" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="street">Number & Street:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="street" name="Street" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="city">City:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="city" name="City" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="state">State:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="state" name="State" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="zip">Zip Code:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="zip" name="Zip" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="in">Check-in Date:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="in" name="In" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="out">Check-out Date:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="out" name="Out" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="number">Number of People:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="number" name="Number" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="room">Room Type:</label>
                        <div class="col-sm-10">
                            <input list="rooms" class="form-control" id="room" name="Room" required>
                            <datalist id="rooms">
                                <option value="King">
                                <option value="Queen">
                                <option value="Suite">
                            </datalist>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="phone">Phone:</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" id="phone" name="Phone" placeholder="(###) ###-####" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="email">E-mail Address:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="Email" placeholder="name@domain.com" required>
                        </div>
                    </div>

                    <div class="row p-1">
                        <label class="control-label col-sm-2" for="payment">Payment:</label>
                        <div class="col-sm-10">
                            <input list="payment_type" class="form-control" id="payment" name="Payment" required>
                            <datalist id="payment_type">
                                <option value="MC">
                                <option value="VISA">
                                <option value="AMEX">
                                <option value="Discover">
                            </datalist>
                        </div>
                    </div>
                    
                    <div class="row p-1">
                      <label class="control-label col-sm-2" for="cardnum">Card Number:</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="cardnum"
                          name="Cardnum" >
                      </div>
                    </div>

                    <div class="row p-1">
                      <label class="control-label col-sm-2" for="request">Special Requests:</label>

                      <div class="col-sm-10">
                        <textarea input type="text" class="form-control" id="request"
                          name="Request"> </textarea>

                      </div>
                    </div>

                  <div class="row p-1">
                    <!--  <label class="control-label col-sm-2"></label> -->
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="submit">Reserve Now</button>
                      <button type="reset" class="btn btn-success">Reset</button>
                    </div>
                  </div>
                </form>
            </div>
        <?php } ?>
    </div>
    <?php include("./view/footer.php"); ?>
</body>

</html>