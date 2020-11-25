Ext.require([
    'Ext.plugin.Viewport'
]);
Ext.onReady(function(){
	ajustaMenu();
	
	Ext.get("sct1").setHtml(
			'<header style="width:30rem; text-align:center;">'+
			'	<h3 style="width:100%">Bienvenido</h3>'+
			'</header>'+
			'<sections tyle="width:30rem">'+
			'	<h4>Hola '+ sessionStorage.getItem('nombre') +'</h4>'+
			'	<h5>Ingresaste como '+sessionStorage.getItem('tipo') +'</h5>'+
			'</section>');
});
