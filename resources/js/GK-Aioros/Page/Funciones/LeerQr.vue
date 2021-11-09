<template>
    <div>
        
        <qrcode-stream @decode="onDecode"></qrcode-stream>
    </div>
</template>
<script>
import { QrcodeStream} from 'vue-qrcode-reader'
export default {
    data() {
        return {
            
        }
    },
    components:{
        QrcodeStream
    },
    methods: {
        onDecode (decodedString) {
            console.log("QR",decodedString);
        },
    },
}
</script>