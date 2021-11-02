<template>
    <div>
        <!-- Sectores -->
        <v-row>
           
            <v-col cols="4" v-for="(index,item) in sector" :key="index">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-title>{{item.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.detalle}}</v-list-item-subtitle>
                        </v-list-item-content>
                        
                    </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
           
            <v-col cols="4">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-row >
                        <v-col cols="12" align="center">
                            <v-btn
                                color="primary"
                                elevation="2"
                                icon
                                @click="nuevoSector()"
                            >
                            <v-icon dark>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                        </v-col>
                    </v-row>

                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img src=""></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Nuevo Sector</v-list-item-title>
                                <v-list-item-subtitle>Crer un Nuevo Sector</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        <!-- Puestos -->
        <v-row>
           
            <v-col cols="4" v-for="(index,item) in puesto" :key="index">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-title>{{item.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.detalle}}</v-list-item-subtitle>
                        </v-list-item-content>
                        
                    </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
           
            <v-col cols="4">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-row >
                        <v-col cols="12" align="center">
                            <v-btn
                                color="primary"
                                elevation="2"
                                icon
                                @click="nuevoPuesto()"
                            >
                            <v-icon dark>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                        </v-col>
                    </v-row>

                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img src=""></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Nuevo Puesto</v-list-item-title>
                                <v-list-item-subtitle>Crer un nuevo Puesto</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
        <!-- Puestos -->
        <v-row>
           
            <v-col cols="4" v-for="(index,item) in puesto" :key="index">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-title>{{item.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.detalle}}</v-list-item-subtitle>
                        </v-list-item-content>
                        
                    </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
           
            <v-col cols="4">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-row >
                        <v-col cols="12" align="center">
                            <v-btn
                                color="primary"
                                elevation="2"
                                icon
                                @click="nuevoPuesto()"
                            >
                            <v-icon dark>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                        </v-col>
                    </v-row>

                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img src=""></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Nuevo Puesto</v-list-item-title>
                                <v-list-item-subtitle>Crer un nuevo Puesto</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        
    </div>
</template>
<script>
export default {
    props:[],
    data() {
        return {
            cyrcle:true,
            red:[]
        }
    },
    mounted() {
        
    },
    methods: {
        nevaRed(){
            
        }
    },
}
</script>