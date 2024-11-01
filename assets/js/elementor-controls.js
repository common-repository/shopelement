jQuery(document).ready(function($) {
    console.log('Elementor controls loaded');
    var carouselSetting = $(document).find('#elementor-controls').find('select[data-setting=customer_review_carousel]');

    carouselSetting.on('change', function() {
        console.log('Elementor control changed');
        var selectedValue = $(this).val();
        if (selectedValue === 'two' || selectedValue === 'three') {
            $('.elementor-control-designation').show();
        } else {
            $('.elementor-control-designation').hide();
        }
    });

    // Trigger change event on page load
    carouselSetting.trigger('change');
});


