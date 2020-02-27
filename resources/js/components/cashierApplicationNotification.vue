<template>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <i class="fa fa-bell" style="margin-top:10px;margin-right:10px;margin-left:10px;" id="notifyBell"></i>
        </a>
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
            Echo.channel('cashier-notification')
            .listen('CashierNotice', (application) => {
                if (application.application.gm_flag == 1) {
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