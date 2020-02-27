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
            Echo.channel('pizza-tracker')
            .listen('OrderStatusChanged', (application) => {
                if (this.department_id == application.department_id) {
                    this.showAlert = true
                }
            });
        }
    }
</script>