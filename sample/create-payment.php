<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="wrapper">
        <div class="checkout container">

            <header>
                <h1>Drop-in UI</h1>
                <p>
                    Make a test payment with Braintree using PayPal or a card
                </p>
            </header>

            <form method="post" id="payment-form" action="checkout.php">
                <section>
                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>

                    <label for="amount">
                        <span class="input-label">Amount</span>
                        <div class="input-wrapper amount-wrapper">
                            <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                        </div>
                    </label>
                </section>

                <button class="button" type="submit"><span>Test Transaction</span></button>
            </form>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script> <!--Uses Braintree.js-->
    <script>
        var client_token = "<?php echo(Braintree\ClientToken::generate()); ?>"; /*Creates the client_token on page load. This is done with the PHP scripts on the back end*/
        braintree.setup(client_token, 'dropin', { /*uses the client token generated above and sets the "dropin" option for the transaction*/
            container: 'bt-dropin', /*tells the javascript which HTML div to insert the fields into*/
            form: 'payment-form', /*tells the javascript which form to pull the amount from*/
            paypal: {
                container: 'bt-dropin',
                singleUse: false,
                billingAgreementDescription: 'Desciption goes here',
                amount: 10.00,
                currency: 'USD',
                displayName: 'Eric\'s Store',
                enableShippingAddress: true,
                shippingAddressOverride: {
                    recipientName: 'Scruff McGruff',
                    streetAddress: '1234 Main St.',
                    extendedAddress: 'Unit 1',
                    locality: 'Chicago',
                    countryCodeAlpha2: 'US',
                    postalCode: '60652',
                    region: 'IL',
                    phone: '123.456.7890',
                    editable: false
                }
            }
        });
    </script>
</body>
</html>
