/*Reference
	https://developers.google.com/maps/documentation/javascript/3.exp/reference
	https://developers.google.com/maps/documentation/javascript/examples/save-simple
	https://developers.google.com/maps/documentation/javascript/examples/marker-remove
*/
;
jQuery.widget("ui.mapEditor",{
	map:undefined,
	ComponentsIncluded: ['lamp'],
	componentInfoPanel:undefined,
	componentToolPanel:undefined,
	current_selected_client:undefined,
	options:{},
	current_selected_network_id: 1,
	current_selected_network_name: "Networks 086",
	editors : [],
	networks:undefined,

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
		self.mapeditor_container = $('<div id="xmapeditor-container">').appendTo(self.element);
		
		self.componentToolPanel = $('<div class="mapeditor-component-tool-panel">').appendTo(self.mapeditor_container);
		self.componentInfoPanel = $('<div id="component-info-panel">').appendTo(self.mapeditor_container);

		self.componentInfoPanel.draggable({
			containment: self.element
		});

		$.each(self.ComponentsIncluded, function(index, component) {
			var temp = new window[component+'_Component']();
			temp.init(self);
			tool_btn = temp.renderTool(temp);
			self.editors[component] = temp.editor;
		});

		//create Map using gmap3
		self.map = $('<div class="atk-box" id="map">');
		$(self.mapeditor_container).append(self.map);
		$(self.map).gmap3();
		
	},

	//Load Saved Networks
	loadSavedNetworks:function(){
		self = this;
		self.options.networks  = JSON.parse(self.options.networks);
		$.each(self.options.networks,function(network_id,network){
			//GMap Function define in mapeditor.html
			drawLine(self.getLine(network_id));
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
	}

});
