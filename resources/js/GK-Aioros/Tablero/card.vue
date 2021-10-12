<template>
    <div class="card">
        <div class="card-block">
            <h6 class="mb-4">{{dato.titulo}}</h6>
            <div class="row d-flex align-items-center">
                <div class="col-9">
                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                        <i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>
                        {{dato.cantidad}}
                    </h3>
                </div>

                <div v-if="dato.porc.value" class="col-3 text-right">
                    <p class="m-b-0">{{dato.porc.value}}%</p>
                </div>
            </div>
            <div class="progress m-t-30" style="height: 7px;">
                <div class="progress-bar progress-c-theme" role="progressbar" :style="'width: ' + dato.porc.value +'%;'" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['dato'],
    data() {
        return {
           
        }
    },
}
</script>