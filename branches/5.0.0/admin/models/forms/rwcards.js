window.addEvent('domready', function(){
    document.formvalidator.setHandler('autor', function(value){
        regex = /^[\w\d\W]+$/;
        return regex.test(value);
    });

    document.formvalidator.setHandler('picture', function(value){
        regex = /^[\w\d\W]+$/;
        return regex.test(value);
    });


    $('jform_picture').addEvent('change', function(e){
        $('rwcardChosenImage').set('html', '<img />').setProperty('src', '../images/rwcards/' + $(this).getSelected().get("value"));
    });

});
