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
    Vue.use(VueTimeago, {
        name: 'Timeago', // Component name, `Timeago` by default
        locale: 'en', // Default locale
        // We use `date-fns` under the hood
        // So you can use all locales from it
        locales: {
            'zh-CN': require('date-fns/locale/zh_cn'),
            ja: require('date-fns/locale/ja')
        }
    })
    export default {
        props: ['department_id'],
        data() {
            return {
                notifications: []
            }
        },
        mounted() {
            let x = document.getElementById("myAudio");
            Echo.channel('application-tracker')
            .listen('NewMessage', (application) => {
                console.log(application)
                if (application.dm_flag == 1) {
                    this.notifications.unshift({
                        description: application.applicant.name + ' is applying for gas slip and was approved by the department manager',
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
                    document.getElementById('notifyBell').style.color = "red";
                }
                if(application.dm_flag == 0){
                    this.notifications.unshift({
                        description: application.applicant.name + ' is applying for gas slip under your department',
                        url: '/general_manager/application'
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
                    document.getElementById('notifyBell').style.color = "red";
                }
                
            });
        }
    }
</script>