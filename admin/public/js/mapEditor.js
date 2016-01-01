/*Reference
	https://developers.google.com/maps/documentation/javascript/3.exp/reference
	https://developers.google.com/maps/documentation/javascript/examples/save-simple
	https://developers.google.com/maps/documentation/javascript/examples/marker-remove
*/
;
jQuery.widget("ui.mapEditor",{

	ComponentsIncluded: ['lamp'],
	current_selected_client:undefined,
	options:{},
	current_selected_network_id: 1,
	current_selected_network_name: "Networks 086",
	editors : [],
	networks:undefined,
	mode:'lampSequence',
	sequence_count:0,
	sequence:[],

	_create: function(){
		this.setupTools();
	},

	setupTools: function(){
		var self = this;

		$.each(self.ComponentsIncluded, function(index, component) {
			$.atk4.includeJS("js/plugins/"+component+".js");
		});

		$.atk4(function(){
			window.setTimeout(function(){
					self.setupToolBar();
					self.loadSavedNetworks();
					self.render();
				},200);
		});
	},

	setupToolBar : function(){
		var self = this;
		
		self.panel = $('#map-editor-tool-panel');
		self.fixed_tool_panel = $('.map-editor-fixed-tool-panel');

		//Make Draggable options Panel in containment of mapeditor
		map_editor_info_container = $('.map-editor-info-container');
		map_info_draggable_handler = $('.map-editor-info-draggable-handler');
		map_editor_container = $('#xmapeditor');

		//Make MapEditor info Panel Draggable
		$(map_editor_info_container).draggable({
			containment: "parent",
			handle: map_info_draggable_handler 
		});

		$.each(self.ComponentsIncluded, function(index, component) {
			var temp = new window[component+'_Component']();
			temp.init(self);
			tool_btn = temp.renderTool(self.panel);
			self.editors[component] = temp.editor;
		});

		sequence_btn = $('<input type="button" value="lampSequence" class="atk-button-small">').appendTo(self.panel);
		sequence_btn.on('click',function(){
			self.options.mode = "lampSequence";
			self.options.sequence_count = 0;
		});
		normal_btn = $('<input type="button" value="Sequence ok" class="atk-button-small">').appendTo(self.panel);
		normal_btn.on('click',function(){
			self.options.mode = "Normal";
			self.options.sequence_count = 0;
			console.log(self.options.sequence);
		});

	},

	//Load Saved Networks
	loadSavedNetworks:function(){
		self = this;
		self.options.networks  = JSON.parse(self.options.networks);
		$.each(self.options.networks,function(network_id,network){
			//GMap Function define in mapeditor.html
			drawLine(self,self.getLine(network_id),network_id);
		});

	},

	//return order of lamp with latitude or longitude
	getLine:function(network_id){
		if(!network_id)
			alert('Required: Network id not define');
		
		// console.log(self.options.networks[network_id].line);
		// $.each(self.options.networks[network_id].line,function(){

		// });

		var coordinates = [
		    {lat: 50, lng: 10,device_type:'lamp','network_id':1,'device_id':34},
		    {lat: 50, lng: 11,device_type:'lamp','network_id':1,'device_id':35},
		    {lat: 50, lng: 12,device_type:'lamp','network_id':1,'device_id':35},
		    {lat: 50, lng: 13,device_type:'lamp','network_id':1,'device_id':35}
		  ];

		return coordinates;
	},

	render:function(param){

	},

	addBridge:function(){

	},
	
	addNetwork:function(){
		$.univ().frameURL('Create New Network','?page=network_oln');
	},

	infoWindow: function(marker){

		$(this.lat).val(marker.position.lat());
		$(this.lng).val(marker.position.lng());
		this.infowindow.show();
	},

	setLampSequence: function(device_id,network_id,sequence){
		if(this.options.networks[network_id]){
			old_line = this.options.networks[network_id].line;
			old_line[sequence] = device_id;
			console.log(old_line);
		}


	}


});
