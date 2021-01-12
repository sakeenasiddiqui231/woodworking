jQuery(document).ready(function(){

jQuery('#publish').click(function(e)
{
    // alert("value submitted");   
    e.preventDefault();

var regular = jQuery('#regular').val();
// alert("value submitted");
var discount = jQuery('#discounted').val();

if(parseInt(regular)<parseInt(discount))
{
    alert("regular price must be higher than discounted price");
      jQuery('#discounted').val("");

}
else {
    jQuery("#post").submit();
   
}
});

});
