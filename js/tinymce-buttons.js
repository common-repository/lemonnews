(function() {
    tinymce.create('tinymce.plugins.lemon_news', {
        init : function(ed, url) {
            ed.addButton('lemon_news_shortcode_button', {
                title : 'LemonNews',
                cmd : 'lemonnews',
                image : url + '/icon-lemonnews-20x20.png'
            });
            ed.addCommand('lemonnews', function() {
                var shortcode = "[lemonnews]";
                ed.execCommand('mceInsertContent', 0, shortcode);
            });
        }

    });
    tinymce.PluginManager.add( 'lemon_news', tinymce.plugins.lemon_news );
})();