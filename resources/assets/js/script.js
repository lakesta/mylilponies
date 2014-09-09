(function($) {
    $(function () {
        'use strict';

        // Change this to the location of your server-side upload handler:
        var url = $('#upload').attr('data-url'); //'/admin/server/upload/csv';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $('p.upload-name').remove();

                $.each(data.result.files, function (index, file) {
                    $('<p/>').addClass('upload-name').appendTo('#files');

                    if ($.inArray(file.type, ['image/jpeg', 'image/png']) > -1){
                        $('p.upload-name').append('<img src="/img/uploads/images/thumbnail/'+file.name+'" /><div class="spacer" />');
                    } else {
                        $('p.upload-name').text(file.name);
                    }

                    $('p.upload-name').append('<input type="hidden" name="upload-name" value="'+file.name+'" />');
                });

                $('div.upload').remove();
                $('#progress').hide();
                $('#progress .progress-bar').css('width', '0%');
                $('.fileinput-button').addClass('btn-success').removeClass('btn-default');
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            },
            add: function (e, data) {
                data.context = $('<button/>').addClass('btn btn-primary').text('Start Upload')
                    .appendTo('#upload')
                    .click(function () {
                        $('#progress').show();
                        $('.fileinput-button').addClass('btn-default').removeClass('btn-success');

                        data.context = $('<div/>').text('Uploading and processing, please wait...').addClass('alert alert-info upload').replaceAll($(this));
                        data.submit();
                    });
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

        $('.fileinput-button').click(function(e){

            if ($(this).hasClass('btn-default')){
                return;
            }

            $('.upload').remove();

            $('#fileupload').trigger('click', function(e){
                e.stopPropagation();
            });
        });

        $('.checkall').on('click', function (e) {
            e.preventDefault();

            var check = $(this).attr('data-check');

            $(this).closest('fieldset').find(':checkbox').prop('checked', (check === "true"));
        });

        $('#checkungifted').on('click', function(e){
            e.preventDefault();
            var $container = $('.well');

            $(':checkbox', $container).prop('checked', false);

            $.each(ungifted, function( index, id ) {
                $('#uid-'+id, $container).prop('checked', true);
            });
        });

        if ( $.fn.daterangepicker ){
            $('input[name="daterange"]').daterangepicker();
        };

        if ( $.fn.tooltip ){
            $('.send-user-item').tooltip({
                html: true
            });

            $('.toggle-tooltip').tooltip({
                html: true
            });
        };
    });
})(jQuery);

$(document).ready(function() {

    $('#step2').on('click', function(e){
       e.preventDefault();
       // Get selection
       $gift = $('li.active').attr('data-id');
       // Set form val
       $('#gift').val($gift);
       // Submit form so its more secure
       $('#hiddenSubmit').submit();
    });

});
