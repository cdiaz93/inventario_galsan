<template>

        <div class="row">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-body custom-scroll" ref="tableContainer">

                        <div class="col-md-12">
                            <span class="text-h5"> Bienvenido: {{  this.login_usuario }} </span>
                            <v-spacer></v-spacer>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn @click="formularioCambiarContrasenia()" class="mr-2" color="secondary" elevation="2" dark v-bind="attrs" v-on="on" icon> <v-icon color="blue-grey lighten-3">  mdi mdi-lock-reset</v-icon>  </v-btn>
                                </template>
                                <span> Cambiar contraseña </span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn @click="logout()" class="mr-2" color="secondary" elevation="2" dark v-bind="attrs" v-on="on" icon> <v-icon color="red">  mdi mdi-logout-variant </v-icon>  </v-btn>
                                </template>
                                <span>Cerrar Sesión </span>
                            </v-tooltip>
                        </div>


                        <v-toolbar flat>
                            <v-toolbar-title> Inventario de Galsan repuestos </v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-spacer></v-spacer>

                            <!-- Modal cargar excel  -->
                            <v-dialog v-model="modalImport" persistent max-width="50vw">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="black" dark v-bind="attrs" v-on="on" > Importar Inventario </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title> <span class="text-h5"> Importar Inventario </span> </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <label for="exampleFormControlFile1"> Seleccione el archivo Excel que va a cargar </label>
                                                    <v-file-input  id="excel_inventory" v-model="files" color="primary" counter label="Archivo" placeholder="Cargar archivo"
                                                        prepend-icon="mdi mdi-paperclip-plus" outlined :show-size="1000"
                                                    >
                                                        <template v-slot:selection="{ index, text }">
                                                            <v-chip v-if="index < 2" color="primary" dark label small> {{ text }} </v-chip>
                                                        </template>
                                                    </v-file-input>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-btn tile color="success" block @click="cargarExcel">
                                                        <v-icon left> mdi mdi-upload-box-outline</v-icon> Cargar
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn tile color="red lighten-2" dark class="ma-2 text-white"  @click="modalImport = false">
                                            <v-icon left> mdi mdi-close </v-icon> Cancelar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>

                            <!-- Modal para formulario registrar/editar articulo  -->
                            <v-dialog v-model="modalNew" max-width="80vw" persistent>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="primary"  class="mb-2 ma-2" v-bind="attrs" v-on="on" @click="formularioGuardarItem"> Nuevo Articulo  </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="text-h5">{{ tituloFormulario }}</span>
                                        <v-spacer></v-spacer>
                                        <div v-if="btnGuardar">
                                            <v-btn tile color="red lighten-2" class="ma-2 text-white"  @click="closeModalNew">
                                                <v-icon left> mdi mdi-close </v-icon> Cancelar
                                            </v-btn>
                                            <v-btn tile color="success" class="ma-2" @click="guardarArticulo">
                                                <v-icon left> mdi mdi-content-save-outline </v-icon> Guardar
                                            </v-btn>
                                        </div>
                                        <div v-else>
                                            <v-btn tile color="red lighten-2" class="ma-2 text-white"  @click="closeModalEdit">
                                                <v-icon left> mdi mdi-close </v-icon> Cancelar
                                            </v-btn>
                                            <v-btn tile color="primary" class="ma-2" @click="editarArticulo">
                                                <v-icon left> mdi mdi-content-save-outline </v-icon> Actualizar
                                            </v-btn>
                                        </div>


                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.id" label="ID"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.codigo_interno" label="Codigo Interno"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="8"></v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-text-field v-model="articulo.descripcion" label="Descripción articulo"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.unidad_medida" label="Unidad medida"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.ubicacion_bodega" label="Ubicación bodega"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.existencias" label="Existencias"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.serial" label="Serial"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.segemento" label="Segemento"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.lineas" label="Linea"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6"></v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.referencia_fabrica" label="Referencia fabrica"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.referencia_articulo" label="Referencia articulo" ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.marca" label="Marca"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.tipo_marca" label="Tipo marca"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4"></v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <!-- <v-text-field v-model="articulo.costo" label="Costo" prefix="$" type="number" step="0.01"></v-text-field> -->
                                                    <vuetify-money v-model="articulo.costo" label="Costo" v-bind:options="money_options"/>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <!-- <v-text-field v-model="articulo.precio_venta" label="Precio venta"></v-text-field> -->
                                                    <vuetify-money v-model="articulo.precio_venta" label="Precio venta" v-bind:options="money_options"/>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.contador" label="Contador"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="articulo.usuario" :label="accionUsuario" disabled readonly></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                </v-card>
                            </v-dialog>

                            <!-- Modal para cambiar contraseña -->
                            <v-dialog v-model="modalNewPssword" max-width="50vw" persistent>
                                <v-card>
                                    <v-card-title>
                                        <span class="text-h5"> Cambiar Contraseña </span>
                                        <v-spacer></v-spacer>
                                        <v-btn tile color="red lighten-2" class="ma-2 text-white"  @click="closeModalCambiarContrasenia()">
                                            <v-icon left> mdi mdi-close </v-icon> Cancelar
                                        </v-btn>
                                        <v-btn tile color="primary" class="ma-2" @click="cambiarContrasenia()">
                                            <v-icon left> mdi mdi-content-save-outline </v-icon> Actualizar
                                        </v-btn>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="6" sm="6" md="6">
                                                    <v-text-field v-model="contrasenia.nueva" label="Nueva contraseña" autocomplete="new-password"
                                                        :append-icon="mostrarContrasenia ? 'mdi-eye' : 'mdi-eye-off'"
                                                        :type="mostrarContrasenia ? 'text' : 'password'"
                                                        @click:append="mostrarContrasenia = !mostrarContrasenia"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="6" sm="6" md="6"></v-col>
                                                <v-col cols="6" sm="6" md="6">
                                                    <v-text-field v-model="contrasenia.confirmar" label="Repita nueva contraseña" autocomplete="new-password"
                                                        :append-icon="mostrarRepetirContrasenia ? 'mdi-eye' : 'mdi-eye-off'"
                                                        :type="mostrarRepetirContrasenia ? 'text' : 'password'"
                                                        @click:append="mostrarRepetirContrasenia = !mostrarRepetirContrasenia"
                                                        :error-messages="errorConfirmacion"
                                                        @input="validarContrasenias"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                </v-card>
                            </v-dialog>


                            <!-- Boton para buscar datos en la DataTables  -->
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" append-icon="mdi mdi-magnify" label="Buscar..." single-line hide-details></v-text-field>
                        </v-toolbar>

                        <!-- Modal Confirmacion de eliminacion  -->
                        <v-dialog v-model="dialogDelete" max-width="45vw">
                            <v-card>
                                <v-card-title class="text-h5  d-flex align-center justify-content-center">
                                    <v-icon left color="red" size="70" class="my-3"> mdi mdi-alert-circle-outline </v-icon>
                                    Esta seguro?.  Esta acción no se puede revertir. </v-card-title>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete"> Cancelar </v-btn>
                                <v-btn color="blue darken-1" text @click="eliminarArticulo"> Eliminar </v-btn>
                                <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>




                        <!-- TABLA  -->
                        <!-- style="height:70vh;" -->
                        <v-data-table
                            dense
                            :headers="headers" :items="inventarios" :search="search"
                            fixed-header  height="500"
                            :page.sync="page"
                            :items-per-page="itemsPerPage"
                            @page-count="pageCount = $event"
                            sort-by="id" class="elevation-1"
                            hide-default-footer
                        >
                            <!-- Botones de acciones (Editar / Eliminar) -->
                            <template v-slot:item.actions="{ item }">
                                <v-icon color="blue lighten-2"  class="mr-2" @click="formularioEditarItem(item)"> mdi mdi-file-edit-outline </v-icon>
                                <v-icon color="red darken-4"  @click="confirmarEliminarItem(item)"> mdi mdi-delete-forever-outline </v-icon>
                            </template>

                            <!-- <template v-slot:no-data>
                            <v-btn color="primary" @click="initialize"> Reset </v-btn>
                            </template> -->
                        </v-data-table>

                        <!-- Paginador de la tabla  -->
                        <div class="text-center pt-2">
                            <v-pagination v-model="page" :length="pageCount"></v-pagination>
                            <!-- <v-text-field :value="itemsPerPage" label="Items per page" type="number" min="-1" max="15" @input="itemsPerPage = parseInt($event, 10)"></v-text-field> -->
                        </div>
                    </div>
                </div>



                <!-- Snackbar - alertas de acciones  -->
                <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
                    {{ snackbar.message }}
                    <template v-slot:action="{ attrs }">
                        <v-btn color="black" text v-bind="attrs" @click="snackbar.show = false">
                            <v-icon color="red"> bi bi-x-lg </v-icon>
                        </v-btn>
                    </template>
                </v-snackbar>


            </div>
        </div>

</template>

<script>

    //Fonat awesome 5 Icons
    import '@fortawesome/fontawesome-free/css/all.css';

    //Bootstrap FileInput Krajee
    import 'bootstrap-fileinput/css/fileinput.min.css';
    import 'bootstrap-fileinput/js/fileinput.min.js';
    // import '../../../public/js/es.js';

    // import 'bootstrap';
    // import 'bootstrap/dist/css/bootstrap.min.css';


    //Boostrap Icons (FileInput Krajee por Defecto los usa)
    import 'bootstrap-icons/font/bootstrap-icons.css';


    // Se obtiene el usuario laravel desde etiqueta meta del <head>
    let usuario_actual = document.head.querySelector('meta[name="usuario-actual"]');

    export default {
        // props: ['inventarios'],

        components: {
            // UploadExcel,
        },


        data() {
            return {
                files: null,
                search:'',
                showScrollRightButton: false,
                showScrollLeftButton: false,
                mostarNuevoDato: false,
                inventarios: [], // Arreglo para almacenar los datos del inventario en la DB
                editing: false ,
                showModal: true,

                login_usuario:JSON.parse(usuario_actual.content).name,
                articulo: {
                    id: '',
                    codigo_interno: '',
                    referencia_fabrica: '',
                    referencia_articulo: '',
                    serial: '',
                    segemento: '',
                    lineas: '',
                    marca: '',
                    tipo_marca: '',
                    descripcion: '',
                    existencias: '',
                    ubicacion_bodega: '',
                    unidad_medida: '',
                    costo: '',
                    precio_venta: '',
                    usuario: JSON.parse(usuario_actual.content).name,
                    contador: '',
                },

                contrasenia:{
                    nueva: null,
                    confirmar:null,
                },
                mostrarContrasenia: false,
                mostrarRepetirContrasenia:false,
                errorConfirmacion: '',

                defaultArticulo: {
                    id: '',
                    codigo_interno: '',
                    referencia_fabrica: '',
                    referencia_articulo: '',
                    serial: '',
                    segemento: '',
                    lineas: '',
                    marca: '',
                    tipo_marca: '',
                    descripcion: '',
                    existencias: '',
                    ubicacion_bodega: '',
                    unidad_medida: '',
                    costo: '',
                    precio_venta: '',
                    usuario: JSON.parse(usuario_actual.content).name,
                    contador: '',
                },

                money_options: {
                    locale: "es-CO",
                    prefix: "$",
                    suffix: "",
                    length: 11,   //Longitud maxima
                    precision: 0 //Decimales
                },


                editedIndex: -1,

                // -------------------------------------------------------
                // Variables para DataTables de Vuetify
                modalNew: false,

                modalNewPssword:false,
                modalImport: false,
                dialogDelete: false,

                btnEditar:false,
                btnGuardar:false,

                // opciones de configuracion de snackbar
                snackbar: {
                    show: false,
                    message: '',
                    timeout: 6000, // tiempo en milisegundos
                    color: 'black'
                },

                // Encabezados de la tabla
                headers: [
                    { text: 'Acciones', value: 'actions', sortable: false },
                    {
                        text: 'ID',
                        align: 'start',
                        sortable: true,
                        value: 'id',
                    },
                    { text: 'Codigo interno', value: 'codigo_interno' },
                    { text: 'Referencia Fabrica', value: 'referencia_fabrica' },
                    { text: 'Referencia Articulo', value: 'referencia_articulo' },
                    { text: 'Numero Serial', value: 'serial' },

                    { text: 'Segemento', value: 'segmento' },
                    { text: 'Lineas', value: 'lineas' },
                    { text: 'Marca', value: 'marca' },
                    { text: 'Tipo marca', value: 'tipo_marca' },
                    { text: 'Descripcion', value: 'descripcion' },
                    { text: 'Existencias', value: 'existencias' },
                    { text: 'Ubicación en bodega', value: 'ubicacion_bodega' },
                    { text: ' Unidad de medida ', value: 'unidad_medida' },
                    { text: 'Costo', value: 'costo' },
                    { text: 'Precio de venta', value: 'precio_venta' },
                    { text: 'Usuario', value: 'usuario' },
                    { text: 'Contador', value: 'contador' },

                ],
                // -------------------------------------------------------
                page: 1,
                pageCount: 0,
                itemsPerPage: 100,

            };
        },



        // (created) => Al iniciar el componente haga esto...
        created() {
            this.consultarInventario();
        },

        computed: {
            tituloFormulario () {
                return this.editedIndex === -1 ? 'Nuevo Articulo' : 'Editar Articulo'
            },

            accionUsuario (){
                return this.editedIndex === -1 ? 'Creado por' : 'Editado por'
            },

            usuario_actual(){
                return JSON.parse(usuario_actual.content)
            },


        },
        watch: {
            modalNew (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
        },

        methods: {






            //Cerrar modal de confirmacion de eliminacion
            closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                this.articulo = Object.assign({}, this.defaultArticulo)
                this.editedIndex = -1
                })
            },


            //Consulta todos los datos de inventario y los asigna a la variable this.inventario
            consultarInventario() {
                axios.get('/inventory')
                    .then(response => {
                    this.inventarios = response.data;

                }).catch(error => {
                    console.error('Error al obtener datos:', error);
                });
            },

            // Envia por POST el archivo excel para guardar la info del inventario
            cargarExcel() {
                let formData = new FormData();
                formData.append('excel_inventory', this.files);

                axios.post('inventory/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    setTimeout(() => {
                        // this.closeModal();
                        this.modalImport = false
                        alert(response.data.message);
                        console.log(response.data);
                        this.consultarInventario();
                    }, 100);
                })
                .catch(error => {
                    alert('Hubo un error en la carga del archivo. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });
            },


            //Mostrar modal para registar articulo
            formularioGuardarItem(){
                this.btnGuardar = true
                this.btnEditar = false
            },

            formularioCambiarContrasenia(){
                this.modalNewPssword = true
            },

            closeModalCambiarContrasenia(){
                this.modalNewPssword = false
                this.contrasenia.nueva = null;
                this.contrasenia.confirmar = null;
            },
            validarContrasenias() {
                if (this.contrasenia.nueva !== this.contrasenia.confirmar) {
                    this.errorConfirmacion = 'Las contraseñas no coinciden';
                }else{
                    this.errorConfirmacion = '';
                }
            },

            cambiarContrasenia(){
                if (this.contrasenia.nueva !== this.contrasenia.confirmar) {
                    this.snackbar.message = 'Las contraseñas no coinciden';
                    this.snackbar.show = true;
                }else{
                    const contrasenia = this.contrasenia.confirmar
                    axios.post(`/change-password`, {contrasenia_nueva: contrasenia}).then(response => {
                        this.closeModalCambiarContrasenia();
                        this.snackbar.message = response.data.message;
                        this.snackbar.show = true;

                    }).catch(error => {
                        alert('Hubo un error al guardar la información. Consulte la consola para mas detalles.');
                        console.error(' ---------------- ALERTA ERROR ----------------');
                        console.error(error);
                        console.error(' ----------------------------------------------');
                    });
                }
            },

            //Guarda en la DB la informacion
            guardarArticulo() {
                const inventario = { ...this.articulo };
                axios.post('inventory', inventario).then(response => {
                    this.close()
                    this.snackbar.message = response.data.message;
                    this.snackbar.show = true;

                    // Se asignan los nuevos datos al registro actual
                    if(this.editedIndex > -1) {
                        Object.assign(this.inventarios[this.editedIndex], this.articulo)
                    }else{
                        this.inventarios.push(this.articulo)
                    }

                }).catch(error => {
                    alert('Hubo un error al guardar la información. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });
            },

            closeModalNew(){
                this.modalNew = false
                this.$nextTick(() => {
                    this.articulo = Object.assign({}, this.defaultArticulo)
                    this.editedIndex = -1
                })
            },

            //Cerrar modal de formulario para guardar/editar
            closeModalEdit() {
                const id= this.articulo.id;
                axios.delete(`inventory/delete-assignment/${id}`).then(response => {
                    if(response.data.status === 'success'){
                        this.modalNew= false
                        this.$nextTick(() => {
                            this.articulo = Object.assign({}, this.defaultArticulo)
                            this.editedIndex = -1
                        })
                        this.snackbar.message = response.data.message;
                        this.snackbar.show = true;
                    }

                }).catch(error => {
                    alert('Hubo un error al guardar la información. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });
            },

            //Mostrar modal para editar articulo
            formularioEditarItem (item) {
                const id= item.id;
                axios.get(`inventory/${id}/edit`).then(response => {
                    if(response.data.status === 'success'){
                        this.btnGuardar = false
                        this.btnEditar = true
                        this.editedIndex = this.inventarios.indexOf(item)
                        this.articulo = Object.assign({}, item)
                        this.modalNew = true
                    }
                    else if (response.data.status === 'error') {
                        this.snackbar.message = response.data.message;
                        this.snackbar.show = true;
                    }

                }).catch(error => {
                    alert('Hubo un error al guardar la información. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });

            },


            //Actualiza en la DB la informacion del item seleccionado.
            editarArticulo() {
                const id= this.articulo.id;
                const inventario = { ...this.articulo };
                axios.put(`inventory/${id}`, inventario).then(response => {
                    this.close()
                    this.snackbar.message = response.data.message;
                    this.snackbar.show = true;

                    // Se asignan los nuevos datos al registro actual
                    if(this.editedIndex > -1) {
                        Object.assign(this.inventarios[this.editedIndex], this.articulo)
                    }else{
                        this.inventarios.push(this.articulo)
                    }

                }).catch(error => {
                    alert('Hubo un error al guardar la información. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });
            },


            // Mostrar modal de confirmacion de eliminacion
            confirmarEliminarItem (item) {
                this.editedIndex = this.inventarios.indexOf(item)
                this.articulo = Object.assign({}, item)
                this.dialogDelete = true
            },

            // Elimina de la DB el articulo seleccionado
            eliminarArticulo() {
                const id= this.articulo.id;

                axios.delete(`inventory/${id}`).then(response => {
                    this.closeDelete()
                    this.snackbar.message = response.data.message;
                    this.snackbar.show = true;

                    this.inventarios.splice(this.editedIndex, 1)


                }).catch(error => {
                    alert('Hubo un error al guardar la información. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });


            },

            // Cerrar sesión
            async logout(){
                try {
                    // Obtener el token CSRF del elemento meta del head de la página
                    const token = document.head.querySelector('meta[name="csrf-token"]').content;
                    const headers = {
                        'X-CSRF-TOKEN': token
                    };

                    await axios.post('/logout', null, { headers });
                    window.location.href = '/login';

                } catch (error) {
                    console.error('Error al cerrar sesión:', error);
                }
            }

    },

    mounted() {
        this.$refs.tableContainer.addEventListener('scroll', this.handleScroll);

        //Inicializa Fileinput con las opciones personalizadas
        $(this.$refs.inputFile).fileinput({
            language: 'es', // idioma a español
        });
    },

    beforeDestroy() {
        this.$refs.tableContainer.removeEventListener('scroll', this.handleScroll);
    }

    }
  </script>

<style>

    /* Contenedor modificado de Vuetify. por defecto 100vh */
    .v-application--wrap {
        min-height: unset !important;
    }

    .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 60vh; /* gives an initial height of 200px to the table */
    }


    .input-ro{
        border: 1px solid transparent !important;
        background-color: transparent !important;
        /* border-width: 2px !important; */
    }

    .table-container {
        position: relative;
        overflow-x: auto;
    }

    .scroll-button {
        position: absolute;
        z-index: 1;
        cursor: pointer;
        border: none;
        background-color: transparent;
        color: #000;
        font-size: 24px;
    }

    .bottom-right {
        position: absolute;
        top: 60%;
        right: 0;
    }

    .bottom-left {
        position: absolute;
        top: 60%;
        left: 0;
    }

    .table-fixed thead {
      position: sticky;
      top: 0;
      z-index: 999;
      background-color: #fff;
      font-size: '12px';
    }

    .card-body.custom-scroll {
      overflow-x: auto;
      white-space: nowrap;
      scroll-snap-type: x mandatory;
    }

    .sticky-column {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: #ffffff;
    }

</style>
