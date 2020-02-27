<template>
    <alert v-model="showAlert" placement="top-right" duration="3000" type="success" width="400px" dismissable>
        <span class="icon-ok-circled alert-icon-float-left"></span>
        <strong>New Applicant Applied!</strong>
    </alert>
</template>

<script>
    import { alert } from 'vue-strap'
    export default {
        components: {
            alert
        },
        props: ['department_id'],
        data() {
            return {
                showAlert: false,
                application_id: ''
            }
        },
        mounted() {
            let x = document.getElementById("myAudio");
            Echo.channel('cashier-notification')
            .listen('CashierNotice', (application) => {
                if (application.application.gm_flag == 1) {
                    this.showAlert = true
                    let playPromise = x.play();
                    if(playPromise !== undefined){
                        playPromise.then(_ =>{
                            x.play();
                        })
                        .catch(error=>{
                            console.log("play error " + error)
                        })
                    }
                    document.getElementById("gas_slip").style.color = "red"
                }
            });
        }
    }
</script>