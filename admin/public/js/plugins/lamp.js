lamp_Editor = function(){
	var self = this;
	// this.parent = parent;
	this.current_lamp_component = undefined;

	this.parent = component_info_panel = $('#component-info-panel');
	this.element = $('<div id="lamp-editor" class="atk-box atk-swatch-red"></div>').appendTo(this.parent);
	this.lat = $('<label>Latitude</label><input>').appendTo(this.element);
	this.lng = $('<label>Longitude</label><input>').appendTo(this.element);
	this.element.hide();
}

lamp_Component = function(param){
	this.editor=undefined,
	this.mapeditor=undefined,

	this.options = {},

	this.init = function(mapeditor,editor){
		self = this;
		self.mapeditor = mapeditor;
		if(editor !== undefined)
			this.editor = editor;

		this.editor = new lamp_Editor();
	},


	this.addLamp = function(){
		self = this;
		self.add_new_form = $('<div id="dialog-form" title="Add New Component"><form><fieldset><label for="latitude">Latitude</label><br/><input type="text" name="latitude" id="latitude" value="" class="text ui-widget-content ui-corner-all"><br/><label for="longitude">Longitude</label><br/><input type="text" name="longitude" id="longitude" value="" class="text ui-widget-content ui-corner-all"><input type="submit" tabindex="-1" style="position:absolute; top:-1000px"></fieldset></form></div>');
		dialog = $( this.add_new_form ).dialog({
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				Add: function() {
					form_lat = parseFloat($("#latitude").val());
					form_lng = parseFloat($("#longitude").val());
					addMarker(form_lat, form_lng,'lamp');
					self.add_new_form.empty();
					$( this ).dialog( "close" );
				}
			},
			close: function() {

			}
		});
		//Calling Google Map Function
       	// addMarker(30.29701,76,"New Lamp Added");
	},

	//Set Options from the mapeditor options depending on network_id and device_id pass by the marker when click on it
	this.setOptions = function(network_id,device_id,sequence){
		self = this;
		device_network = self.mapeditor.options.networks[network_id];
		if(device_network == undefined){
			alert('networks not found, something happen wrong');
			return;
		}
		self.options = device_network['lamps'][device_id];
	},

	this.showInfo = function(device_info){
		self = this;
		this.parent = component_info_panel = $('#component-info-panel');
		this.parent.empty();
		// self.element = $('<div id="lamp-editor"></div>').appendTo(this.parent);
		// $( self.element ).load( "layout/lampinfo.html" );
		// $(device_info_html).appendTo(self.element);
		$.get('layout/lampinfo.html',function(data){
			self.element = $('<div id="lamp-editor"></div>').appendTo(self.parent);
			data = data.replace("{type}", device_info.device_type);
			data = data.replace("{latitude}", device_info.position.lat());
			data = data.replace("{longitude}", device_info.position.lng());

			replace_variable = ['address','model','brightness_level','surge_protector_condition','power','voltage','current','consumption','pf','t_led','t_lc','clo','actual_working_time','group','lc_model','lc_firmware','terminal_address','global_address'];
			
			if(self.options){
				$(replace_variable).each(function(index,str){
					data = data.replace("{"+str+"}", eval('self.options.'+str));
				});

				selector_id = device_info.device_id+"rk"+device_info.network_id;
				//For Working status id
				data = data.replace('{working_status_id}', selector_id);
				data = data.replace('{working_status_id_label}', selector_id);
				//Brightness Level
				data = data.replace('{{brightness_level_value}}', self.options.brightness_level);
			}else{
				$(replace_variable).each(function(index,str){
					data = data.replace("{"+str+"}", 'undefined');
				});
				selector_id = 'xyz9090-rakesh-dummy';
			}
			$(data).appendTo(self.element);

			//Lamp Brightness Range Slider 
	        $(self.element).find('.mapeditor-device-info-brightness').slider({
	        	range: "max",
				min: 0,
				max: 100,
				value:self.options.brightness_level,
				slide: function( event, ui ) {
					$(self.element).find( ".mapeditor-device-brightness-value" ).text( ui.value+' %' );
				},
				stop: function(event,ui){

					$.ajax({
							url: "?page=updatelampinfo",
							type: 'POST',
							data:{
								brightness_level: ui.value,
								lamp_id:device_info.device_id,
								network_id:device_info.network_id
							}
					})
					.done(function(ret) {
						if(ret == "updated")
							$.univ().successMessage('Lamp Brightness Updated Successfully');
					});		
				}
	        });

	        //Actual Working Time Hour
	        $(".mapeditor-device-info-working-time").sparkline([3,4], {
				    type: 'pie',
				    sliceColors: ['#009866','#CBC7C7'],
				    borderWidth: 1,
				    borderColor: '#f3f3f3'
			});

		});

		selected_id = '#'+device_info.device_id+"rk"+device_info.network_id;

		//Working Status 
		$(this.parent).on('change',selected_id, function(){
			status = $(selected_id).is(':checked');
			$.ajax({
					url: "?page=updatelampinfo",
					type: 'POST',
					data:{
						working_status: status,
						lamp_id:device_info.device_id,
						network_id:device_info.network_id
					}
			})
			.done(function(ret) {
				if(ret == "updated")
					$.univ().successMessage('working status Updated Successfully');
			});

		});

	},


	this.renderTool = function(parent){
		self = this;
		// panel = $('#map-editor-tool-panel');
		self.parent = parent;
		add_lamp_btn = $('<input type="button" value="Add Lamp">').appendTo(parent).addClass('atk-button-small');
		add_lamp_btn.on('click',function(){
			self.addLamp();
		});
	}
	

}