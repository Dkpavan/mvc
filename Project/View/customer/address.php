
            <div class="Address data mt-4 ">
                <h3>Shipping Address </h3>
                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="Hname">House name</label>
                            <input type="text" class="form-control" value="<?php echo $shippingAddress->homeName; ?>"
                                name="shipping[homeName]">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="street">Street Address</label>
                            <input type="text" class="form-control" value="<?php echo  $shippingAddress->street; ?>"
                                name="shipping[street]">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="land">Landmark</label>
                            <input type="text" class="form-control" value="<?php echo  $shippingAddress->landmark; ?>"
                                name="shipping[landmark]">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="city">City</label>
                            <input type="text" name="shipping[city]" value="<?php echo  $shippingAddress->city; ?>"
                                class="form-control">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="pin">Pin code</label>
                            <input type="number" class="form-control" value="<?php echo  $shippingAddress->code; ?>"
                                name="shipping[code]">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="state">State</label>
                            <input type="text" name="shipping[state]" value="<?php echo  $shippingAddress->state; ?>"
                                class="form-control">
                        </div>

                    </div>

            </div>

            <div class="Address data mt-4 ">
                <h3>Billing Address</h3>
                <h6>optional*</h6>
                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="billing[homeName]">House name</label>
                            <input type="text" class="form-control" name="billing[homeName]" value="<?php echo $billingAddress->homeName ;?>">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="billing[street]">Street Address</label>
                            <input type="text" class="form-control" name="billing[street]" value="<?php echo $billingAddress->street;?>">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="billing[landmark]">Landmark</label>
                            <input type="text" class="form-control" name="billing[landmark]" value="<?php echo $billingAddress->landmark;?>">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="city">City</label>
                            <input type="text" name="billing[city]" class="form-control" value="<?php echo $billingAddress->city ;?>">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label for="pin">Pin code</label>
                            <input type="number" class="form-control" name="billing[code]" value="<?php echo $billingAddress->code ;?>">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="state">State</label>
                            <input type="text" name="billing[state]" class="form-control" value="<?php echo $billingAddress->state ;?>">
                        </div>

                    </div>
