<?php

require_once('bootstrap.php');

// $apiContext = new PayPal\Rest\ApiContext(
//     new PayPal\Auth\OAuthTokenCredential(
//         'ASi0-EhxUkf7fIAUMcP4Qt9wFmELBRaVJSni2znvIk2H-ZYtCmzzi7b2XH5zh0GpRDTf1Ot_1EhIohpe',     // ClientID
//         'EKoZ4H3l2GmZeQfLnzy81IDv2c298yjftuGl_v1hV2ag7WGvV3TEqeMqPxC_s1vfwwqX3BnyHE4VaJx_'      // ClientSecret
//     )
// );


?>
<html>
<body>
<div id="paypal-button">
</div>
<script src="http://www.paypalobjects.com/api/checkout.js" data-version-4></script>
<script>
    paypal.Button.render({
    
        env: 'sandbox', // Optional: specify 'sandbox' environment
    
        client: {
            sandbox:    'ASi0-EhxUkf7fIAUMcP4Qt9wFmELBRaVJSni2znvIk2H-ZYtCmzzi7b2XH5zh0GpRDTf1Ot_1EhIohpe'
        },

        payment: function() {
        
            var env    = this.props.env;
            var client = this.props.client;
        
            return paypal.rest.payment.create(env, client, {
                transactions: [
                    {
                        amount: { total: '10.00', currency: 'USD' }
                    }
                ]
            });
        },

        commit: true, // Optional: show a 'Pay Now' button in the checkout flow

        onAuthorize: function(data, actions) {
        
            // Optional: display a confirmation page here
        
            return actions.payment.execute().then(function() {
                
            });
        }

    }, '#paypal-button');
</script>

<script>
window.paypalCheckoutReady = function() {
    paypal.checkout.setup('VQ2PNKFBB8LFS', {
        environment: 'sandbox',
        container: 'formContainer',
        amount: '10',
        click: function () {
        	paypal.checkout.initXO();

        	var action = $.post('/set-express-checkout');

        	action.done(function (data){
        		paypal.checkout.startFlow(data.token);
        	});

        	action.fail(function (){
        		paypal.checkout.closeFlow();
        	});
        }
    });
};
</script>

</body>
</html>