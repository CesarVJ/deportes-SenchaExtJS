
Ext.require([
    'Ext.plugin.Viewport'
]);
var cabecera = '<header style="display:flex;">'+
					'<figure style="display: inline-block;">'+
					'	<img src="media/logo-futbol.png" alt="logo" class="vueltas" style="height: 100px;">'+
					'</figure>'+
					'<h2 id="titPral">Productos y Articulos deportivos</h2>'+
				'</header>';
var navega = '<nav>'+
				'<a href="catalogo.php" class="menu" id="mnuCatalogo">Catalogo</a>'+
				'<a href="registro.php" class="menu" id="mnuRegistro">Registrarse</a>'+
				'<a href="index.php" class="menu" id="mnuLogin">Iniciar Sesi&oacute;n</a>'+
				'<a href="#" class="menu_inhab" id="mnuPanelAdmin">Panel Administraci&oacute;n</a>' +
				'<a href="ctrlPhp/ctrlLogout.php" class="menu_inhab" id="mnuSalir">Cerrar Sesi&oacute;n</a>'+
				'</nav>';
var centro='<main style="overflow-y:auto;">'+
					'<section id="sct1" style="display:flex; align-items:center; justify-content:center; flex-direction:column; overflow-y:auto;">'+
					'</section>'+
				'</main>';
var pie = '<footer>'+
					'<address>'+
					'<p>Equipo 4 - Tienda deportiva </p>'+
					'<p>AVISO LEGAL: Términos de Uso y Política de privacidad.</p>'+
					'</address>'+
				'</footer>';

Ext.application({
    name: 'Deportes',
    launch : function() {
		Ext.create('Ext.container.Viewport', {
			padding: 0,
			layout: 'border',
			defaults: {
				xtype: 'container', 
				border: false
			},
			items: [
				{
					html: cabecera,
					cls: 'header_main',
					region: 'north',
					responsiveConfig:{
						wide: {
							height: '6em'
						},
						tall:{
							height: 'auto'
						}
					}
				},
				{
					html: navega,
					xtype: 'panel',
					cls: 'nav',
					region: 'west',
					title: 'MENU DE OPCIONES',
					collapsible: true,
					width: '20%',
					padding: 0,
					responsiveConfig:{
						wide: {
							minHeight: '30em'
						},
						tall:{
							minHeight: '5em'
						}
					}
				},
				{
					html: centro,
					cls: 'main',
					region: 'center'
				},
				{
					html: pie,
					cls: 'footer',
					region: 'south'
				}
			]
		});
	}
});

//Ajusta los menús de acuerdo a la sesión, la función se llama en cada ctrl de página
function ajustaMenu(){
var sTipoFirmado = sessionStorage.getItem('tipo'),
    inicio = 'bienvenido.php',
	claseCatalogo = 'menu',
	clasePanelAdmin = 'menu',
	claseSalir = 'menu',
	claseRegistro = 'menu_inhab',
	claseLogin = 'menu_inhab';
	
	//Ajustar el menú de acuerdo a sesión
	if (sTipoFirmado === null || sTipoFirmado === ''){
		inicio = 'index.php';
		clasePanelAdmin = 'menu_inhab';
		claseSalir = 'menu_inhab';
		claseRegistro = 'menu';
		claseLogin = 'menu';
	} else {

		//Deshabilitar el menú de clientes si no es Ventas
		if (sTipoFirmado !== 'Administrador'){
			clasePanelAdmin = 'menu_inhab';
		}else{
			claseRegistro = 'menu_inhab';
		}
	}
	
	//Asignar clases y direcciones a los menús
	Ext.get('mnuLogin').set({href:inicio});
	Ext.get('mnuRegistro').set({cls:claseRegistro});
	Ext.get('mnuLogin').set({cls:claseLogin});
	Ext.get('mnuSalir').set({cls:claseSalir});
	Ext.get('mnuCatalogo').set({cls:claseCatalogo});
	Ext.get('mnuPanelAdmin').set({cls:clasePanelAdmin});
}



