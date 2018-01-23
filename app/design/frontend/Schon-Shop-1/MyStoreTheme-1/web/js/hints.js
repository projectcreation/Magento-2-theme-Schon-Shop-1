document.addEventListener('DOMContentLoaded', function(){

    // console.log('ready');


    var hintsTemplates  = document.querySelectorAll('.debugging-hint-template-file');
    var hintsBlocks     = document.querySelectorAll('.debugging-hint-block-class');
    var hints           = document.querySelectorAll('.debugging-hints');


    // console.log(hints);


    hintsTemplates.forEach(function(item, i, hintsTemplates) {
        item.style.background   = '#246374';
    });


    hintsBlocks.forEach(function(item, i, hintsBlocks) {
        item.style.background   = '#323232';
        item.style.color        = '#ffffff';
    });


    hints.forEach(function(item, i, hints) {
        item.style.border   = '1px dotted #246374';
    });
});


