
tinymce.PluginManager.add('so_mce_button', function(editor, url){

    var menuData = soMCEMenuData(soMCEMenu, editor);

    editor.addButton('so_mce_button', {
        text: "Special offers",
        type: 'menubutton',
        icon: false,
        menu: menuData,
    });


});

function soMCEMenuData(menuData,  editor){

    var result = [];

    $(jQuery.parseJSON(JSON.stringify(soMCEMenu))).each(function(){
        result.push({
            text: this.text,
            value: this.value,
            onclick: function(){
                editor.insertContent(this.value());
            }
        });
    })

    return result;

}
