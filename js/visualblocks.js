(function() {

	tinymce.create('tinymce.plugins.visualblocks', {
		init : function(editor, url) {
		
			var cssId, visualBlocksMenuItem, enabled;
			
			if(!window.NodeList) {
				return;
			}
			
			function toggleActiveState() {
				var self = this;
				
				self.active(enabled);
				
				editor.on('VisualBlocks', function() {
					self.active(editor.dom.hasClass(editor.getBody(), 'mce-visualblocks'));
				});
			}
			
			editor.addCommand('mceVisualBlocks', function() {
			
				var dom = editor.dom, linkElm;
			
				if(!cssId) {
					cssId = dom.uniqueId();
					linkElm = dom.create('link', {
						id: cssId,
						rel: 'stylesheet',
						href: tinyGrid.url + '/css/blocks.css'
					});
				
					editor.getDoc().getElementsByTagName('head')[0].appendChild(linkElm);
				}
			
				editor.on("PreviewFormats AfterPreviewFormats", function(e) {
					if(enabled) {
						dom.toggleClass(editor.getBody(), 'mce-visualblocks', e.type == "afterpreviewformats");
					}
				});
			
				dom.toggleClass(editor.getBody(), 'mce-visualblocks');
				enabled = editor.dom.hasClass(editor.getBody(), 'mce-visualblocks');
			
				if(visualBlocksMenuItem) {
					visualBlocksMenuItem.active(dom.hasClass(editor.getBody(), 'mce-visualblocks'));
				}
			
				editor.fire('VisualBlocks');
				
			});
			
			editor.addButton('visualblocks', {
				title : 'Show blocks',
				icon : 'icon-marquee',
				cmd: 'mceVisualBlocks',
				onPostRender: toggleActiveState
			});
			
			editor.addMenuItem('visualblocks', {
				text: 'Show blocks',
				cmd: 'mceVisualBlocks',
				onPostRender: toggleActiveState,
				selectable: true,
				context: 'view',
				prependToContext: true
			});
			
			editor.on('init', function() {
				if(editor.settings.visualblocks_default_state) {
					editor.execCommand('mceVisualBlocks', false, null, {skip_focus: true});
				}
			});
			
			editor.on('remove', function() {
				editor.dom.removeClass(editor.getBody(), 'mce-visualblocks');
			});
		
		},
		createControl : function(n, cm) {
			return null;
		}
		
	});
	
	tinymce.PluginManager.add('visualblocks', tinymce.plugins.visualblocks);

})();