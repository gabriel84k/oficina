<template>

    <nav  class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown row " style="align-items:center; bacground-color:transparet">
                    <div >
                        <menuUsuario></menuUsuario>
                    </div>
                    <div>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{usuario.email}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <itemMenuUser :user="usuario" ></itemMenuUser>
                            <hr>
                           
                            <a class="dropdown-item" href="#" @click="logout()"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    Cerrar sesion
                            </a>
                            
                        </div>
                            
                    </div>
                    
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
import menuUsuario from './menu'
import itemMenuUser from './ItemsMenu'

export default {
    props:['user'],
    data() {
        return {
            
        }
    },
    components:{
        menuUsuario,
        itemMenuUser,

    },
   computed:{
       usuario(){
            return this.user
       }
   },
    
    methods: {
        logout() {
            axios.post('/logout').then(response => {
                windows.location("/login")
           
            }).catch(error => {
                location.reload();
            });
        }
    },
}
</script>