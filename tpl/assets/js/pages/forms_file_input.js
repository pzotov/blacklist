$(function() {
    // dropify file input
    altair_form_file_dropify.init();
});


altair_form_file_dropify = {
    init: function() {

    	console.log('dropify');
        $('.dropify').dropify();

        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove:  'Supprimer',
                error:   'Désolé, le fichier trop volumineux'
            }
        });

        $('.dropify-ru').dropify({
            messages: {
	            'default': 'Перетяните файл сюда или кликните',
	            'replace': 'Перетяните файл сюда или кликните, чтобы заменить файл',
	            'remove':  'Удалить',
	            'error':   'Файл слишком большой'
            }
        });

    }
};