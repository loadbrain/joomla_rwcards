window.addEvent('domready', function(){

    document.formvalidator.setHandler('categoryname', function(value){
        regex = /[\d\w].+\s*/;
        return regex.test(value);
    });


});
