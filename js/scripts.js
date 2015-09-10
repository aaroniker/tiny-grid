jQuery(document).ready(function($) {
	
	tinymce.create('tinymce.plugins.TinyGridButtons', {
		init : function(ed, url) {
			
			ed.addButton('grid', {
				title : 'Grid',
				icon : 'icon-columns',
				onclick : function() {
					ed.windowManager.open( {
						title: 'Insert grid',
						width : 320,
						height: 150,
						body: [{
							type: 'listbox', 
							name: 'size', 
							label: 'Size', 
							'values': [
								{text: 'LG', value: 'lg'},
								{text: 'MD', value: 'md'},
								{text: 'SM', value: 'sm'},
								{text: 'XS', value: 'xs'}
							]
						},
						{
							type: 'listbox', 
							name: 'grid', 
							label: 'Grid', 
							'values': [
								{text: '2 Columns', value: '2'},
								{text: '3 Columns', value: '3'},
								{text: '4 Columns', value: '4'},
							]
						}],
						onsubmit: function(e) {
							switch(e.data.grid) {
								case '2':
								ed.selection.setContent('<div class="row"><div class="col-'+e.data.size+'-6">Col 1</div><div class="col-'+e.data.size+'-6">Col 2</div></div>');
								break;
								
								case '3':
								ed.selection.setContent('<div class="row"><div class="col-'+e.data.size+'-4">Col 1</div><div class="col-'+e.data.size+'-4">Col 2</div><div class="col-'+e.data.size+'-4">Col 3</div></div>');
								break;
								
								case '4':
								ed.selection.setContent('<div class="row"><div class="col-'+e.data.size+'-3">Col 1</div><div class="col-'+e.data.size+'-3">Col 2</div><div class="col-'+e.data.size+'-3">Col 3</div><div class="col-'+e.data.size+'-3">Col 4</div></div>');
								break;
							} 
						}
					});
				}
			});
		
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	
	tinymce.PluginManager.add('tiny_grid_scripts', tinymce.plugins.TinyGridButtons);
});