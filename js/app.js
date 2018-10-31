jQuery('.teacher-toggle').click(function(event){
    event.preventDefault();
    var $teacherRow = jQuery(this).closest('.teachers-row');

    // Place form inside the html of the toggled teacher
    jQuery('#frm_form_8_container').appendTo($teacherRow.find('.form-container'));
    jQuery('#field_professorname').val($teacherRow.find('.teacher-email').text().trim());
    $teacherRow.toggleClass('toggled').find('.contact-teacher').slideToggle();
});

jQuery('#prenav-toggle').click(function(event){
    event.preventDefault();
    jQuery(this).toggleClass('toggled');
    jQuery('.navbar-pre').slideToggle();
});

jQuery('.toggle-categories').click(function(event){
    event.preventDefault();
    jQuery('.program-categories').toggleClass('translated');
})