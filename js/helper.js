function name_to_url(name) {
    name = name.toLowerCase(); // lowercase
    name = name.replace(/[-]/g, ''); // remove everything that is not [a-z] or -
    name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
    name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
    return name;
}
function initButtonLFMSummernote() {
    var lfm = function(options, cb) {
        var route_prefix = (options && options.prefix) ? options.prefix : '/dashboard/file-manager';
        window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
        window.SetUrl = cb;
    };
    var LFMButton = function(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-picture"></i> ',
            tooltip: 'Insert image with filemanager',
            click: function() {

                lfm({type: 'image', prefix: '/infolagi/dashboard/file-manager'}, function(lfmItems, path) {
                    lfmItems.forEach(function (lfmItem) {
                        // context.invoke('insertImage', lfmItem.url);
                        $('.content').summernote('editor.insertImage', lfmItem.url);
                    });
                });

            }
        });
        return button.render();
    };
    return LFMButton;
}