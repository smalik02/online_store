jQuery(document).ready(function() {
// section sorting
    jQuery( "#sortable" ).sortable({ 
            placeholder: "ui-sortable-placeholder" 
    });

    jQuery( "#sortable" ).sortable({
        cursor: 'move',
        opacity: 0.65,
        stop: function ( event, ui){
        var data = jQuery(this).sortable('toArray');
            //  console.log(data); // This should print array of IDs, but returns empty string/array      
            jQuery( this ).parents( '.customize-control').find( 'input[type="hidden"]' ).val( data ).trigger( 'change' );
        }
    });
});