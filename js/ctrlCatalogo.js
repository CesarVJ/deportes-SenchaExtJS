Ext.require([
    'Ext.plugin.Viewport'
]);
Ext.onReady(function(){
var nLinActual = -1;

    ajustaMenu();

    Ext.define('Articulo', {
		extend: 'Ext.data.Model',
		fields: [
			{ name: 'claveArticulo', type: 'int' },
			{ name: 'nombreArticulo', type: 'string' },
            { name: 'imagen', type: 'string' },
            { name: 'equipo', type: 'string' },
			{ name: 'precio', type: 'float' },
			{ name: 'caracteristicas', type: 'string' },
		]
    });
    
    Ext.define('Linea', {
		extend: 'Ext.data.Model',
		fields: [
			{ name: 'sCve', type: 'string' }, 
			{ name: 'sNombreLinea', type: 'string' }
		]
    });

    var lineaStore =Ext.create('Ext.data.Store', {
		model: 'Linea',
		data: [
			{ sCve: 'U', sNombreLinea: 'Uniformes' },
            { sCve: 'R', sNombreLinea: 'Ropa niños' },
            { sCve: 'B', sNombreLinea: 'Balones' },
			{ sCve: 'S', sNombreLinea: 'Souvenirs' }
		]
    });
    


    Ext.define('Equipo', {
		extend: 'Ext.data.Model',
		fields: [
			{ name: 'claveEquipo', type: 'string' }, 
			{ name: 'nombreEquipo', type: 'string' }
		]
    });

    var equiposStore =Ext.create('Ext.data.Store', {
		model: 'Equipo',
		autoLoad: true, 
		autoSync: true,
		proxy: {
			type: 'ajax',
			url: 'ctrlPhp/ctrlConsultarEquipos.php',
			reader: {
				type: 'json',
				rootProperty: 'data'
			},
			listeners: {
				exception: function(proxy, response, operation, eOpts) {
					Ext.Msg.alert(
						'Aviso',
						'Error al llamar al servidor'
					);
				}
			}
		}
    });
    
    var articulosStore =Ext.create('Ext.data.Store', {
		storeId: 'ArticulosStore',
		model: 'Articulo',
		autoLoad: false, 
		autoSync: false,
		proxy: {
			type: 'ajax',
			url: 'ctrlPhp/ctrlBuscarTodosLinea.php',
			reader: {
				type: 'json',
				rootProperty: 'data'
			},
			listeners: {
				exception: function(proxy, response, operation, eOpts) {
					Ext.Msg.alert(
						'Aviso',
						'Error al llamar al servidor'
					);
				}
			}
		}
    });
    

    Ext.create('Ext.form.Panel', {
		title: 'Catalogo de productos',
		renderTo: Ext.get('sct1'),
		bodyPadding: 5,
		width: '80%',
        itemId: 'formArticulos',
        scrollable: true,
        layout: {
            type: 'table',
            columns: '2',
            tableAttrs: { style: { 'margin-right': 'auto', 'margin-left': 'auto', 'margin-top':'10px' } }
        },
		items: [
            {
				xtype: 'combobox',
				fieldLabel: 'Filtrar por Equipo',
				displayField: 'nombreEquipo',
				valueField: 'claveEquipo',
				name: 'cmbEquipo',
                id: 'cmbEquipo',
                margin: '15rem',
				store: equiposStore,
				listeners: {
					select: function(combo, record, eOpts){
						articulosStore.removeAll();
						articulosStore.getProxy().url=
							"ctrlPhp/ctrlBuscarPorEquipo.php?equipo="+
							this.getValue();
                            articulosStore.load();
					}
				}
			},
			{
				xtype: 'combobox',
				fieldLabel: 'Filtrar por Linea',
				displayField: 'sNombreLinea',
				valueField: 'sCve',
				name: 'cmblinea',
                id: 'cmbLinea',
                margin: '15rem',
				store: lineaStore,
				listeners: {
					select: function(combo, record, eOpts){
						articulosStore.removeAll();
						articulosStore.getProxy().url=
							"ctrlPhp/ctrlBuscarTodosLinea.php?linea="+
							this.getValue();
						articulosStore.load();
					}
				}
			},
			{
				xtype: 'grid',
				store: articulosStore,
				autoscroll: true,
				id: 'tablaArt',
				width: '100%',
                height: 'auto',
                colspan: 2,
                scrollable: true,
				columns: [
                    {
						text: 'Nombre',
						width: '25%',
						dataIndex: 'nombreArticulo'
					},
					{ 	
						text: 'Imagen', 
						width:'15%',
						dataIndex: 'imagen',
						sortable: false, 
						hideable: false,
						renderer: function(value) {
							return '<img src="media/' + value +'" class="imagen-articulo">';
						}
					},
					{
						text: 'Equipo',
						width: '20%',
						dataIndex: 'equipo'
					},
					{
						text: 'Precio',
						width: '10%',
						dataIndex: 'precio'
					},
					{
						text: 'Caracteristicas',
						width: '30%',
						dataIndex: 'caracteristicas'
					}
				]
			}
		]
	});





});