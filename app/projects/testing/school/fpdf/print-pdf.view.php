<style>
body { 
    font: 13px/1.5 'Helvetica Neue', Arial, 'Liberation Sans', FreeSans, sans-serif; /* 960.gs */
    background:#ececec; 
} 
.col { 
    width:50%; 
    float:left; 
} 
fieldset { 
    border:1px solid #474747; 
    -moz-border-radius:5px; 
    -webkit-border-radius:5px; 
    margin-bottom:10px; 
} 
legend { 
    background:#474747; 
    color:#fff; 
    padding:3px 15px; 
    -moz-border-radius:5px; 
    -webkit-border-radius:5px; 
    font-weight:bold; 
} 
#wrap { 
    width:820px; 
    padding:20px; 
    margin:20px auto; 
    background:#fff; 
    border:1px solid #ccc; 
    -moz-border-radius:10px; 
    -webkit-border-radius:10px; 
} 
p { 
    padding:2px; 
} 
label { 
    display:inline-block; 
    width:100px; 
    font-weight:bold; 
} 
label:after { 
    content: ":"; 
} 
input { 
    display:inline-block; 
    width:200px; 
    border:1px solid #ccc; 
    padding:5px; 
    margin:0; 
    -moz-border-radius:5px; 
    -webkit-border-radius:5px; 
} 
thead  td { 
    text-align:center; 
    font-weight:bold; 
} 
td + td > input { 
    width:80px; 
} 
button { 
    border:1px solid #474747; 
    background:#ccc; 
    -moz-border-radius:5px; 
    -webkit-border-radius:5px; 
    padding:10px; 
    margin:10px; 
    font-weight:bold; 
    font-size:200%; 
} 
button:hover { 
    background:#ececec; 
    cursor:pointer; 
}
</style>

<div id="wrap"><div> 
    <h1>Checkout</h1> 
    <form method="post" action=""> 
 
    <fieldset> 
    <legend>Personal Information</legend> 
    <div class="col"> 
        <p> 
            <label for="name">Name</label> 
            <input type="text" name="name" value="John Doe" /> 
        </p> 
        <p> 
            <label for="email">Email Address</label> 
            <input type="text" name="email" value="joh@doe.com" /> 
        </p> 
    </div> 
    <div class="col"> 
        <p> 
            <label for="address">Address</label> 
            <input type="text" name="address" value="123 Main Street" /> 
        </p> 
        <p> 
            <label for="city">City</label> 
            <input type="text" name="city" value="Toronto" /> 
        </p> 
        <p> 
            <label for="province">Province</label> 
            <input type="text" name="province" value="Ontario" /> 
        </p> 
        <p> 
            <label for="postal_code">Postal Code</label> 
            <input type="text" name="postal_code" value="A1B 2C3" /> 
        </p> 
        <p> 
            <label for="country">Country</label><input type="text" name="country" value="Canada" /> 
        </p> 
    </div> 
</fieldset>

<fieldset> 
    <legend>Purchases</legend> 
    <table> 
        <thead> 
            <tr><td>Product</td><td>Price</td></tr> 
        <thead> 
        <tbody> 
            <tr> 
                <td><input type='text' value='a neat product' name='product[]' /></td> 
                <td>$<input type='text' value='10.00' name='price[]' /></td> 
            </tr> 
            <tr> 
                <td><input type='text' value='something else cool' name='product[]' /></td> 
                <td>$<input type='text' value='9.99' name='price[]' /></td> 
            </tr> 
            <tr> 
                <td><input type='text' value='buy this too!' name='product[]' /></td> 
                <td>$<input type='text' value='17.85' name='price[]' /></td> 
            </tr> 
            <tr> 
                <td><input type='text' value='And finally this' name='product[]' /></td> 
                <td>$<input type='text' value='5.67' name='price[]' /></td> 
            </tr> 
        </tbody> 
    </table> 
</fieldset>

<button id="button-print" type="submit">Submit Order</button>


    </form> 
</div></div>


<script>
$(document).ready(
    function() {
        $('#button-print').click( function() {
            // alert('HERE '+'<?path("pdf-ajax")?>');

            $.post( 
                "<? path('pdf-ajax')?>", 
                $('form').serialize(), 
            function(file_name, success) { 
                // alert('HERE 2|'+file_name.trim()+'|');

$('div#wrap div').fadeOut( function () { 
$(this).empty().html(
    "<h2>Thank you!</h2><p>Thank you for your order. Please <a href='/"+file_name.trim()+"'>download your reciept</a>. </p>").fadeIn(); 
}); 
                     
            });
            return false; 

            }
        );

    }
);
</script>

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script> 
<script type="text/javascript"> 
// $('button').click(function () { 
$('.__button').click(function () { 
    // $.post($('form').attr('action'), $('form').serialize(), function () { 
    $.post(
        // '<? path('pdf-ajax') ?>', 
        '<?= path('translate') ?>', 
        $('form').serialize(), 
        function () { 
        $('div#wrap div').fadeOut( function () { 
            $(this).empty().html("<h2>Thank you!</h2><p>Thank you for your order. Please <a href='reciept.pdf'>download your reciept</a>. </p>").fadeIn(); 
        }); 
    }); 
    return false; 
}); 
</script> -->
