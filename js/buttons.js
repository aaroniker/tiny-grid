(function() {
	
     tinymce.create('tinymce.plugins.TinyGridButtons', {
          init : function(ed, url) {
			  
               ed.addButton('2grid', {
                    title : '2 Grid',
					icon : 'icon-content-left',
                    onclick : function() {
                         ed.selection.setContent('<div class="row"><div class="col-md-6">Col 1</div><div class="col-md-6">Col 2</div></div>');
                    }
               });
			  
               ed.addButton('3grid', {
                    title : '3 Grid',
					icon : 'icon-columns',
                    onclick : function() {
                         ed.selection.setContent('<div class="row"><div class="col-md-4">Col 1</div><div class="col-md-4">Col 2</div><div class="col-md-4">Col 3</div></div>');
                    }
               });
			   
          },
          createControl : function(n, cm) {
               return null;
          },
     });
	 
     tinymce.PluginManager.add('tiny_grid_button_script', tinymce.plugins.TinyGridButtons);
	 
})();