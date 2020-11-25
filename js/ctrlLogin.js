Ext.require([
    'Ext.plugin.Viewport'
]);
Ext.onReady(function () {
    sessionStorage.setItem('nombre', '');
    sessionStorage.setItem('tipo', '');
    ajustaMenu();

    Ext.create('Ext.form.Panel', {
        title: 'Ingresar al Sistema',
        bodyPadding: 10,
        width: '50%',
        height: '12rem',
        shadow: true,
        shadowOffset:20,
        url: "ctrlPhp/ctrlLogin.php",
        standardSubmit: false,
        defaultType: 'textfield',
        plugins: 'responsive',

        responsiveConfig: {
            'width < 800': {
                width: '80%'
            },

            'width >= 800': {
                width: '40%'
            }
        },
        items: [{
                fieldLabel: 'Clave de usuario',
                pattern: '\d+',
                name: 'claveUsr',
                allowBlank: false
            },
            {
                fieldLabel: 'Contrase&ntilde;a',
                name: 'txtPwd',
                inputType: 'password',
                allowBlank: false
            }
        ],
        buttons: [{
            text: 'Enviar',
            handler: function () {
                var frm = this.up('form').getForm();
                if (frm.isValid()) {
                    frm.submit({
                        success: function (form, action) {
                            sessionStorage.setItem('nombre',
                                action.result.data.nombre);
                            sessionStorage.setItem('tipo',
                                action.result.data.tipo);
                            Ext.get("sct1").setHtml(
                                '<header style="width:60%">' +
                                '	<h3>Bienvenido</h3>' +
                                '</header>' +
                                '<section>' +
                                '	<h4>Bienvenido a nuestra tienda de deportes ' + action.result.data.nombre + '</h4>' +
                                '	<h5>Ingresaste como ' + action.result.data.tipo +
                                '</h5>' +
                                '</section>');
                            Ext.get("mnuLogin").set({
                                href: "bienvenido.php"
                            });
                            Ext.get("mnuSalir").set({
                                cls: "menu"
                            });
                            Ext.get("mnuRegistro").set({
                                cls: "menu_inhab"
                            });
                            Ext.get("mnuLogin").set({
                                cls: "menu_inhab"
                            });
                            if (action.result.data.tipo === "Administrador") {
                                Ext.get("mnuPanelAdmin").set({
                                    cls: "menu"
                                });
                            }
                        },
                        failure: function (form, action) {
                            Ext.Msg.alert('Error',
                                action.result ? action.result.status : 'Sin respuesta');
                        }
                    });
                }
            }
        }],
        renderTo: Ext.get('sct1')
    });
});