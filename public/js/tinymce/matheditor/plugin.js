// (function(tiny){
//     tiny.PluginManager.add('mathEditor', function(editor,url){
//         var icon = '../matheditor/icon/square_root.png';    
//         editor.addButton('mathEditor',{
//             title : 'Math Editor',
//             image: icon,
//             onClick(){
//                 editor.windowManager.open({
//                     url: url + '/html/plugin.html',
//                     title: 'Math Editor',
//                     width: 640,
//                     height: 420
//                 });           
//             } 
//         });
//     });        
// }(tinymce));

 

tinymce.PluginManager.add("mathEditor", function (editor, url) {
    var pluginName = "设置行高";
    var icon = '../matheditor/icon/square_root.png';
    
//       editor.ui.registry.addIcon(
//         "mathEditor",
//         '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9.984 12.984v-1.969h12v1.969h-12zM9.984 18.984v-1.969h12v1.969h-12zM9.984 5.016h12v1.969h-12v-1.969zM6 6.984v10.031h2.484l-3.469 3.469-3.516-3.469h2.484v-10.031h-2.484l3.516-3.469 3.469 3.469h-2.484z"></path></svg>'
//   );
  //     editor.ui.registry.addIcon(
  //       "mathEditor",
  //       '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9.984 12.984v-1.969h12v1.969h-12zM9.984 18.984v-1.969h12v1.969h-12zM9.984 5.016h12v1.969h-12v-1.969zM6 6.984v10.031h2.484l-3.469 3.469-3.516-3.469h2.484v-10.031h-2.484l3.516-3.469 3.469 3.469h-2.484z"></path></svg>'
  // );
  editor.ui.registry.getAll().icons.layout || editor.ui.registry.addIcon('layout','<svg t="1603868236215" class="icon" viewBox="0 0 1035 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"p-id="17720" width="20" height="20"><path d="M940.2,261.5H470.9c-23,0-43.2,16.1-48.7,38.6L318.8,747.8L167,531.7c-9.2-13.3-24.5-21.3-40.6-21.3H59.8c-27.6,0-49.8,22.2-49.8,49.8c0,27.7,22.2,49.8,49.8,49.8h40.6l201.1,286.1c9.5,13.5,24.8,21.3,40.9,21.3c3.2,0,6.3-0.3,9.5-0.9c19.3-3.7,34.6-18.5,38.9-37.7l119.8-517.6h429.5c27.7,0,49.8-22.2,49.8-49.8C990,283.7,967.5,261.5,940.2,261.5z M871.9,224.3c-9.5,0-16.4-4.3-16.4-13.5c0-6.1,2.6-10.7,8.1-14.4l66.3-45.8c13.5-9.2,20.5-17,20.5-25.9c0-9.2-6.6-14.4-17.6-14.4c-10.4,0-19.6,5.5-26.2,11c-2.3,2-5.8,4.3-10.4,4.3c-7.8,0-13.5-6-13.5-13.8c0-4,2-8.1,4.9-10.7C898.1,91,914,82.6,933.8,82.6c28.8,0,47.5,15.8,47.5,38.3c0,17-8.1,29.7-32.9,47l-42.9,29.4h42.9c7.5,0,13.3,6.1,13.3,13.3c0,7.5-6.1,13.3-13.3,13.3h-76.6L871.9,224.3L871.9,224.3z" style="width:20px; height:20px" p-id="17721"></path> </svg>');

    editor.ui.registry.addButton("mathEditor", {
        icon: 'layout',
      text:'mathEditor',
      tooltip: pluginName,
      onAction: function () {
        // editor.undoManager.transact(function(){
        //     editor.focus();
        //     doAct();
        //  })
        editor.windowManager.openUrl({
               url: url + "/html/plugin.html",
          title: "Math Editor",
          width: 640,
          height: 420,
       });
     
      },
    });
  });