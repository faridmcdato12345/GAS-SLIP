<template>
    <li class="nav-item">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-haspopup="true">
            <i class="fa fa-bell hidden-xs" id="notifyBell"></i>
            <span class="notification-count label label-danger" v-if="notifications.length > 0">{{ notifications.length }}</span>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <li v-for="notification in notifications">
                <a :href="notification.url">
                    <div>
                        <i class="fa fa-exclamation-circle fa-fw"></i> {{ notification.description }}
                        <span class="pull-right text-muted small"></span>
                    </div>
                </a>
                <div class="divider"></div>
            </li>
        </ul>
    </li>
</template>

<script>
    import VueTimeago from 'vue-timeago'
    // Vue.use(VueTimeago, {
    //     name: 'Timeago', // Component name, `Timeago` by default
    //     locale: 'en', // Default locale
    //     // We use `date-fns` under the hood
    //     // So you can use all locales from it
    //     locales: {
    //         'zh-CN': require('date-fns/locale/zh_cn'),
    //         ja: require('date-fns/locale/ja')
    //     }
    // })
    export default {
        props: ['department_id'],
        data() {
            return {
                notifications: []
            }
        },
        mounted() {
            console.log('notifications mounted');
            let x = document.getElementById("myAudio");
            Echo.channel('pizza-tracker')
            .listen('OrderStatusChanged', (application) => {
                if (this.department_id == application.department_id && application.gm_flag != 2) {
                    this.notifications.unshift({
                        description: application.applicant.name + ' is applying for gas slip',
                        url: '/home'
                        // time: new Date()
                    })
                    let playPromise = x.play();
                    if(playPromise !== undefined){
                        playPromise.then(_ =>{
                            x.play();
                        })
                        .catch(error=>{
                            x.play();
                        })
                    }
                    document.getElementById('notifyBell').style.color = "#dc3545";
                }
                if(application.gm_flag == 2){
                    this.notifications.unshift({
                        description: application.applicant.name + ' application was disapproved by the General Manager',
                        url: '/applicant_disapproved'
                        // time: new Date()
                    })
                    let playPromise = x.play();
                    if(playPromise !== undefined){
                        playPromise.then(_ =>{
                            x.play();
                        })
                        .catch(error=>{
                            x.play();
                        })
                    }
                    document.getElementById('notifyBell').style.color = "#dc3545";
                }
            });
        }
    }
</script>